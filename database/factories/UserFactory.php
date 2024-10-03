<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'npp' => $this->faker->numberBetween(10000, 99999),
            'npp_supervisor' => $this->faker->optional()->numberBetween(10000, 99999),
            'password' => Hash::make('password'),
        ];
    }
}
