<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function changeMemberRole($userId, $newRole)
    {
        $member = $this->members()->where('user_id', $userId)->first();

        if ($member) {
            $this->members()->updateExistingPivot($userId, ['role' => $newRole]);
            return true;
        }

        return false;
    }
}
