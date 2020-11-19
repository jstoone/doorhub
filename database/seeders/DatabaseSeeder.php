<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // General admin user
        User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        // First User and Company pair.
        User::factory()
            ->forCompany()
            ->create();

        // Second User and Company pair.
        User::factory()
            ->forCompany()
            ->create();

        if (app()->runningInConsole()) {
            $token = User::first()->createToken('postman');

            $this->command->info(
                'Admin Access Token:'.$token->plainTextToken
            );
        }
    }
}
