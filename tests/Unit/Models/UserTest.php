<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserBelongsToOneCompany()
    {
        $user = User::factory()
            ->forCompany()
            ->create();

        $this->assertInstanceOf(Company::class, $user->company);
    }
}
