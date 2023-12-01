@extends('admin.layout.app')
@section('title', 'ادمین پنل')


@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">All Orders</h1>

        @foreach ($restaurants as $restaurant)
            <div class="border rounded-md p-6 mb-8">
                <h2 class="text-2xl font-bold mb-4 toggle-restaurant" data-restaurant-id="{{ $restaurant->id }}">
                    {{ $restaurant->name }}
                </h2>

                <div class="flex justify-between mb-4">
                    <div>
                        <p class="font-bold">Total Orders: {{ count($restaurant->orders) }}</p>
                        <p class="font-bold">Total Revenue: ${{ $restaurant->orders->sum(function ($order) {
                            return $order->orderItems->sum('price') * $order->orderItems->sum('count');
                        }) }}</p>
                    </div>
                </div>

                <div class="restaurant-orders hidden" data-restaurant-id="{{ $restaurant->id }}">
                    @foreach ($restaurant->orders as $order)
                        <div class="border rounded-md p-6 mb-4">
                            <div class="flex justify-between mb-2">
                                <h3 class="text-lg font-bold">
                                    Order ID: {{ $order->id }} - {{ $order->user->name }}
                                </h3>

                                <div>
                                    <p class="font-bold">Status: {{ $order->status }}</p>
                                    <p class="font-bold">Total Price: ${{ $order->total_price }}</p>
                                    <p class="font-bold">Order Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-md font-bold mb-2">Ordered Items</h4>
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
                                    @foreach ($order->orderItems as $orderItem)
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
            </div>
        @endforeach
    </div>
    <script>
        $('.toggle-restaurant').click(function () {
            const restaurantId = $(this).data('restaurant-id');
            $('.restaurant-orders[data-restaurant-id="' + restaurantId + '"]').toggleClass('hidden');
        });
    </script>
@endsection
