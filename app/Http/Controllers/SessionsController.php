<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($attributes)) {
            // Check if the authenticated user's role is "admin" or "provider"
            if (in_array(Auth::user()->role, ['admin', 'provider'])) {
                session()->regenerate();
                return redirect('dashboard');
            } else {
                Auth::logout(); // Logout the user if they don't have the required role
                return back()->withErrors(['email' => 'Unauthorized access.']);
            }
        }

        return back()->withErrors(['email' => 'Email or password invalid.']);
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
