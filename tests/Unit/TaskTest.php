<?php

namespace Tests\Unit;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        // Arrange: Prepare task data
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'pending',
            'priority' => 'high',
        ];

        // Act: Create a task
        $task = Task::create($taskData);

        // Assert: Check if the task was created successfully
        $this->assertDatabaseHas('tasks', $taskData);
        $this->assertEquals('Test Task', $task->title);
        $this->assertEquals('pending', $task->status);
    }


    /** @test */
    public function it_can_update_task_status()
    {
        // Arrange: Create a task
        $task = Task::factory()->create(['status' => 'pending']);

        // Act: Update the task's status
        $task->update(['status' => 'completed']);

        // Assert: Verify the status was updated
        $this->assertEquals('completed', $task->status);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }


    public function it_can_assign_a_task_to_a_user()
    {
        // Arrange: Create a user and a task
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => null]);

        // Act: Assign the task to the user
        $task->update(['user_id' => $user->id]);

        // Assert: Verify the task is assigned to the user
        $this->assertEquals($user->id, $task->user_id);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'user_id' => $user->id]);
    }


    public function it_can_calculate_task_efficiency()
    {
        // Arrange: Create tasks with different statuses
        Task::factory()->count(3)->create(['updated_at' => null]); // 3 pending tasks
        Task::factory()->count(2)->create(['updated_at' => now()]); // 2 completed tasks

        // Act: Calculate efficiency
        $totalTasks = Task::count();
        $completedTasks = Task::whereNotNull('updated_at')->count();
        $efficiency = ($completedTasks / $totalTasks) * 100;

        // Assert: Check the calculated efficiency
        $this->assertEquals(40, $efficiency); // 2/5 = 40%
    }

}
