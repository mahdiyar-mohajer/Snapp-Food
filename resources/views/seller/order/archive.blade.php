@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">Archived Orders</h1>
        <form id="filterForm" action="{{ route('seller.orders.archived') }}" method="get" class="mb-4">
            <label for="weekFilter">Filter by Week:</label>
            <input type="checkbox" id="weekFilter" name="week" value="1">

            <label for="monthFilter">Filter by Month:</label>
            <input type="checkbox" id="monthFilter" name="month" value="1">

            <button id="filterButton" type="button">Apply Filter</button>
        </form>

        <div class="flex">
            <div class="w-400 h-200 mb-4">
                <canvas id="ordersChart" class="w-full h-full"></canvas>
            </div>
            <div class="w-400 h-200">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <form action="{{ route('orders.exportToExcel') }}" method="post" class="mb-4">
            @csrf
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                Export to Excel
            </button>
        </form>

        @foreach ($archivedOrders as $archivedOrder)
            <div class="border rounded-md p-6 mb-8">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-bold cursor-pointer toggle-items" data-order-id="{{ $archivedOrder->id }}">
                        Order ID: {{ $archivedOrder->id }} - {{ $archivedOrder->user->name }}
                    </h2>

                    <div>
                        <p class="font-bold">Status: {{ $archivedOrder->status }}</p>
                        <p class="font-bold">Total Price: ${{ $archivedOrder->total_price }}</p>
                        <p class="font-bold">Order Date: {{ $archivedOrder->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <div class="hidden ordered-items" data-order-id="{{ $archivedOrder->id }}">
                    <h3 class="text-lg font-bold mb-2">Ordered Items</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Food
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Unit Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($archivedOrder->orderItems as $orderItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->food->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ $orderItem->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${{ $orderItem->price * $orderItem->count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

@include('seller.order.script')

@endsection
