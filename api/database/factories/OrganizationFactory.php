<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'slug' => substr(preg_replace('/[^a-z]/', '', strtolower(fake()->unique()->slug())), 0, 15),
        ];
    }

    /**
     * Indicate that the model's name is 'Default Organization'.
     *
     * @return static
     */
    // public function default(): static
    // {
    //     return $this->state(fn(array $attributes) => [
    //         'name' => 'Default Organization',
    //         'slug' => 'default-organization',
    //     ]);
    // }
}
