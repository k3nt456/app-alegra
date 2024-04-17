<?php

namespace Database\Seeders\kitchen;

use App\Models\Kitchen\Orders;
use Illuminate\Database\Seeder;

class OrdersSeed extends Seeder
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
                'iduser'        => '6bd0d9bc-521b-4731-8a42-6c7399f96400',
                'idrecipe'      => 1,
                'busy_time'     => '00:00:10',
                'status'        => 1,
                'created_at'    => now()
            ]
        ];

        Orders::insert($data);
    }
}
