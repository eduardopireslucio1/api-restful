<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $userData = [
            'name' => 'Eduardo Pires Lucio',
            'email' => 'eduardopires' . Str::random(3) . '@gmail.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/liberfly/register', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function testLogin()
    {
        $user = User::factory()->create();

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->post('/api/liberfly/login', $credentials);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
            ],
            'access_token',
            'token_type',
        ]);
    }
}
