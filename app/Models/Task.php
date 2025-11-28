<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'status', 'priority', 'due_date', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
