<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function invite($userId, $projectId)
    {
        $project = Auth::user()->owendProjects()->findOrFail($projectId);
        $user = User::findOrFail($userId);
        $token = Str::random(32);
        $project->members()->attach($user->id, ['role' => 'member', 'status' => 'pending', 'token' => $token]);
        $acceptURL = URL::signedRoute('invitations.accept', ['userId' => $user->id, 'token' => $token]);
        // Logic to send an invitation to the user
        Mail::to($user->email)->send(new InvitationMail($project, Auth::user(), $acceptURL));
        return response()->json(['message' => "Invitation sent to: {$user->name}"], 200);
    }

    public function accept(Request $request, $projectId)
    {
        $user = Auth::user();
        $token = $request->token;
        $project = $user->memberProjects()->where('project_id', $projectId)
            ->wherePivot('token', $token)
            ->firstOrFail();

        // Update the pivot table to mark the invitation as accepted
        $project->members()->updateExistingPivot($user->id, [
            'status' => 'accepted',
        ]);

        return response()->json(['message' => "You have accepted the invitation to join project: {$project->name}"], 200);
    }
}
