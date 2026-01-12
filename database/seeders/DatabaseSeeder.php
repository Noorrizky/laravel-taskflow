<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    // database/seeders/DatabaseSeeder.php
    public function run(): void
    {
        // 1. Create YOUR account (so you can login)
        $me = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create 10 Random Users
        $users = \App\Models\User::factory(10)->create();

        // 3. Create 5 Projects for YOU
        \App\Models\Project::factory(5)
            ->hasTasks(10) // Each project gets 10 tasks
            ->recycle($users) // Assign tasks randomly to the 10 users we created above
            ->create([
                'user_id' => $me->id,
            ]);
    }
}
