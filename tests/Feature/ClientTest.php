<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class ClientTest extends TestCase
{
    public function testIndex()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/liberfly/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'phone',
                        'address',
                        'email',
                        'created_at',
                    ],
                ],
            ]);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/liberfly/clients/' . $client->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'phone' => $client->phone,
                    'address' => $client->address,
                    'email' => $client->email,
                    'created_at' => $client->created_at,
                ],
            ]);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $clientData = [
            'name' => 'Eduardo Pires Lucio',
            'phone' => '44998163466',
            'address' => 'Rua Tal, 30045',
            'email' => 'eduardopireslucio' . Str::random(3) . '@gmail.com',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/liberfly/clients', $clientData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $clientData['name'],
                    'phone' => $clientData['phone'],
                    'address' => $clientData['address'],
                    'email' => $clientData['email'],
                ],
            ]);

        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'phone' => $clientData['phone'],
            'address' => $clientData['address'],
            'email' => $clientData['email'],
        ]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = JWTAuth::fromUser($user);

        $updatedData = [
            'phone' => '44998163466',
            'address' => 'Rua Liberfly',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/liberfly/clients/' . $client->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $client->name,
                    'phone' => $updatedData['phone'],
                    'address' => $updatedData['address'],
                    'email' => $client->email,
                    'created_at' => $client->created_at,
                ],
            ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'phone' => $updatedData['phone'],
            'address' => $updatedData['address'],
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', '/api/liberfly/clients/' . $client->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
