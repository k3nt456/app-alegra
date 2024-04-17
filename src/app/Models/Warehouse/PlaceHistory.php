<?php

namespace App\Models\Warehouse;

use App\Models\Kitchen\Food\Food;
use App\Observers\PlaceHistoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlaceHistory extends Model
{
    use HasFactory;

    protected $table = 'tbl_place_history';

    protected $fillable = [
        'idfood',
        'purchased_amount',
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
        PlaceHistory::observe(PlaceHistoryObserver::class);
    }

    # Relaciones
    public function food(): HasOne
    {
        return $this->hasOne(Food::class, 'id', 'idfood');
    }
}
