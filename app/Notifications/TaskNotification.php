<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, string $action)
    {
        $this->task = $task;
        $this->action = $action; // "assigned" or "updated"
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $actionMessage = $this->action === 'assigned'
            ? 'A new task has been assigned to you.'
            : 'A task assigned to you has been updated.';

        return (new MailMessage)
            ->subject("Task Notification: {$this->task->title}")
            ->greeting('Hello!')
            ->line($actionMessage)
            ->line("**Task Title**: {$this->task->title}")
            ->line("**Description**: {$this->task->description}")
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Thank you for using our application!');
    }
}
