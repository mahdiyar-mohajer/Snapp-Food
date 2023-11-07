@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold">Food Details</h2>
                <p><strong>Name:</strong> {{ $food->name }}</p>
                <p><strong>Raw Material:</strong> {{ $food->raw_material }}</p>
                <p><strong>Price:</strong> ${{ $food->price }}</p>
                <p><strong>Restaurant:</strong> @if ($food->restaurant) {{ $food->restaurant->name }} @else Restaurant not specified @endif</p>
            </div>
        </div>
    </div>
@endsection
