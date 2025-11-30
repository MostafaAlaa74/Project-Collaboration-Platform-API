<?php

namespace App\Http\Controllers;

use App\Events\TaskCreatedEvent;
use App\Events\TaskUpdatedEvent;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\taskCreatedMail;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\DelayedEnvelope;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('project')->get();
        return response()->json($tasks);
    }

    public function getProjectTasks($projectId)
    {
        Gate::authorize('viewProjectTask', [Task::class, $projectId]);
        return response()->json(Task::where('project_id', $projectId)->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeTaskRequest $request)
    {
        Gate::authorize('create', [Task::class, $request->project_id]);
        $task = Task::create($request->validated());
        event(new TaskCreatedEvent(Auth::user(), $task));
        // // Ensure relations are loaded
        // $task->load('project');
        // $project = $task->project;

        // // Collect recipient emails: project members + owner
        // $memberEmails = $project->members()->pluck('email')->toArray();
        // $ownerEmail = optional($project->owner)->email;

        // $recipients = array_filter(array_unique(array_merge($memberEmails, [$ownerEmail])));

        // // Send the task created mail to each recipient (personalized delivery)
        // foreach ($recipients as $email) {
        //     if (empty($email)) continue;
        //     Mail::to($email)->queue(new taskCreatedMail($task));
        //     // Delaying between sends can be added here if necessary
        // }
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
        event(new TaskUpdatedEvent(Auth::user(), $task));
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
