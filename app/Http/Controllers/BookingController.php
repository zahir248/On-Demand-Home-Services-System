<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['service', 'customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('booking.index', compact('bookings'));
    }

}
