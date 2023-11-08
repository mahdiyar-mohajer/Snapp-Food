<?php

namespace App\Http\Controllers;

use App\Models\ResturantCategory;
use Illuminate\Http\Request;

class AdminRestaurantCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new restaurant category
        $category = new ResturantCategory;
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('restaurant-categories.index')
            ->with('success', 'Category created successfully.');
    }

// List all restaurant categories
    public function index()
    {
        $categories = ResturantCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

// Edit an existing restaurant category
    public function edit(ResturantCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ResturantCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the restaurant category
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('restaurant-categories.index')
            ->with('success', 'Category updated successfully.');
    }

// Delete a restaurant category
    public function destroy(ResturantCategory $category)
    {
        $category->delete();
        return redirect()->route('restaurant-categories.index')->with('success', 'Category deleted successfully.');
    }
}
