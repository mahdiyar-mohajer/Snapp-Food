<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\FoodParty;
use Illuminate\Http\Request;

class AdminFoodPartyController extends Controller
{
    public function index()
    {
        $foodParty = FoodParty::paginate(5);
        return view('admin.foodParty.index', compact('foodParty'));
    }

    public function edit(Discount $foodParty)
    {
        return view('admin.foodParty.edit', compact('foodParty'));
    }

    public function update(Request $request, FoodParty $foodParty)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'count' => 'required',
            'discount' => 'required|numeric',
        ]);

        $foodParty->update([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'count' => $request->input('count'),
            'discount' => $request->input('discount'),
        ]);

        return redirect()->route('admin.foodParty.index')->with('success', 'Food Party updated successfully');    }

    public function destroy(FoodParty $foodParty)
    {
        $foodParty->delete();
        return redirect()->route('admin.foodParty.index')->with('success', 'Food Party deleted successfully');
    }
}
