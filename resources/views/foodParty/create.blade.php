@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Add Food Party for {{ $food->name }}</h2>

        <form action="{{ route('foodParty.store', $food->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="text" name="start_time" id="start_time" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="text" name="end_time" id="end_time" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Count</label>
                <input type="number" name="count" id="count" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label for="discount" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                <input type="number" name="discount" id="discount" class="form-input w-full" required>
            </div>

            <button type="submit" class="bg-green-500 text-white font-semibold px-4 py-2 rounded hover:bg-green-600">
                Add Food Party
            </button>
        </form>
    </div>
@endsection
