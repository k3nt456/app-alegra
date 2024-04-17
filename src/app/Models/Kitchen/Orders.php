<?php

namespace App\Models\Kitchen;

use App\Models\Kitchen\Food\Recipe;
use App\Models\User\User;
use App\Observers\OrdersObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'tbl_orders';

    protected $fillable = [
        'iduser',
        'idrecipe',
        'busy_time',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    #Observer del modelo
    protected static function boot()
    {
        parent::boot();
        Orders::observe(OrdersObserver::class);
    }

    # Relaciones
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'iduser');
    }

    public function recipe(): HasOne
    {
        return $this->hasOne(Recipe::class, 'id', 'idrecipe');
    }
}
