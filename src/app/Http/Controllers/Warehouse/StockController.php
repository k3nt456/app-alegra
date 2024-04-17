<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Services\Warehouse\StockService;

class StockController extends Controller
{
    /** @var StockService */
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        return $this->stockService->index();
    }

    public function indexPlaceHistory()
    {
        return $this->stockService->indexPlaceHistory();
    }
}
