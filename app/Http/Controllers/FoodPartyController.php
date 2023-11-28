<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Food;
use App\Models\FoodParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodPartyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $foodParties = $user->resturant->foodParties()->paginate(5);
        $foods = $user->resturant->foods;

        return view('foodParty.index', compact('foods', 'foodParties'));
    }

    public function create($foodId)
    {
        $food = Food::findOrFail($foodId);

        return view('foodParty.create', compact('food'));
    }

    public function store(Request $request, $foodId)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'count' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);

        $food = Food::findOrFail($foodId);

        $foodParty = new FoodParty([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'count' => $request->input('count'),
            'discount' => $request->input('discount'),
        ]);

        $foodParty->resturant_id = $food->resturant->id;

        $food->foodParty()->save($foodParty);

        return redirect()->route('foodParty.index', $foodId)
            ->with('success', 'Food Party added successfully');
    }
    public function show($foodId)
    {
        $food = Food::findOrFail($foodId);

        // Fetch the food parties for the given food
        $foodParties = DB::table('foods_party')
            ->where('food_id', $foodId)
            ->get();

        // Calculate the discounted prices for food parties
        $foodPartiesPrices = [];
        foreach ($foodParties as $foodParty) {
            $foodPartiesPrices[] = [
                'id' => $foodParty->id,
                'start_time' => $foodParty->start_time,
                'end_time' => $foodParty->end_time,
                'count' => $foodParty->count,
                'discount' => $foodParty->discount,
                'discounted_price' => $food->price - ($food->price * ($foodParty->discount / 100)),
            ];
        }

        return view('foodParty.show', compact('food', 'foodPartiesPrices'));
    }
    public function edit($foodId, $foodPartyId)
    {
        $food = Food::findOrFail($foodId);
        $foodParty = FoodParty::findOrFail($foodPartyId);

        return view('foodParty.edit', compact('food', 'foodParty'));
    }

    public function update(Request $request, $foodId, $foodParty)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'count' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);

        $food = Food::findOrFail($foodId);
        $foodParty = FoodParty::findOrFail($foodParty);

        $foodParty->update([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'count' => $request->input('count'),
            'discount' => $request->input('discount'),
        ]);

        return redirect()->route('foodParty.show', $foodId)
            ->with('success', 'Discount updated successfully');
    }

    public function destroy($foodId, $foodParty)
    {
        $foodParty = FoodParty::findOrFail($foodParty);
        $foodParty->delete();

        return redirect()->route('foodParty.show', $foodId)
            ->with('success', 'Food Party deleted successfully');
    }
}
