<?php

namespace App\Models\Warehouse;

use App\Models\Kitchen\Food\Food;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'tbl_stocks';

    protected $fillable = [
        'idfood',
        'amount',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    # Relaciones
    public function food(): HasOne
    {
        return $this->hasOne(Food::class, 'id', 'idfood');
    }
}
