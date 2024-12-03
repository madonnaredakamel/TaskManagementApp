<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * Define the model's default state.
     * 
     *
     * @return array<string, mixed>
     */

     protected $model = Task::class;
    public function definition(): array
    {
        return [
            //

            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'assigned_user' => null, // We'll assign this in the seeder
        ];
    }
}
