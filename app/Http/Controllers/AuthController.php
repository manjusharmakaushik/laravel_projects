<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('content.authentications.auth-login-basic');
    }
    public function checkAuth()
    {

        return view('content.dashboard.dashboards-analytics');
    }
    public function login(Request $request)
    {

        $request->validate([
            'email_username' => 'required',
            'password' => 'required',
        ]);

        $data = $request->only('email_username', 'password');
        $user = User::where('email', $data['email_username'])->orWhere('email', $data['email_username'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {

            Auth::login($user);
            return response()->json([
                'success' => true,
                'redirect_url' => route('dashboard')
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.'
            ]);
        }
    }
}
