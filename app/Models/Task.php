<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'status', 'priority', 'due_date', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    //! Get Tasks Accourding to its Periority
    public static function getPeriorityTasks($projectId, $priority)
    {
        if ($priority !== 'low' && $priority !== 'high') {
            return null;
        }
        return self::where('project_id', $projectId)->where('priority', $priority)->get();
    }

    //! Get Tasks Accourding to its Status
    public static function getStatusTasks($projectId, $status)
    {
        if ($status !== 'pending' && $status !== 'in_progress' && $status !== 'completed') {
            return null;
        }
        return self::where('project_id', $projectId)->where('status', $status)->get();
    }

    public function changeStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->save();
    }
    public function changePriority($newPriority)
    {
        $this->priority = $newPriority;
        $this->save();
    }
}
