<?php

namespace App\Services\Kitchen;

use App\Http\Controllers\Kitchen\Resources\RecipeResource;
use App\Models\Kitchen\Food\Food;
use App\Models\Kitchen\Food\Recipe;
use App\Models\Kitchen\Orders;
use App\Traits\HasResponse;

class RecipeService
{
    use HasResponse;

    public function index()
    {
        $recipes = Recipe::where('status', 1)->get();
        $recipesTransformed = $this->structureRecipes($recipes);

        return view('kitchen.recipes', compact('recipesTransformed'));
    }

    private function structureRecipes($recipes)
    {
        return $recipes->map(function ($recipe) {
            $ingredients = Food::whereIn('id', $recipe->ingredients)->pluck('name')->toArray();
            $amounts = $recipe->amount_ingredients;

            $combinedIngredients = array_map(function ($amount, $ingredient) {
                return $ingredient . ' - ' . $amount . ($amount > 1 ? ' unidades' : ' unidad');
            }, $amounts, $ingredients);

            return [
                'name'              => $recipe->name,
                'ingredients'       => $combinedIngredients,
                'preparation'       => $recipe->preparation,
                'dishes_delivered'  => Orders::where('idrecipe', $recipe->id)->count(),
                'status_text'       => $this->statusName($recipe->status)
            ];
        });
    }
}
