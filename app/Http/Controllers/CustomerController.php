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
        // Fetch users with the role 'customer' and paginate
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

    public function show(User $customer)
    {
        return response()->json($customer);
    }

    public function edit(User $customer)
    {
        return view('customer.edit', compact('customers'));
    }

    public function update(Request $request, User $customer)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^(\+?[0-9\s-]{3,15})$/',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists and not default
            if ($customer->profile_picture && $customer->profile_picture !== 'default-avatar.png') {
                Storage::disk('public')->delete($customer->profile_picture);
            }

            // Upload new profile picture
            $profilePath = $request->file('profile_picture')->store('profiles', 'public');
        } else {
            // Keep the existing profile picture if no new one is uploaded
            $profilePath = $customer->profile_picture ?? 'default-avatar.png';
        }

        // Update customer
        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'profile_picture' => $profilePath,
        ]);

        return redirect()->route('customers.index');
    }

    public function destroy(User $customer)
    {
        // Delete profile picture if exists
        if ($customer->profile_picture && $customer->profile_picture !== 'default-avatar.png') {
            Storage::disk('public')->delete($customer->profile_picture);
        }

        $customer->delete();

        // return redirect()->back()->with('success', 'Customer deleted successfully.');
        return redirect()->route('customers.index');
    }

}
