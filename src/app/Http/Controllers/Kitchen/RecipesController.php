<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Services\Kitchen\RecipeService;

class RecipesController extends Controller
{
    /** @var RecipeService */
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function index()
    {
        return $this->recipeService->index();
    }
}
