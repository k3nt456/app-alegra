<?php

namespace App\Models\Kitchen\Food;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'tbl_food';

    protected $fillable = [
        'name',
        'referential_image',
        'status'
    ];
}
