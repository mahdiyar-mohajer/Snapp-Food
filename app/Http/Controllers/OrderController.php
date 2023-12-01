<?php

namespace App\Http\Controllers;

use App\Exports\YourExport;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

//        $order->user->notify(new OrderStatusNotification($order->status));



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
    public function archived(Request $request)
    {
        $restaurantId = Auth::user()->resturant->id;

        $query = Order::where('archived', true)
            ->where('resturant_id', $restaurantId);

        $timeFilter = $request->input('time_filter');
        if ($timeFilter) {
            $query->whereBetween('created_at', $this->getTimeRange($timeFilter));
        }

        $archivedOrders = $query->get();

        $totalOrders = count($archivedOrders);
        $totalRevenue = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.archived', true)
            ->where('orders.resturant_id', $restaurantId);

        if ($timeFilter) {
            $totalRevenue->whereBetween('orders.created_at', $this->getTimeRange($timeFilter));
        }

        $totalRevenue = $totalRevenue->sum(DB::raw('order_items.price * order_items.count'));

        return view('seller.order.archive', compact('archivedOrders', 'totalOrders', 'totalRevenue'));
    }

    private function getTimeRange($filter)
    {
        $now = now();

        return match ($filter) {
            'week' => [$now->startOfWeek(), $now->endOfWeek()],
            'month' => [$now->startOfMonth(), $now->endOfMonth()],
            default => [],
        };
    }


    public function exportToExcel(Request $request)
    {
        $restaurantId = Auth::user()->resturant->id;

        $query = Order::where('archived', true)
            ->where('resturant_id', $restaurantId);

        $timeFilter = $request->input('time_filter');
        if ($timeFilter) {
            $query->whereBetween('created_at', $this->getTimeRange($timeFilter));
        }

        $archivedOrders = $query->get();

        $exportData = [];

        foreach ($archivedOrders as $order) {
            foreach ($order->orderItems as $orderItem) {
                $exportData[] = [
                    'Order ID' => $order->id,
                    'User' => $order->user->name,
                    'Status' => $order->status,
                    'Total Price' => $order->total_price,
                    'Item' => $orderItem->food->name,
                    'Price' => $orderItem->price,
                    'Quantity' => $orderItem->count,
                    'Order Date' => $order->created_at->format('Y-m-d H:i:s'),
                    // Add more fields as needed
                ];
            }
        }

        return Excel::download(new YourExport($exportData), 'archived_orders.xlsx');
    }
}
