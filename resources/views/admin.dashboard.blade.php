<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Total Users by Role</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($usersByRole as $user)
                            <li class="list-group-item">
                                {{ ucfirst($user->role) }}: <strong>{{ $user->count }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Total Tasks by Status</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($tasksByStatus as $task)
                            <li class="list-group-item">
                                {{ ucfirst($task->status) }}: <strong>{{ $task->count }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">Total Tasks by Priority</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($tasksByPriority as $task)
                            <li class="list-group-item">
                                {{ ucfirst($task->priority) }}: <strong>{{ $task->count }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">Average Task Completion Time</div>
            <div class="card-body">
                <p class="card-text">
                    @if ($averageCompletionTime)
                        {{ gmdate('H:i:s', $averageCompletionTime) }} (hh:mm:ss)
                    @else
                        <em>No tasks completed yet.</em>
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>
</html>
