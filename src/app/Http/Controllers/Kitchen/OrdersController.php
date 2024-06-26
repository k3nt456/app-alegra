<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Kitchen\Requests\OrdersRequest;
use App\Http\Controllers\Kitchen\Requests\RamdomOrdersRequest;
use App\Services\Kitchen\OrdersService;

class OrdersController extends Controller
{
    /** @var OrdersService */
    private $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    public function index()
    {
        return $this->ordersService->index();
    }

    public function randomOrders(RamdomOrdersRequest $request)
    {
        return $this->ordersService->randomOrders($request->validated());
    }

    public function store(OrdersRequest $request)
    {
        return $this->ordersService->store($request->validated());
    }
}
