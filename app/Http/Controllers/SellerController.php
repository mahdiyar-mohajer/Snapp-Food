<?php

namespace App\Http\Controllers;

use App\Models\Resturant;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $restaurant = $user->resturant;

        if (!$restaurant || !$restaurant->profile_complete) {
            return redirect()->route('resturant.profile');
        }

        $restaurantWithImages = Resturant::with('image')->find($restaurant->id);

        return view('seller.dashboard', compact('restaurantWithImages','restaurant'));
    }

}
