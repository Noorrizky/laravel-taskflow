<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // <--- Import this
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// 1. Add "implements ShouldBroadcast"
class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 2. Accept the Task in the constructor
    public function __construct(public Task $task) {}

    // 3. Define the Channel
    public function broadcastOn(): array
    {
        // We broadcast to a specific project channel: "projects.{id}"
        return [
            new Channel('projects.' . $this->task->project_id),
        ];
    }
}