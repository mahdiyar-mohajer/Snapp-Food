@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <h1 class="text-3xl font-bold mb-4">Archived Orders</h1>

    <ul class="list-disc pl-8">
        @foreach ($archivedOrders as $archivedOrder)
            <li class="mb-4">
                Order ID: {{ $archivedOrder->id }} | Total Price: {{ $archivedOrder->total_price }} | Status: {{ $archivedOrder->status }}
            </li>
        @endforeach
    </ul>
@endsection
