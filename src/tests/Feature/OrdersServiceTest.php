<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrdersServiceTest extends TestCase
{
    public function testResponseFormatWithSingleRecipe()
    {
        $ordersService = new \App\Services\Kitchen\OrdersService();
        $message = $ordersService->responseFormat(1);

        $this->assertEquals('Su órden esta lista. Esperamos que lo disfrute.', $message);
    }

    public function testResponseFormatWithMultipleRecipes()
    {
        $ordersService = new \App\Services\Kitchen\OrdersService();
        $message = $ordersService->responseFormat(3);

        $this->assertEquals('Sus 3 órdenes estan listas. Esperamos que disfruten de sus platos.', $message);
    }
}
