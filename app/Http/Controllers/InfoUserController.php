<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InfoUserController extends Controller
{
    public function create()
    {
        $user = Auth::user(); // Get current authenticated user

        return view('laravel-examples/user-profile', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user(); 

        // Validate fields
        $attributes = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|regex:/^(\+?[0-9\s-]{3,15})$/',
            'business_name' => 'nullable|max:100',
            'address' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Restrict email change in demo mode
        if ($request->email !== $user->email) {
            if (env('IS_DEMO') && $user->id == 1) {
                return redirect()->back()->withErrors(['msg2' => 'You are in a demo version, you can\'t change the email address.']);
            }
        }

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && $user->profile_picture !== 'default-avatar.png') {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $profilePath = $request->file('profile_picture')->store('profiles', 'public');
            $attributes['profile_picture'] = $profilePath;
        }

        if ($request->filled('address')) {
            Log::info('Raw address before API call: ' . $request->address);
        
            $response = Http::withoutVerifying()->withHeaders([
                'User-Agent' => 'Laravel/1.0 (muhdzahir248@gmail.com)', 
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $request->address,
                'format' => 'json',
                'limit' => 1,
            ]);
            
            Log::info('Raw geo response: ' . json_encode($response->json()));
        
            if ($response->successful() && count($response->json()) > 0) {
                $geo = $response->json()[0];
                $attributes['latitude'] = $geo['lat'];
                $attributes['longitude'] = $geo['lon'];
                Log::info('Extracted geo coords: ' . json_encode([
                    'lat' => $geo['lat'],
                    'lon' => $geo['lon'],
                ]));
            } else {
                Log::warning('No results returned from Geo API or API failed.');
            }
        }
        
        // Update user
        $user->update($attributes);
        Log::info('User profile updated with:', $attributes);

        return redirect('/profile')->with('success', 'Profile updated successfully');
    }

}
