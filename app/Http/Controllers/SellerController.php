<?php

namespace App\Http\Controllers;

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

        return view('seller.dashboard');
    }
}
