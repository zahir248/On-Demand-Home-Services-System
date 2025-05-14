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

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'customer_id'  => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after_or_equal:now',
        ]);

        // Create the booking
        $booking = Booking::create([
            'service_id'     => $validated['service_id'],
            'customer_id'    => $validated['customer_id'],
            'scheduled_at'   => $validated['scheduled_at'],
            'provider_id'    => auth()->id(),          
            'status'         => 'pending',
            'payment_status' => 'pending',
        ]);

        // Redirect back with success message
        return redirect()->route('bookings.index');
    }

    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        Booking::where('id', $request->booking_id)
            ->update(['payment_status' => $request->payment_status]);

        return redirect()->route('bookings.index');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'status' => 'required|in:pending,confirmed,completed,canceled',
        ]);

        Booking::where('id', $request->booking_id)
            ->update(['status' => $request->status]);

        return redirect()->route('bookings.index');
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('bookings'));
    }

    public function update(Request $request, Booking $booking)
{
    $request->validate([
        'service_id' => 'nullable|exists:services,id',
        'scheduled_at' => 'nullable|date|after_or_equal:now',
    ]);

    $data = [];

    if ($request->filled('service_id')) {
        $data['service_id'] = $request->service_id;
    }

    if ($request->filled('scheduled_at')) {
        $data['scheduled_at'] = $request->scheduled_at;
    }

    if (!empty($data)) {
        $booking->update($data);
    }

    return redirect()->route('bookings.index');
}


    public function show(Booking $booking)
    {
        return response()->json($booking);
    }




}
