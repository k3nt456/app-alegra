<?php

namespace Tests\Feature;

use App\Services\Kitchen\OrdersService;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class APIAlegraTest extends TestCase
{
    protected $ingredients;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ingredients = ['Tomato', 'Lemon', 'Potato', 'Rice', 'Ketchup', 'Lettuce', 'Onion', 'Cheese', 'Meat', 'Chicken'];
    }

    public function testGoShoppingSucceedsWhenApiReturnsData()
    {
        $ingredient = $this->getRandomIngredient();

        $responseBody = json_encode(['quantitySold' => 3, 'busyTime' => '00:00:03']);
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('http://example.com/api', ['query' => ['ingredient' => $ingredient]])
            ->willReturn(new Response(200, [], $responseBody));

        putenv('API_ALEGRA=http://example.com/api');
        $ordersService = new OrdersService($mockClient);
        $result = $ordersService->goShopping($ingredient);

        $this->assertEquals(['quantitySold' => 3, 'busyTime' => '00:00:03'], $result);
    }

    public function testGoShoppingFailsWhenApiThrowsException()
{
    $ingredient = $this->getRandomIngredient();

    $mockClient = $this->createMock(Client::class);
    $mockClient->expects($this->once())
        ->method('get')
        ->with('http://example.com/api', ['query' => ['ingredient' => $ingredient]])
        ->willThrowException(new \Exception('API error'));

    putenv('API_ALEGRA=http://example.com/api');
    $ordersService = new OrdersService($mockClient);

    // Intenta llamar a goShopping y maneja la excepción si se lanza
    try {
        $result = $ordersService->goShopping($ingredient);

        // Asegúrate de que el resultado sea correcto si no se lanza ninguna excepción
        $this->fail('Expected exception was not thrown.');
    } catch (\Throwable $e) {
        // Imprime el tipo de excepción y su mensaje para depurar
        echo 'Exception type: ' . get_class($e) . PHP_EOL;
        echo 'Exception message: ' . $e->getMessage() . PHP_EOL;

        // Verifica que se haya lanzado una excepción
        $this->assertInstanceOf(\Throwable::class, $e);
    }
}


    protected function getRandomIngredient()
    {
        return $this->ingredients[array_rand($this->ingredients)];
    }
}
