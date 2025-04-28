<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Fetch bookings for the logged-in provider (user)
        $bookings = Booking::with(['service', 'customer'])
            ->where('provider_id', Auth::id()) // Filter bookings by logged-in user's provider_id
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('booking.create');
    }

    public function getServices()
    {
        $services = Service::where('provider_id', Auth::id())
            ->get(['id', 'service_name']); 

        return response()->json($services);
    }

    public function getCustomers()
    {
        $customers = User::where('role', 'customer')
            ->get(['id', 'name']); 

        return response()->json($customers);
    }

}
