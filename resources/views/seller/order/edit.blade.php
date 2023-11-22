@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <h1 class="text-3xl font-bold mb-4">Edit Order #{{ $order->id }}</h1>

    <form method="post" action="{{ route('orders.update', $order->id) }}" class="mb-4">
        @csrf
        @method('put')

        <label class="block mb-2">Status:</label>

        @foreach(['PENDING', 'ACCEPT', 'PREPARING', 'DONE'] as $status)
            <button type="submit" name="status" value="{{ $status }}"
                    class="mr-2 px-4 py-2 bg-blue-500 text-white rounded {{ $order->status === $status ? 'bg-gray-500 cursor-not-allowed' : 'hover:bg-blue-700' }}"
                {{ $order->status === $status ? 'disabled' : '' }}>
                {{ $status }}
            </button>
        @endforeach
    </form>
@endsection
