@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <h1 class="text-3xl font-bold mb-4">Orders</h1>

    <ul class="list-disc pl-8">
        @foreach ($orders as $order)
            <li class="mb-4">
                <span class="font-bold">Order ID:</span> {{ $order->id }} |
                <span class="font-bold">Total Price:</span> {{ $order->total_price }} |
                <span class="font-bold">Status:</span>
                <span class="{{ $order->status === 'PENDING' ? 'text-yellow-500' : ($order->status === 'ACCEPT' ? 'text-green-500' : ($order->status === 'PREPARING' ? 'text-blue-500' : 'text-gray-500')) }}">
                    {{ $order->status }}
                </span>
                |
                <a href="{{ route('orders.edit', $order->id) }}"
                   class="{{ $order->status !== 'DONE' ? 'hover:underline cursor-pointer' : 'text-gray-500 cursor-not-allowed' }}">
                    Edit Status
                </a>
            </li>
        @endforeach
    </ul>
@endsection
