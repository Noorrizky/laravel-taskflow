<?php

// database/factories/ProjectFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->sentence(3); // "Marketing Campaign 2026"
        
        return [
            'user_id' => User::factory(), // Automatically creates a user if none exists
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['active', 'archived']),
        ];
    }
}
