<?php

namespace App\Services\Kitchen;

use App\Models\Kitchen\Food\Food;
use App\Models\Kitchen\Food\Recipe;
use App\Models\Kitchen\Orders;
use App\Models\Warehouse\PlaceHistory;
use App\Models\Warehouse\Stock;
use App\Traits\HasResponse;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersService
{
    use HasResponse;
    private $alegraApi;

    public function __construct()
    {
        $this->alegraApi = getenv('API_ALEGRA');
    }

    public function index()
    {
        $ordersTotal = Orders::all()->load('user', 'recipe');
        $orders = $this->structureOrders($ordersTotal);

        return view('kitchen.orders', compact('orders'));
    }


    private function structureOrders($ordersTotal)
    {
        return $ordersTotal->map(function ($orders) {

            return [
                'user'          => $orders->user->name,
                'recipe'        => $orders->recipe->name,
                'busy_time'     => $orders->busy_time,
                'date_creation' => Carbon::parse($orders->created_at)->diffForHumans(),
                'status_text'   => $this->statusName($orders->status)
            ];
        });
    }

    private function statusName($status)
    {
        switch ($status) {
            case 0:
                $statusText = 'Pendiente';
                break;
            case 1:
                $statusText = 'Entregado';
                break;
            case 2:
                $statusText = 'Eliminado';
                break;

            case 3:
                $statusText = 'No completado';
                break;

            default:
                $statusText = 'Estado desconocido';
                break;
        }

        return $statusText;
    }

    public function randomOrders($params)
    {
        $recipes = Recipe::inRandomOrder()->take($params['count'])->get();
        return $this->successResponse('Lectura exitosa.', $recipes);
    }

    # Guardar las órdenes
    public function store($params)
    {
        try {
            # Verificar que sea un gerente o superior
            if (Auth::user()->typeUser->id > 2) return $this->errorResponse('Solo un gerente o superior puede realizar esta operación.', 400);

            # Preparar los platos
            $validate = $this->prepareDish($params['recipes']);
            if (!$validate->original['status']) return $validate;

            $response = $this->responseFormat(count($params['recipes']));

            return view('kitchen.kitchen', compact('response'));
        } catch (\Throwable $th) {
            return $this->externalError('durante la preparación del o los platos.', $th->getMessage());
        }
    }

    public function responseFormat($recipes): string
    {
        $message = 'Su órden esta lista. Esperamos que lo disfrute.';
        if ($recipes > 1) $message = 'Sus ' . $recipes . ' órdenes estan listas. Esperamos que disfruten de sus platos.';

        return $message;
    }

    private function prepareDish($arrayRecipes)
    {
        try {
            # Obtener el tiempo inicial
            $startTime = microtime(true);

            # Verificar los platos recibidos
            $recipes = $this->checkDishes($arrayRecipes);

            # Verificar existencia de ingredientes necesarios
            $checkIngredients = $this->checkIngredients($recipes);

            # Comprar ingredientes faltantes
            $this->buyIngredients($checkIngredients);

            # Obtener el tiempo final
            $endTime = microtime(true);

            # Iniciara preparar los platos a entregar, genera un array que luego será insertado
            $startPreparation = $this->startPreparation($recipes, $endTime - $startTime);

            return $this->successResponse('OK', $startPreparation);
        } catch (\Throwable $th) {
            return $this->externalError('durante la preparación del o los platos.', $th->getMessage());
        }
    }

    private function checkDishes($arrayRecipes): object
    {

        $recipes = Recipe::whereIn('id', $arrayRecipes)->get();

        if ($recipes->count() !== count($arrayRecipes)) return $this->errorResponse('No se encontraron los platos solicitados', 400);

        return $recipes;
    }

    private function checkIngredients($recipes): array
    {
        $data = [];

        # Obtener todos los ingredientes únicos necesarios
        $uniqueIngredients = collect($recipes)->flatMap(function ($recipe) {
            return $recipe->ingredients;
        })->unique();

        # Iterar sobre los ingredientes únicos
        foreach ($uniqueIngredients as $ingredientId) {
            # Obtener el modelo Food del ingrediente
            $ingredient = Food::find($ingredientId);

            if (!$ingredient) {
                # Si el ingrediente no existe, no se puede preparar ningún plato que lo contenga
                continue;
            }

            # Obtener el stock del ingrediente
            $stock = Stock::where('idfood', $ingredientId)->value('amount');

            # Calcular la cantidad total necesaria de este ingrediente para todos los platos
            $totalNeeded = collect($recipes)->sum(function ($recipe) use ($ingredientId) {
                $index = array_search($ingredientId, $recipe->ingredients);
                return $index !== false ? $recipe->amount_ingredients[$index] : 0;
            });

            # Calcular la cantidad que necesitas comprar
            $amountToBuy = max(0, $totalNeeded - $stock);

            # Agregar el ingrediente y la cantidad a comprar al array $data
            $data[$ingredient->name] = $amountToBuy;
        }

        return $data;
    }

    private function buyIngredients($data): void
    {
        if (array_sum($data) == 0) return;

        # Iterar sobre cada ingrediente del array $data
        try {
            DB::beginTransaction();

            while (array_sum($data) > 0) {
                foreach (array_keys($data) as $ingredient) {

                    if ($data[$ingredient] > 0) {

                        # Ir a comprar el ingrediente
                        $shoppingResult = $this->goShopping($ingredient);

                        # Guardar el registro en PlaceHistory
                        PlaceHistory::create([
                            'idfood'            => Food::where('name', $ingredient)->first()->id,
                            'purchased_amount'  => $shoppingResult['quantitySold'],
                            'busy_time'         => $shoppingResult['busyTime']
                        ]);

                        # Restar la cantidad vendida del ingrediente del array $data
                        $data[$ingredient] -= $shoppingResult['quantitySold'];

                        # Verificar si el ingrediente está completo
                        if ($data[$ingredient] <= 0) {
                            unset($data[$ingredient]); # Eliminar el ingrediente del array si está completo
                        }
                    }
                }
            }
            DB::commit();
            return;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function goShopping($ingredient): array
    {
        # Inicializar un cliente Guzzle para realizar solicitudes HTTP
        $client = new Client();

        try {
            # Realizar la solicitud a la API para comprar el ingrediente
            $response = $client->get($this->alegraApi, [
                'query' => [
                    'ingredient' => $ingredient
                ]
            ]);

            # Obtener la cantidad vendida del ingrediente en la plaza
            $body = json_decode($response->getBody(), true);
            $quantitySold = $body['quanitySold'] ?? 0;

            # Calcular el tiempo de respuesta de la API
            $busyTime = $response->getHeader('X-Response-Time')[0] ?? '00:00:00';

            return [
                'quantitySold'  => $quantitySold,
                'busyTime'      => $busyTime
            ];
        } catch (\Throwable $e) {
            # En caso de error de la api se realiza la simulación de las respuestas con otra función
            return $this->alternativeApi();
        }
    }

    private function alternativeApi(): array
    {
        # Generar un número aleatorio del 0 al 5
        $quantitySold = rand(0, 5);
        $busyTime = '00:00:00';

        return [
            'quantitySold'  => $quantitySold,
            'busyTime'      => $busyTime
        ];
    }

    private function startPreparation($recipes, $time)
    {
        $time = gmdate("H:i:s", $time);
        try {
            DB::beginTransaction();
            foreach ($recipes as $recipe) {
                # Para preparar un platillo necesito crear los registros
                Orders::create([
                    'iduser'    => Auth::user()->id,
                    'idrecipe'  => $recipe->id,
                    'busy_time' => $time,
                    'status'    => 1
                ]);
                # La reducción de stock se hace por medio de un observer
            }
            DB::commit();
            return $this->successResponse('OK', $recipes);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la preparación del o los platos.', $th->getMessage());
        }
    }
}
