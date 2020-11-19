<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyUserControllerTest extends TestCase
{
    public function testItListsEntries()
    {
        $expected = Company::factory()->hasUsers()->create();

        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $this->get(route('companies.users.index', $expected))
             ->assertOk()
             ->assertJsonCount($expected->users->count());
    }

    public function testItAttachUserToEntity()
    {
        $this->withoutExceptionHandling();
        $expected = User::factory()->create();

        Sanctum::actingAs(
            User::factory()->create([
                'role' => User::ROLE_ADMIN,
            ])
        );

        $company = Company::factory()->create();
        $response = $this->post(route('companies.users.store', $company), [
            'id' => $expected->id,
        ]);

        $response->assertCreated()
                 ->assertJson([
                     'id'         => $expected->id,
                     'company_id' => $company->id,
                 ]);
    }
}