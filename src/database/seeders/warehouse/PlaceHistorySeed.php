<?php

namespace Database\Seeders\warehouse;

use App\Models\Warehouse\PlaceHistory;
use Illuminate\Database\Seeder;

class PlaceHistorySeed extends Seeder
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
    }

    public function runDataFake()
    {
        $data = [
            [
                'idfood'            => 1,
                'purchased_amount'  => 1,
                'busy_time'         => '00:00:01'
            ]
        ];

        PlaceHistory::insert($data);
    }
}
