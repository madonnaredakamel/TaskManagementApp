@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary">User Dashboard</h1>

    <h2 class="text-secondary mt-4">Your Tasks</h2>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
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
                    <td>
                        @if ($task->status !== 'completed')
                            <form method="POST" action="{{ route('tasks.update-status', $task->id) }}" class="d-inline">
                                @csrf
                                @method('POST')
                                <button class="btn btn-sm btn-primary" submit>Mark as Completed</button>
                            </form>
                        @else
                            <span class="text-muted">No actions available</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No tasks assigned to you yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
