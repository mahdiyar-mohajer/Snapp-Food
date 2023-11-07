<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('resturant')->get();
        return view('foods.index', compact('foods'));
    }

    public function show(Food $food)
    {
        return view('foods.show', compact('food'));
    }

    public function create()
    {
        $restaurants = Resturant::all();
        return view('foods.create', compact('restaurants'));
    }

// Store a new food item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'raw_material' => 'required|string',
            'price' => 'required|numeric',
        ]);
        Food::create([
            'name' => $request->input('name'),
            'raw_material' => $request->input('raw_material'),
            'price' => $request->input('price'),
        ]);
        return redirect()->route('foods.index')->with('success', 'Food item created successfully');
    }

// Edit a food item form
    public function edit(Food $food)
    {
        $restaurants = Resturant::all(); // Corrected the model name to Restaurant
        return view('foods.edit', compact('food', 'restaurants'));
    }

// Update a food item
    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'raw_material' => 'required|string',
            'price' => 'required|numeric',
        ]);
        $food->update([
            'name' => $request->input('name'),
            'raw_material' => $request->input('raw_material'),
            'price' => $request->input('price'),
        ]);
        return redirect()->route('foods.index')->with('success', 'Food item updated successfully');
    }

// Delete a food item
    public function destroy(Food $food)
    {
        DB::transaction(function () use ($food) {
            $food->delete();
        });

        return redirect()->route('foods.index')->with('success', 'Food item deleted successfully');
    }

}
