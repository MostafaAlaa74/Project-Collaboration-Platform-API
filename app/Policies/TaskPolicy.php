<?php

namespace App\Policies;

use App\Models\Project;
use Illuminate\Auth\Access\Response;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //! The user can view any task if they own at least one project
        return $user->projects()->exists();
    }
    public function viewProjectTask(User $user , $projectId): bool {
        $project = Project::findOrFail($projectId);
        return $user->id === $project->owner_id;
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->project->owner_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $projectId): bool
    {
        $project = Project::find($projectId);
        return $project && $user->id === $project->owner_id || $project->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->project->owner_id || $task->project->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->project->owner_id || $task->project->members()->where('user_id', $user->id)->where('role', 'admin')->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function getTasksByPriority(User $user, $projectId): bool
    {
        $project = Project::find($projectId);
        return $project && $user->id === $project->owner_id;
    }
    public function getTasksByStatus(User $user, $projectId): bool
    {
        $project = Project::find($projectId);
        return $project && $user->id === $project->owner_id;
    }
}
