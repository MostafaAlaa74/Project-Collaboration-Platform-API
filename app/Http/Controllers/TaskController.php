<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Task::class);
        $tasks = Task::with('project')->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeTaskRequest $request)
    {
        Gate::authorize('create', [Task::class, $request->project_id]);
        $task = Task::create($request->validated());
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $task->update($request->validated());
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();
        return response()->json(null, 204);
    }

    public function getPriorityTasks($projectId, $priority)
    {
        Gate::authorize('getTasksByPriority', [Task::class, $projectId]);
        $tasks = Task::getPeriorityTasks($projectId, $priority);
        if (is_null($tasks)) {
            return response()->json(['message' => 'Invalid priority value.'], 400);
        }
        return response()->json($tasks, 200);
    }

    public function getStatusTasks($projectId, $status)
    {
        Gate::authorize('getTasksByStatus', [Task::class, $projectId]);
        $tasks = Task::getStatusTasks($projectId, $status);
        if (is_null($tasks)) {
            return response()->json(['message' => 'Invalid status value.'], 400);
        }
        return response()->json($tasks, 200);
    }
}
