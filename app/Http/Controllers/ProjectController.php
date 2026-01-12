<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::query()
                ->where('user_id', auth()->id()) // Only show MY projects
                ->withCount('tasks') // Efficiently count tasks (SQL optimization)
                ->latest()
                ->get()
        ]);
    }
    public function show(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Projects/Show', [
            'project' => $project->load('tasks.assignee'),
        ]);
    }
    // Show the form
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    // Save the data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:projects,slug',
        ]);

        $request->user()->projects()->create([
            ...$validated,
            'status' => 'active'
        ]);

        return redirect()->route('projects.index');
    }
    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index');
    }
}