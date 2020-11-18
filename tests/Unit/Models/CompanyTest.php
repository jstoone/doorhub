<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testItDefaultsToBeingActive()
    {
        $company = Company::factory()->create();

        $this->assertTrue($company->is_active);
    }
}
