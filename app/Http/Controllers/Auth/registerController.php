<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class registerController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        // You can also create a token here if needed
        $token = $user->createToken('auth_token')->plainTextToken;
        Mail::to($user->email)->send(new WelcomeMail($user));
        return response()->json(['message' => 'User registered successfully', 'Token' => $token], 201);
    }
}
