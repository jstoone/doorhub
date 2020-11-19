<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testItListsEntriesForAdmins()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $companies = Company::factory()->count(5)->create();

        $response = $this->get(route('companies.index'));

        $response->assertStatus(200)
            ->assertJsonCount($companies->count());
    }

    public function testItDoesNotListEntriesForClients()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_CLIENT,
            ])
        );

        $companies = Company::factory()->count(5)->create();

        $response = $this->get('/api/companies');

        $response->assertForbidden();
    }

    public function testItCanSeeRelatedEntity()
    {
        $user = User::factory()->forCompany()->create();

        Sanctum::actingAs($user);

        $response = $this->get(route('companies.show', $user->company));

        $response->assertOk()
                 ->assertJson([
                     'id' => $user->company->id,
                 ]);
    }

    public function testItCannotSeeUnrelatedEntity()
    {
        $user = User::factory()->forCompany()->create();

        Sanctum::actingAs($user);

        $unrelatedCompany = Company::factory()->create();
        $response = $this->get(route('companies.show', $unrelatedCompany));

        $response->assertForbidden();
    }

    public function testItCanBeCreatedByAdmins()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $expectedCompany = Company::factory()->make();
        $response = $this->post(
            route('companies.store'),
            $expectedCompany->toArray()
        );

        $response->assertCreated()
                 ->assertJson(
                     $expectedCompany->toArray()
                 );

        $this->assertDatabaseCount('companies', 1);
    }

    public function testItCannotBeCreatedByClients()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_CLIENT,
            ])
        );

        $expectedCompany = Company::factory()->make();
        $response = $this->post(
            route('companies.store'),
            $expectedCompany->toArray()
        );

        $response->assertForbidden();
        $this->assertDatabaseCount('companies', 0);
    }
}
