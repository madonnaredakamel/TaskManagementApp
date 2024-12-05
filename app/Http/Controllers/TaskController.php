<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Http\Controllers\TaskNotification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::with('user')->get(); // Include the assigned user in the data
        $efficiency = $this->getTaskEfficiency();
        return view('tasks.index-task', compact('tasks' , 'efficiency'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all(); // Get all users for assigning tasks
        return view('tasks.create-task', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'priority' => 'required|in:low,medium,high',
            'assigned_user' => 'nullable|exists:users,id',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
        $users = User::all();
        return view('tasks.edit-task', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'priority' => 'required|in:low,medium,high',
            'assigned_user' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function getTaskStats()
{
    $taskStats = Task::select('status', 'priority', DB::raw('count(*) as total'))
                     ->groupBy('status', 'priority')
                     ->get();

    return response()->json($taskStats);
}

public function getAverageTaskCompletionTime()
{
    $avgCompletionTime = Task::whereNotNull('updated_at')
                             ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds')
                             ->first();

    return response()->json(['avg_completion_time' => $avgCompletionTime->avg_seconds]);
}


public function getTaskEfficiency()
{
    // Get total number of tasks
    $totalTasks = Task::count();

    // Get number of completed tasks
    $completedTasks = Task::whereNotNull('updated_at')->count();

    // Calculate efficiency
    if ($totalTasks == 0) {
        $efficiency = 0;  // Prevent division by zero if no tasks exist
    } else {
        $efficiency = ($completedTasks / $totalTasks) * 100;
    }

    return $efficiency;
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

    $user = User::withCount(['tasks' => function ($query) {
        $query->whereNull('updated_at');
    }])->orderBy('tasks_count')->first();

    $user->notify(new TaskNotification($task, 'assigned'));


    // Redirect or return response
    return redirect()->route('tasks.index')->with('success', 'Task successfully assigned to ' . $userToAssign->name);
}


}
