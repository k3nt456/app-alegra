<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedUserRelatedData();
        $this->seedKitchenData();
        $this->seedWarehouseData();
    }

    # Usuarios
    private function seedUserRelatedData()
    {
        $this->call([
            \Database\Seeders\user\typeUser\TypeUserSeed::class,
            \Database\Seeders\user\UserSeed::class,
        ]);
    }

    # Comida, recetas y ordenes
    private function seedKitchenData()
    {
        $this->call([
            \Database\Seeders\kitchen\food\FoodSeed::class,
            \Database\Seeders\kitchen\food\RecipeSeed::class,
            \Database\Seeders\kitchen\OrdersSeed::class
        ]);
    }

    # Bodegas
    private function seedWarehouseData()
    {
        $this->call([
            \Database\Seeders\warehouse\StockSeed::class,
            \Database\Seeders\warehouse\PlaceHistorySeed::class
        ]);
    }
}
