<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class UserDashboardController extends Controller
{
    //
    public function index()
    {
        $tasks = Task::where('assigned_user', auth()->id())->get();
        return view('users.user-dashboard' , compact('tasks'));
    }

    public function updateTaskStatus(Request $request, $taskId)
    {
        // Find the task

        $task = Task::where('id', $taskId)
            ->where('assigned_user', auth()->id()) // Ensure the user owns the task
            ->firstOrFail();
        // Update the task status
        $task->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}
