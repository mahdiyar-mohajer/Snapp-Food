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
        $foods = Food::where('resturant_id', Auth::user()->resturant->id)->get();
        return view('foods.index', compact('foods'));
    }


    public function show(Food $food)
    {
        Auth::user();
        return view('foods.show', compact('food'));
    }

    public function create()
    {
        return view('foods.create');
    }

// Store a new food item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'raw_material' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user) {
            $restaurant = $user->resturant; // Assuming a one-to-one relationship between user and restaurant

            if ($restaurant) {
                $food = new Food([
                    'name' => $request->input('name'),
                    'raw_material' => $request->input('raw_material'),
                    'price' => $request->input('price'),
                ]);

                $food->resturant()->associate($restaurant); // Associate the food with the user's restaurant

                $food->save();

                return redirect()->route('foods.index')->with('success', 'غذا با موفقیت اضافه شد.');
            } else {
                return redirect()->route('foods.index')->with('failed', 'اطلاعات رستوران رو تکمیل کن.');
            }
        } else {
            return redirect()->route('auth.login');
        }
    }


// Edit a food item form
    public function edit(Food $food)
    {
        // Corrected the model name to Restaurant
        return view('foods.edit', compact('food'));
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
        return redirect()->route('foods.index')->with('success', 'غذا با موفقیت آپدیت شد.');
    }

// Delete a food item
    public function destroy(Food $food)
    {
        DB::transaction(function () use ($food) {
            $food->delete();
        });

        return redirect()->route('foods.index')->with('success', 'غذا با موفقیت حذف شد.');
    }

}
