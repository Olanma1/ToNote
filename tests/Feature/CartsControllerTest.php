<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_cart_products(): void
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('get.cart.products'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'message' => 'You have fetched all the product in your cart'
            ]);
        $this->assertDatabaseHas('carts', [
                'product_id' => $cart->product_id,
        ]);
    }

    public function test_add_products_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $kafkaProducer = Mockery::mock('KafkaProducer');
        $kafkaProducer->shouldReceive('cartItem')->once()->andReturn(true);

        // Inject the mocked Kafka producer into the container
        $this->app->instance('KafkaProducer', $kafkaProducer);

        $response = $this->actingAs($user)
            ->postJson(route('add.cart', [
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
                'user_id' => $user->id
            ]));

            $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'user_id' => $user->id
                ],
                'message' => 'You have added product to cart'
            ]);
            $kafkaProducer->shouldHaveReceived('cartItem')->once();
        $this->assertNotEmpty($response->json()['data']);
    }
}
