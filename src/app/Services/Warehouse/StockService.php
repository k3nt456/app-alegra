<?php

namespace App\Services\Warehouse;

use App\Models\Warehouse\PlaceHistory;
use App\Models\Warehouse\Stock;
use App\Traits\HasResponse;

class StockService
{
    use HasResponse;

    public function index()
    {
        $stockTotal = Stock::where('status', 1)->get()->load('food');
        $stockTotal = $this->structureStock($stockTotal);

        return view('warehouse.stock', compact('stockTotal'));
    }

    private function structureStock($stockTotal)
    {
        return $stockTotal->map(function ($stock) {
            return [
                'food_name'     => $stock->food->name,
                'amount'        => $stock->amount > 0 ? $stock->amount : 0,
                'status_text'   => $this->statusName($stock->status)
            ];
        });
    }

    public function indexPlaceHistory()
    {
        $placeHistorys = PlaceHistory::where('status', 1)->get()->load('food');
        $placeHistorys = $this->structurePlaceHistory($placeHistorys);

        return view('warehouse.placeHistory', compact('placeHistorys'));
    }

    private function structurePlaceHistory($stockTotal)
    {
        return $stockTotal->map(function ($stock) {
            return [
                'food_name'         => $stock->food->name,
                'purchased_amount'  => $stock->purchased_amount,
                'busy_time'         => $stock->busy_time
            ];
        });
    }
}
