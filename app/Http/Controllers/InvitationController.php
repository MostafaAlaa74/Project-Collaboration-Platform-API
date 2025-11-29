<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function invite($userId)
    {
        $user = User::findOrFail($userId);

        // Logic to send an invitation to the user
        Mail::to($user->email)->send(new InvitationMail(Auth::user()));
        return response()->json(['message' => "Invitation sent to: {$user->name}"], 200);
    }
}


