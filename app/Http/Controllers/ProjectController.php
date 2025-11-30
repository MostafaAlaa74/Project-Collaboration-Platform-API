<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeProjectRequest;
use App\Http\Requests\updateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $projects = Project::with('owner')->where('owner_id', Auth::id())->get();
        return response()->json(['Projects' => ProjectResource::collection($projects)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeProjectRequest $request)
    {
        //! Create Project
        $project = Project::create([
            'name' => $request->validated()['name'],
            'owner_id' => Auth::id(),
        ]);
        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        Gate::authorize('view', $project);
        return response()->json(new ProjectResource($project), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateProjectRequest $request, Project $project)
    {
        Gate::authorize('update', $project);
        $project->update($request->validated());
        return response()->json(new ProjectResource($project), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);
        $project->delete();
        return response()->json(['message' => 'project deleted'], 204);
    }

    public function changeMemberRole($projectId, $userId, Request $request)
    {
        $project = Project::findOrFail($projectId);
        // Gate::authorize('update', $project);
        
        $newRole = $request->input('role');
        
        if (!in_array($newRole, ['member', 'admin'])) {
            return response()->json(['message' => 'Invalid role specified'], 400);
        }

        $result = $project->changeMemberRole($userId, $newRole);

        if ($result) {
            return response()->json(['message' => 'Member role updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Member not found in the project'], 404);
        }
    }
}
