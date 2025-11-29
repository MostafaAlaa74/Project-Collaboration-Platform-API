<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class taskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            // Must match enum values defined in the tasks table migration
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'done']),
            'priority' => $this->faker->randomElement(['low', 'high']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'project_id' => \App\Models\Project::factory(),
        ];
    }
}
