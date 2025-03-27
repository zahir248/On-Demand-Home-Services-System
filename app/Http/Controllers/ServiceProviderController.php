<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ServiceProviderController extends Controller
{
    public function index()
    {
        // Fetch users with the role 'provider' and paginate
        $providers = User::where('role', 'provider')->paginate(10);

        return view('service_provider.index', compact('providers'));
    }

    public function create()
    {
        return view('service_provider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
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
                'business_name' => $request->business_name,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'approval_status' => 'approved',
                'profile_picture' => $profilePath,
                'role' => 'provider',
                'password' => Hash::make('1234'), 
            ];

            // Insert into database
            $user = User::create($userData);

            return redirect()->route('providers.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create provider. Check logs for details.');
        }
    }

    public function show(User $provider)
    {
        return response()->json($provider);
    }

    public function edit(User $provider)
    {
        return view('service_provider.edit', compact('providers'));
    }

    public function update(Request $request, User $provider)
    {
        // Validate request
        $request->validate([
            'business_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^(\+?[0-9\s-]{3,15})$/',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists and not default
            if ($provider->profile_picture && $provider->profile_picture !== 'default-avatar.png') {
                Storage::disk('public')->delete($provider->profile_picture);
            }

            // Upload new profile picture
            $profilePath = $request->file('profile_picture')->store('profiles', 'public');
        } else {
            // Keep the existing profile picture if no new one is uploaded
            $profilePath = $provider->profile_picture ?? 'default-avatar.png';
        }

        // Update provider
        $provider->update([
            'business_name' => $request->business_name,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'profile_picture' => $profilePath,
        ]);

        return redirect()->route('providers.index');
    }
    
    public function destroy(User $provider)
    {
        // Delete profile picture if exists
        if ($provider->profile_picture && $provider->profile_picture !== 'default-avatar.png') {
            Storage::disk('public')->delete($provider->profile_picture);
        }

        $provider->delete();

        // return redirect()->back()->with('success', 'Provider deleted successfully.');
        return redirect()->route('providers.index');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:users,id',
            'approval_status' => 'required|in:Approved,Rejected,Pending',
        ]);
        
        $provider = User::findOrFail($request->provider_id);
        $provider->approval_status = $request->approval_status;
        
        $provider->save();
        
        return redirect()->route('providers.index');
        // return redirect()->back()->with('success', 'Provider status updated successfully');
    }

}
