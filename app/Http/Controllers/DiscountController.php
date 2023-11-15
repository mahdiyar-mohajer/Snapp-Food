<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        $discounts = Discount::all();

        return view('discounts.index', compact('foods', 'discounts'));
    }

    public function create($foodId)
    {
        // Assuming you want to add a discount to a specific food
        $food = Food::findOrFail($foodId);

        return view('discounts.create', compact('food'));
    }

    public function store(Request $request, $foodId)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'discount' => 'required|numeric',
        ]);

        $food = Food::findOrFail($foodId);

        // Create a new discount
        if ($food->discount) {
            // If a discount exists, update it
            $food->discount->update([
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'discount' => $request->input('discount'),
            ]);
        } else {
            // If no discount exists, create a new one
            $discount = new Discount([
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'discount' => $request->input('discount'),
            ]);
        }
        // Associate the discount with the food
        $discount->food()->associate($food);

        // Assuming you also want to associate the discount with the restaurant
        // Replace 'restaurant_id' with the actual foreign key in your Discount model
        $discount->resturant_id = $food->resturant->id;

        // Save the discount
        $discount->save();

        return redirect()->route('discounts.index', $foodId)
            ->with('success', 'Discount added successfully');
    }

    public function edit($foodId, $discountId)
    {
        $food = Food::findOrFail($foodId);
        $discount = Discount::findOrFail($discountId);

        return view('discounts.edit', compact('food', 'discount'));
    }

    public function update(Request $request, $foodId, $discountId)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'discount' => 'required|numeric',
        ]);

        $food = Food::findOrFail($foodId);
        $discount = Discount::findOrFail($discountId);

        $discount->update([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'discount' => $request->input('discount'),
        ]);

        return redirect()->route('discounts.show', $foodId)
            ->with('success', 'Discount updated successfully');
    }

    public function show($foodId)
    {
        $food = Food::findOrFail($foodId);

        // Fetch the discounts for the given food
        $discounts = DB::table('discounts')
            ->where('food_id', $foodId)
            ->get();

        // Calculate the discounted prices
        $discountedPrices = [];
        foreach ($discounts as $discount) {
            $discountedPrices[] = [
                'id' => $discount->id,
                'start_time' => $discount->start_time,
                'end_time' => $discount->end_time,
                'discount' => $discount->discount,
                'discounted_price' => $food->price - ($food->price * ($discount->discount / 100)),
            ];
        }

        return view('discounts.show', compact('food', 'discountedPrices'));
    }

    public function destroy($foodId, $discountId)
    {
        $discount = Discount::findOrFail($discountId);
        $discount->delete();

        return redirect()->route('discounts.show', $foodId)
            ->with('success', 'Discount deleted successfully');
    }
}
