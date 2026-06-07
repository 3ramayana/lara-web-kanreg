<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'thumbnail' => 'dummy.jpg',
            'link' => fake()->url(),
            'document' => 'dummy.pdf',
            'category' => fake()->randomElement(['pensiun', 'mutasi', 'cat', 'pengaktifan', 'pengangkatan', 'peremajaan', 'janda_duda']),
            'periode' => fake()->word(),
        ];
    }
}
