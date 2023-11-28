<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::paginate(5);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(DiscountRequest $request, Discount $discount)
    {
        $discount->update([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'discount' => $request->input('discount'),
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully');    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Discount deleted successfully');
    }
}
