<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
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
            'nama_lengkap' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'role' => 'petugas',
            'status_aktif' => true,
            'password' => static::$password ??= Hash::make('password'),
        ];
    }

    /**
     * Keep compatibility with test suites that call this factory state.
     */
    public function unverified(): static
    {
        return $this;
    }
}
