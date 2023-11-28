@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Edit Food Party for {{ $food->name }}</h2>

        <form action="{{ route('foodParty.update', ['food' => $food->id, 'foodParty' => $foodParty->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="text" name="start_time" id="start_time" class="form-input w-full" value="{{ $foodParty->start_time }}" required>
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="text" name="end_time" id="end_time" class="form-input w-full" value="{{ $foodParty->end_time }}" required>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Count</label>
                <input type="number" name="count" id="count" class="form-input w-full" value="{{ $foodParty->quantity }}" required>
            </div>

            <div class="mb-4">
                <label for="discount" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                <input type="number" name="discount" id="discount" class="form-input w-full" value="{{ $foodParty->discount }}" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">
                Update Food Party
            </button>
        </form>
    </div>
@endsection
