<?php

namespace App\Observers;

use App\Models\Warehouse\PlaceHistory;
use App\Models\Warehouse\Stock;

class PlaceHistoryObserver
{
    # Al crear
    public function created(PlaceHistory $placeHistory): void
    {
        # Al realizar una compra aumento el stock del ingrediente
        if ($placeHistory->purchased_amount > 0) {
            Stock::where('idfood', $placeHistory->idfood)->first()
                ->increment('amount', $placeHistory->purchased_amount);
        }
    }
}
