<?php

namespace App\Observers;

use App\Models\Kitchen\Food\Recipe;
use App\Models\Kitchen\Orders;
use App\Models\Warehouse\Stock;

class OrdersObserver
{

    # Al crear
    public function created(Orders $orders): void
    {
        # Al realizar un plato reduzco el stock del ingrediente usado
        $recipe = Recipe::where('id', $orders->idrecipe)->first();

        foreach ($recipe->ingredients as $key => $ingredient) {
            Stock::where('idfood', $ingredient)->first()
                ->decrement('amount', $recipe->amount_ingredients[$key]);
        }
    }
}
