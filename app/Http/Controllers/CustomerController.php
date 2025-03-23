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

}
