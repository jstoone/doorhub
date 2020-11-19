<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use Laravel\Jetstream\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testItBelongsToACompany()
    {
        $user = User::factory()
            ->forCompany()
            ->create();

        $this->assertInstanceOf(Company::class, $user->company);
    }

    public function testItByDefaultHasRoleOfClient()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertSame(User::ROLE_CLIENT, $user->role->key);
        $this->assertSame(['read'], $user->role->permissions);
    }

    public function testItCanHaveRoleOfAdmin()
    {
        $user = User::factory()->admin()->create();

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertSame(User::ROLE_ADMIN, $user->role->key);
        $this->assertSame(['read'], $user->role->permissions);
    }
}
