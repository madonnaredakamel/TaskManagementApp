@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary">Manager Dashboard</h1>
    <div class="stats-card">
    <h3>Task Efficiency</h3>
    <div class="efficiency">
        <span>{{ number_format($efficiency, 2) }}%</span>
    </div>
</div>
    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">Create New Task</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Assigned User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ ucfirst($task->priority) }}</td>
                    <td>{{ $task->user ? $task->user->name : 'Unassigned' }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<form action="{{ route('tasks.assign', $task->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Assign Task</button>
</form>

@endsection
