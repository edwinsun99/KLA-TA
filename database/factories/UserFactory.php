<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'username'      => fake()->userName(),
        'email'         => fake()->unique()->safeEmail(),
        'profile_photo' => null, // Kita set null dulu buat testing
        'password'      => bcrypt('password'), // Password default buat semua dummy
        'role'          => fake()->randomElement(['CE', 'CS']), // Pilih role random
        'branch_id'     => fake()->randomElement([1, 2, 3, 4, 5, null]), // Random branch
        'created_at'    => now(),
        'updated_at'    => now(),
    ];
}

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
