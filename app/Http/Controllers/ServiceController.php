<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 

        $services = Service::with(['provider:id,business_name', 'category:id,name'])
            ->whereHas('provider', function ($query) use ($user) {
                $query->where('provider_id', $user->id);
            })
            ->paginate(10);

        return view('service.index', compact('services'));
    }

    public function show(Service $service)
    {
        $service->load(['provider:id,business_name', 'category:id,name']); // Load relationships

        return response()->json($service);
    }

    public function edit(Service $service)
    {
        return view('service.edit', compact('services'));
    }

    public function getCategories()
    {
        $categories = Category::all(['id', 'name']);

        return response()->json($categories);
    }

    public function update(Request $request, Service $service)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', 
        ]);

        // Update service
        $service->update([
            'service_name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id, 
        ]);

        return redirect()->route('services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index');
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            // Create service
            Service::create([
                'service_name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'provider_id' => auth()->id(), 
                'status' => 'active', 
            ]);

            return redirect()->route('services.index');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_status' => 'required|in:active,inactive',
        ]);

        $service = Service::findOrFail($request->service_id);
        $service->status = $request->service_status;

        $service->save();

        return redirect()->route('services.index');
    }

}