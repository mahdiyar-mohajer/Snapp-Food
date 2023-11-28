@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Edit Discount for {{ $food->name }}</h2>

        <form action="{{ route('discounts.update', ['food' => $food->id, 'discount' => $discount->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="text" name="start_time" id="start_time" class="form-input w-full" value="{{ $discount->start_time }}" required>
                @error('start_time')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="text" name="end_time" id="end_time" class="form-input w-full" value="{{ $discount->end_time }}" required>
                @error('end_time')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="discount" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                <input type="number" name="discount" id="discount" class="form-input w-full" value="{{ $discount->discount }}" required>
                @error('discount')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <!-- Add more fields as needed -->

            <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">
                Update Discount
            </button>
        </form>
    </div>
@endsection
