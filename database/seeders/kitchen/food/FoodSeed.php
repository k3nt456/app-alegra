<?php

namespace Database\Seeders\kitchen\food;

use App\Models\Kitchen\Food\Food;
use Illuminate\Database\Seeder;

class FoodSeed extends Seeder
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
            ['name' => 'Tomato',],
            ['name' => 'Lemon'],
            ['name' => 'Potato'],
            ['name' => 'Rice'],
            ['name' => 'Ketchup'],
            ['name' => 'Lettuce'],
            ['name' => 'Onion'],
            ['name' => 'Cheese'],
            ['name' => 'Meat'],
            ['name' => 'Chicken']
        ];

        Food::insert($data);
    }

    public function runDataFake()
    {
    }
}
