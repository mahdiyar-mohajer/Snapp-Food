<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use Illuminate\Http\Request;

class AdminFoodCategoryController extends Controller
{
    public function create()
    {
        return view('admin.categories.food.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new restaurant category
        $category = new FoodCategory;
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('food-categories.index')
            ->with('success', 'Category created successfully.');
    }

// List all restaurant categories
    public function index()
    {
        $categories = FoodCategory::all();
        return view('admin.categories.food.index', compact('categories'));
    }

// Edit an existing restaurant category
    public function edit(FoodCategory $category)
    {
        return view('admin.categories.food.edit', compact('category'));
    }

    public function update(Request $request, FoodCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the restaurant category
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('food-categories.index')
            ->with('success', 'Category updated successfully.');
    }

// Delete a restaurant category
    public function destroy(FoodCategory $category)
    {
        $category->delete();
        return redirect()->route('food-categories.index')->with('success', 'Category deleted successfully.');
    }
}
