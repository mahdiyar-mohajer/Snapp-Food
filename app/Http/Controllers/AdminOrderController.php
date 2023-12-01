<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Resturant;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function allOrders()
    {
        $restaurants = Resturant::with(['orders' => function ($query) {
            $query->where('archived', true)->with('orderItems.food');
        }])->get();

        return view('admin.order.all_orders', compact('restaurants'));
    }
}
