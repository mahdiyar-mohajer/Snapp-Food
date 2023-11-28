<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Food;
use App\Models\FoodParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $discounts = $user->resturant->discounts()->paginate(5);
        $foods = $user->resturant->foods;
        return view('discounts.index', compact('foods', 'discounts'));
    }

    public function create($foodId)
    {
        $food = Food::findOrFail($foodId);
        return view('discounts.create', compact('food'));
    }

    public function store(DiscountRequest $request, $foodId)
    {
        $food = Food::findOrFail($foodId);
        $discountData = [
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'discount' => $request->input('discount'),
        ];

        if ($food->discount) {
            $food->discount->update($discountData);
        } else {
            $discount = new Discount($discountData);
            $discount->food()->associate($food);
            $discount->resturant_id = $food->resturant->id;
            $discount->save();
        }

        return redirect()->route('discounts.index', $foodId)
            ->with('success', 'Discount added successfully');
    }

    public function edit($foodId, $discountId)
    {
        $food = Food::findOrFail($foodId);
        $discount = Discount::findOrFail($discountId);

        return view('discounts.edit', compact('food', 'discount'));
    }

    public function update(DiscountRequest $request, $foodId, $discountId)
    {
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

        $discounts = DB::table('discounts')
            ->where('food_id', $foodId)
            ->get();

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
