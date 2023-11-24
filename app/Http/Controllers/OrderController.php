<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $restaurantId = Auth::user()->resturant->id;
        $orders = Order::where('archived', false)
            ->where('resturant_id', $restaurantId)
            ->get();

        return view('seller.order.index', compact('orders'));
    }

    public function edit($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('seller.order.edit', compact('order'));
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'status' => [
                'required',
                function ($attribute, $value, $fail) use ($order) {
                    $allowedStatuses = $this->getAllowedStatuses($order->status);

                    if (!in_array($value, $allowedStatuses)) {
                        $fail("Invalid status transition from {$order->status} to $value.");
                    }

                    if ($value === $order->status) {
                        $fail("Cannot revert to the previous status.");
                    }
                },
            ],
        ]);

        $order->status = $request->input('status');
        $order->save();

        $order->user->notify(new OrderStatusNotification($order->status));



        if ($order->status === 'DONE') {
            $order->update(['archived' => true]);
        }

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully');
    }

    private function getAllowedStatuses($currentStatus)
    {
        $statusOptions = ['PENDING', 'ACCEPT', 'PREPARING', 'DONE'];
        $currentIndex = array_search($currentStatus, $statusOptions);

        return array_slice($statusOptions, $currentIndex);
    }
    public function archived()
    {
        $restaurantId = Auth::user()->resturant->id;
        $archivedOrders = Order::where('archived', true)
            ->where('resturant_id', $restaurantId)
            ->get();

        return view('seller.order.archive', compact('archivedOrders'));
    }
}
