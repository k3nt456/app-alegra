<?php

namespace App\Models\Kitchen\Food;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'tbl_recipe';

    protected $fillable = [
        'name',
        'ingredients',
        'amount_ingredients',
        'preparation',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'amount_ingredients' => 'array'
    ];

}
