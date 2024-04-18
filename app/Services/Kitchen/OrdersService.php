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

    # Guardar las órdenes
    public function store($params)
    {
        try {
            # Verificar que sea un gerente o superior
            if (Auth::user()->typeUser->id > 2) {
                return $this->errorResponse('Solo un gerente o superior puede realizar esta operación.', 400);
            }

            # Preparar los platos
            $validate = $this->prepareDish($params['count']);
            if (!$validate->original['status']) return $validate;

            $response = $this->responseFormat($params['count']);

            return view('kitchen.kitchen', compact('response'));
        } catch (\Throwable $th) {
            return $this->externalError('durante la preparación del o los platos.', $th->getMessage());
        }
    }

    private function responseFormat($count): string
    {
        $message = 'Su órden esta lista. Esperamos que lo disfrute.';
        if ($count > 1) $message = 'Sus' . $count . ' órdenes estan listas. Esperamos que disfruten de sus platos.';

        return $message;
    }

    private function prepareDish($count)
    {
        try {
            # Obtener el tiempo inicial
            $startTime = microtime(true);

            # Obtener platos aleatorios
            $recipes = $this->chooseRandomDishes($count);

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

    private function chooseRandomDishes($count): object
    {
        $recipes = Recipe::inRandomOrder()->take($count)->get();

        return $recipes;
    }

    private function checkIngredients($recipes): array
    {
        $data = [];

        # Itero los platos que solicitaron
        foreach ($recipes as $recipe) {

            # Verifico que exista el ingrediente de cada plato
            foreach ($recipe->ingredients as $key => $ingredientid) {

                # Lectura del ingrediente y su stock
                $ingredient = Food::find($ingredientid);
                $stock = Stock::where('idfood', $ingredientid)->first();
                $stock = $stock->amount;

                # De manera inicial guardo el ingrediente, lo inicializo en 0 y verifico si la clave ya existe antes de agregarla
                if (!array_key_exists($ingredient->name, $data)) {
                    $data[$ingredient->name] = 0;
                }

                # En caso que el stock sea menor a lo que pide un ingrediente, añado a la data que pediré por la API
                if ($stock <= $recipe->amount_ingredients[$key]) {
                    # Añado los ingredientes faltantes restando lo que tenga en base al stock
                    if ($stock == 0) {
                        $data[$ingredient->name] += $recipe->amount_ingredients[$key];
                    } else {
                        $data[$ingredient->name] += $recipe->amount_ingredients[$key] - $stock;
                        $stock = 0;
                    }
                } else {
                    # Caso contrario resto el stock con los ingredientes que usaré
                    $stock -= $recipe->amount_ingredients[$key];
                }
            }
        }

        return $data;
    }

    private function buyIngredients($data): void
    {
        # Inicializar un cliente Guzzle para realizar solicitudes HTTP
        $client = new Client();

        # Iterar sobre cada ingrediente del array $data
        foreach (array_keys($data) as $ingredient) {
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

            # Guardar el registro en PlaceHistory
            PlaceHistory::create([
                'idfood'            => Food::where('name', $ingredient)->first()->id,
                'purchased_amount'  => $quantitySold,
                'busy_time'         => $busyTime
            ]);

            # Restar la cantidad vendida del ingrediente del array $data
            $data[$ingredient] -= $quantitySold;

            # Verificar si el ingrediente está completo
            if ($data[$ingredient] <= 0) {
                unset($data[$ingredient]); # Eliminar el ingrediente del array si está completo
            }
        }
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
