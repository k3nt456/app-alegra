<?php

namespace App\Http\Controllers\Kitchen\Resources;

use App\Models\Kitchen\Food\Food;
use App\Traits\HasResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    use HasResponse;

    public function toArray(Request $request): array
    {
        $ingredients = Food::whereIn('id', $this->ingredients)->get()->pluck('name')->toArray();
        $amounts = $this->amount_ingredients;

        $combinedIngredients = array_map(function ($amount, $ingredient) {
            return $ingredient . ' - ' . $amount;
        }, $amounts, $ingredients);

        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'ingredients'           => $this->ingredients,
            'amount_ingredients'    => $combinedIngredients,
            'preparation'           => $this->preparation,
            'status'                => $this->status,
            'status_text'           => $this->statusName($this->status)
        ];
    }
}
