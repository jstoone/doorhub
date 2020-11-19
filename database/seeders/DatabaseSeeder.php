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
            'email' => 'admin@example.com',
            'role'  => User::ROLE_ADMIN,
        ]);

        // First User and Company pair.
        User::factory()->forCompany()->create([
            'email' => 'john@example.com',
        ]);

        // Second User and Company pair.
        User::factory()->forCompany()->create([
            'email' => 'jane@example.com',
        ]);

        if (app()->runningInConsole()) {
            $token = User::first()->createToken('postman');

            $this->command->info(
                'Admin Access Token:'.$token->plainTextToken
            );
        }
    }
}
