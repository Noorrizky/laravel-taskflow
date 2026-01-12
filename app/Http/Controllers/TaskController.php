<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task; // Import Task
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        return Inertia::render('Tasks/Create', [
            'project' => $project
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        // $project->tasks()->create([
        //     ...$validated,
        //     'user_id' => auth()->id(), // Assign to current user
        //     'status' => 'pending'
        // ]);
        $task = $project->tasks()->create([
        ...$validated,
        'user_id' => auth()->id(),
        'status' => 'pending'
        ]);
        TaskCreated::dispatch($task);

        return redirect()->route('projects.show', $project->id);
    }

    public function update(Request $request, Task $task)
    {
        // Security: Ensure the user owns the project this task belongs to
        if ($task->project->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $task->update($validated);

        // Inertia will automatically "refresh" the page data without a hard reload
        return back();
    }

    public function destroy(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return back();
    }
}