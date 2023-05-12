<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'username' => 'olanma',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('user.login', [
                'username' => 'olanma',
                'password' => 'password',
            ]));

        $this->assertAuthenticated();

        $response->assertStatus(200)
              ->assertJson([
                    'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'username' => $user->username,
                        ],
                ]);
        $this->assertNotEmpty($response->json()['user'],'token');
    }

    public function test_user_can_not_login_if_user_do_not_exist(): void
    {
        $user = User::factory()->create([
            'username' => 'olanma',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('user.login', [
                'username' => 'pay',
                'password' => 'password',
            ]));

        $response->assertStatus(401);
    }
}
