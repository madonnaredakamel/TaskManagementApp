
@extends('layouts.app')

@section('content')












<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Admin Dashboard</h1>
        <div>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>


    <div class="dashboard-container">
    <!-- Total Users by Role Section -->
    <div class="stats-card">
        <h3>Total Users by Role</h3>
        @foreach($userCountsByRole as $roleData)
            <div class="stat-item">
                <span class="role-name">{{ $roleData->role }}</span>
                <span class="role-count">{{ $roleData->total_users }} Users</span>
            </div>
        @endforeach
    </div>

    <!-- Total Tasks Section -->
    <div class="stats-card">
        <h3>Total Tasks by Status and Priority</h3>
        @foreach($taskCounts as $task)
            <div class="stat-item">
                <span class="task-info">Status: {{ $task->status }} | Priority: {{ $task->priority }}</span>
                <span class="task-count">{{ $task->total_tasks }} Tasks</span>
            </div>
        @endforeach
    </div>

    <!-- Average Task Completion Time Section -->
    <div class="stats-card">
        <h3>Average Task Completion Time</h3>
        <div class="completion-time">
            <span>{{ gmdate("H:i:s", $avgCompletionTime) }}</span>
        </div>
    </div>
</div>


    <!-- Tasks Section -->
    <div class="mb-5">
        <h2 class="text-secondary">All Tasks</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Assigned User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in-progress' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'info' : 'light') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td>{{ $task->user ? $task->user->name : 'Unassigned' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Users Section -->
    <div>
        <h2 class="text-secondary">All Users</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Assigned Tasks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'manager' ? 'info' : 'secondary') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->tasks->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

