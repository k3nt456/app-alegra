<?php

namespace Database\Seeders\warehouse;

use App\Models\Warehouse\Stock;
use Illuminate\Database\Seeder;

class StockSeed extends Seeder
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
                'idfood' => 1,
                'amount' => 5
            ],
            [
                'idfood' => 2,
                'amount' => 5
            ],
            [
                'idfood' => 3,
                'amount' => 5
            ],
            [
                'idfood' => 4,
                'amount' => 5
            ],
            [
                'idfood' => 5,
                'amount' => 5
            ],
            [
                'idfood' => 6,
                'amount' => 5
            ],
            [
                'idfood' => 7,
                'amount' => 5
            ],
            [
                'idfood' => 8,
                'amount' => 5
            ],
            [
                'idfood' => 9,
                'amount' => 5
            ],
            [
                'idfood' => 10,
                'amount' => 5
            ],
        ];

        Stock::insert($data);
    }

    public function runDataFake()
    {
    }
}
