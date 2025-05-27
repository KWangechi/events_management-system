<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::inRandomOrder()->value('id'),
            'title' => fake()->name(),
            'description' => fake()->text(20),
            'venue' => fake()->streetName(),
            'date' => fake()->date(),
            'price' => fake()->randomFloat(2, 1, 1500),
            'max_attendees' => fake()->numberBetween(1, 6000),
        ];
    }
}
