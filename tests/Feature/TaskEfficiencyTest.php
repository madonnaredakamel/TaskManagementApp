<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;

class TaskEfficiencyTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function it_calculates_task_efficiency_correctly()
    {
        // Create 5 tasks in total
        Task::factory()->count(5)->create();  // 5 tasks, not completed by default

        // Manually mark 2 tasks as completed
        $completedTasks = Task::take(2)->get();
        $completedTasks->each->update(['completed_at' => now()]);

        // Get task efficiency using the method to be tested (you would have this in the controller)
        $efficiency = (new \App\Http\Controllers\TaskController)->getTaskEfficiency();

        // Calculate expected efficiency manually: (2 completed / 5 total) * 100 = 40%
        $expectedEfficiency = (2 / 5) * 100;

        // Assert that the calculated efficiency is correct
        $this->assertEquals($expectedEfficiency, $efficiency);
    }

    /** @test */
    public function it_handles_zero_tasks_gracefully()
    {
        // No tasks in the database
        $efficiency = (new \App\Http\Controllers\TaskController)->getTaskEfficiency();

        // Assert that efficiency is 0 when there are no tasks
        $this->assertEquals(expected: 0,$efficiency);
    }
}
