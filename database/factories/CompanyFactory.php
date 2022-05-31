<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'introduce' => $this->faker->sentences(3, true),
            'phone' => $this->faker->phoneNumber(),
            'logo' => $this->faker->imageUrl(),
            'tax_num' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['on', 'off']),
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->address(),
            'staff_num' => mt_rand(0, 100)
        ];
    }
}
