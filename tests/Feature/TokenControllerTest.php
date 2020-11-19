<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    public function testUserCanCreateNewToken()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/token', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $expectedToken = $user->tokens()->first();
        $response->assertStatus(200)
                 ->assertJson([
                     'accessToken' => [
                         'name' => $expectedToken->name,
                         'id'   => $expectedToken->id,
                     ],
                 ]);
    }
}
