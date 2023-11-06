<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function profile()
    {
        return view('seller.resturant-profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $restaurant = $user->resturant;

        if (!$restaurant) {
            $restaurant = new Resturant();
            $restaurant->user_id = $user->id;
        }

        $restaurant->name = $request->input('name');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->start_time = $request->input('start_time');
        $restaurant->end_time = $request->input('end_time');
        $restaurant->ship_price = $request->input('ship_price');
        $restaurant->status = $request->input('status');
        $restaurant->profile_complete = true; // Mark the profile as complete

        $restaurant->save();

        return redirect()->route('seller.dashboard');
    }
}






