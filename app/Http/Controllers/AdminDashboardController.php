<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use DB;



class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        // Total number of users by role
        // $usersByRole = User::select('role', \DB::raw('COUNT(*) as count'))
        //     ->groupBy('role')
        //     ->get();

        // Total number of tasks grouped by status
        // $tasksByStatus = Task::select('status', \DB::raw('COUNT(*) as count'))
        //     ->groupBy('status')
        //     ->get();

        // Total number of tasks grouped by priority
        // $tasksByPriority = Task::select('priority', \DB::raw('COUNT(*) as count'))
        //     ->groupBy('priority')
        //     ->get();

        // Average task completion time
        // $averageCompletionTime = Task::where('status', 'completed')
        //     ->select(\DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_time'))
        //     ->value('avg_time');

            $tasks = Task::with('user')->get(); // Load tasks with their assigned users
            $users = User::with('tasks')->get(); // Load users with their assigned tasks
            $userCountsByRole = $this->getTotalUsersByRole();
            $taskCounts = $this->getTotalTasksByStatusAndPriority();
            $avgCompletionTime = $this->getAverageTaskCompletionTime();

        return view('users.admin-dashboard', compact(
            'taskCounts',
            'tasks',
            'users',
            'userCountsByRole',
           
            'avgCompletionTime'
        ));
    }


    public function getTotalUsersByRole()
    {
        $userCountsByRole = User::select('role', DB::raw('count(*) as total_users'))
                                 ->groupBy('role')
                                 ->get();
    
        return $userCountsByRole;
    }



    public function getTotalTasksByStatusAndPriority()
{
    $taskCounts = Task::select('status', 'priority', DB::raw('count(*) as total_tasks'))
                      ->groupBy('status', 'priority')
                      ->get();

    return $taskCounts;
}




public function getAverageTaskCompletionTime()
{
    $avgCompletionTime = Task::whereNotNull('updated_at')
                             ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_completion_time'))
                             ->first();

    return $avgCompletionTime->avg_completion_time;
}







}
