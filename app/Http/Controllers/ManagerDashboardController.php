<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;


use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    //
    public function index()
    {

        // Get task efficiency
       

        
        return redirect()->route('tasks.index');
    }


   




public function assignTaskToUser($taskId)
{
    // Get all active users (assuming 'active' status means users with at least one active task)
    $users = User::withCount('tasks')
                ->whereHas('tasks', function ($query) {
                    $query->whereNull('updated_at');  // Get only active tasks
                })
                ->get();

    // If there are no active tasks or users, return an error or handle it
    if ($users->isEmpty()) {
        return redirect()->back()->with('error', 'No active users to assign tasks to.');
    }

    // Sort users by the number of active tasks in ascending order
    $users = $users->sortBy('tasks_count');

    // Get the user with the least number of active tasks
    $userToAssign = $users->first();

    // Assign the task to this user
    $task = Task::findOrFail($taskId);
    $task->user_id = $userToAssign->id;  // Assign the task to the user
    $task->save();

    // Redirect or return response
    return redirect()->route('admin.dashboard')->with('success', 'Task successfully assigned to ' . $userToAssign->name);
}



}
