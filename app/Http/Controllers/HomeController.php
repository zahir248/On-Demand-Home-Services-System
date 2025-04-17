<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;  

class HomeController extends Controller
{
    public function home()
    {
        // Get all users with location data for admin view
        $users = User::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'role', 'business_name', 'address', 'latitude', 'longitude']);
        
        // Get current authenticated user
        $currentUser = Auth::user();
        
        return view('dashboard', compact('users', 'currentUser'));
    }
}
