<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_products(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('products'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    "current_page" => 1,
                    "data" => [],
                    "first_page_url" => "http://localhost/api/allProducts?page=1",
                ],
                'message' => 'You have successfully fetched all available products'
            ]);
    }
}
