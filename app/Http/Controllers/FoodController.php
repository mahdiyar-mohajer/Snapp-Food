<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index()
    {
//        return view('seller.dashboard');
    }

    public function create()
    {
        return view('seller.foods.create');
    }

    public function store(Request $request)
    {

    }

    public function edit(Food $food)
    {

    }

    public function update(Request $request, Food $food)
    {

    }

    public function destroy(Food $food)
    {

    }
}
