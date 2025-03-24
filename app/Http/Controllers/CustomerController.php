<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch users with the role 'provider' and paginate
        $customers = User::where('role', 'customer')->paginate(10);

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^(\+?[0-9\s-]{3,15})$/',
            'email' => 'required|email|max:255|unique:users,email',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        try {
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')->store('profiles', 'public');
            } else {
                $profilePath = 'default-avatar.png';
            }

            // Prepare user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'profile_picture' => $profilePath,
                'role' => 'customer',
                'password' => Hash::make('1234'), 
            ];

            // Insert into database
            $user = User::create($userData);

            return redirect()->route('customer.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create customer. Check logs for details.');
        }
    }

}
