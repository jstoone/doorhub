<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testItListsEntriesForAdmins()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $this->get(route('users.index'))
             ->assertOk()
             ->assertJsonCount(User::count());
    }

    public function testItDoesNotListEntriesForClients()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_CLIENT,
            ])
        );

        $this->get(route('users.index'))
             ->assertForbidden();
    }

    public function testItCanSeeRelatedEntity()
    {
        Sanctum::actingAs(
            $expectedUser = User::factory()->create()
        );

        $this->get(route('users.show', $expectedUser))
             ->assertOk()
             ->assertJson([
                 'id' => $expectedUser->id,
             ]);
    }

    public function testItCannotSeeUnelatedEntity()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $unrelatedUser = User::factory()->create();
        $this->get(route('users.show', $unrelatedUser))
             ->assertForbidden();
    }

    public function testItCanSeeUnrelatedEntityAsAdmin()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $unrelatedUser = User::factory()->create();
        $this->get(route('users.show', $unrelatedUser))
             ->assertOk();
    }

    public function testItCanBeCreatedByAdmins()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $expected = User::factory()->make();

        $response = $this->post(route('users.store'),
            $expected->toArray() + [
                'password' => 'password',
            ]
        );

        $response->assertCreated()
                 ->assertJson(
                     $expected->toArray()
                 );

        $this->assertDatabaseCount('users', 2);
    }
}
