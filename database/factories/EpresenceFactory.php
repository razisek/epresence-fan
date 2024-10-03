<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpresenceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_users' => User::factory(),
            'type' => $this->faker->randomElement(['IN', 'OUT']),
            'is_approve' => $this->faker->boolean(),
            'waktu' => $this->faker->dateTimeThisYear(),
        ];
    }
}
