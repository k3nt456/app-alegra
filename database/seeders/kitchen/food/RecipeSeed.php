<?php

namespace Database\Seeders\kitchen\food;

use App\Models\Kitchen\Food\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeed extends Seeder
{
    #Elegir entre entorno de desarrollo o producción
    public function run()
    {
        $this->runDataDefault();
        if (env('APP_ENV') === 'local') {
            $this->runDataFake();
        }
    }

    public function runDataDefault()
    {

        $data = [
            [
                'name' => 'Ensalada Mediterránea',
                'ingredients' => json_encode([1, 5, 6, 7]),
                'amount_ingredients' => json_encode([1, 1, 1, 1]),
                'preparation' => 'Corta los tomates en rodajas, la lechuga en trozos y la cebolla en rodajas finas. Mezcla todos los ingredientes en un tazón grande y aliña con aceite de oliva, vinagre, sal y pimienta al gusto.'
            ],
            [
                'name' => 'Arroz al limón con pollo',
                'ingredients' => json_encode([2, 4, 10]),
                'amount_ingredients' => json_encode([1, 1, 1]),
                'preparation' => 'Cocina el arroz según las instrucciones del paquete. Mientras tanto, corta el pollo en trozos y marínalo con jugo de limón, sal y pimienta. Luego, cocina el pollo en una sartén hasta que esté dorado. Sirve el arroz con el pollo encima y exprime un poco más de limón sobre el plato antes de servir.'
            ],
            [
                'name' => 'Papas rellenas de carne y queso',
                'ingredients' => json_encode([3, 8, 9]),
                'amount_ingredients' => json_encode([1, 1, 1]),
                'preparation' => 'Hornea las papas hasta que estén tiernas. Corta cada papa por la mitad y retira parte de la pulpa. Rellena las papas con la carne previamente cocida y desmenuzada, y añade queso encima. Vuelve a hornear hasta que el queso se derrita.'
            ],
            [
                'name' => 'Salsa de tomate casera',
                'ingredients' => json_encode([1, 2, 7]),
                'amount_ingredients' => json_encode([1, 1, 1]),
                'preparation' => 'Cocina las cebollas picadas en un poco de aceite hasta que estén suaves. Agrega los tomates picados y deja cocinar a fuego lento hasta que se deshagan. Exprime el jugo de limón y cocina por unos minutos más. Tritura la mezcla y sírvela como salsa.'
            ],
            [
                'name' => 'Pollo al horno con papas y cebolla',
                'ingredients' => json_encode([3, 7, 10]),
                'amount_ingredients' => json_encode([1, 1, 1]),
                'preparation' => 'Corta las papas y la cebolla en rodajas. Colócalas en una bandeja para hornear junto con el pollo. Rocía con aceite de oliva, sal, pimienta y cualquier otra especia de tu elección. Hornea hasta que el pollo esté cocido y las papas estén doradas.'
            ],
            [
                'name' => 'Ensalada de queso y pollo',
                'ingredients' => json_encode([6, 8, 10]),
                'amount_ingredients' => json_encode([1, 1, 1]),
                'preparation' => 'Corta el queso y el pollo en cubos. Mezcla con la lechuga en un tazón grande. Puedes agregar otros ingredientes como tomate o cebolla si lo deseas. Aliña con tu aderezo favorito y sirve.'
            ]
        ];

        Recipe::insert($data);
    }

    public function runDataFake()
    {
    }
}
