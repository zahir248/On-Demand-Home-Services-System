<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories and paginate
        $categories = Category::paginate(10);

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Create category
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('categories'));
    }

    public function update(Request $request, Category $category)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Update category
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        // return redirect()->back()->with('success', 'Category deleted successfully.');
        return redirect()->route('categories.index');
    }

}
