<?php

namespace Database\Seeders\user;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
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
        $now = now();

        $data = [
            [
                'id'                    => '6bd0d9bc-521b-4731-8a42-6c7399f96400',
                'username'              => 'kento',
                'name'                  => 'Kent',
                'email'                 => 'kentolortigue@gmail.com',
                'password'              => Hash::make('demo'),
                'encrypted_password'    => Crypt::encryptString('demo'),
                'email_confirmation'    => 1,
                'idtype_user'           => 2,
                'created_at'            => $now
            ]
        ];

        User::insert($data);
    }

    public function runDataFake()
    {

    }
}
