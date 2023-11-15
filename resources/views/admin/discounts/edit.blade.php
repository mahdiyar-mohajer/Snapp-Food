@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto my-4">
        <h2 class="text-2xl font-semibold mb-4">Edit Discount for {{ $discount->resturant->name }}</h2>

        <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="text" name="start_time" id="start_time" class="form-input w-full"
                       value="{{ old('start_time', $discount->start_time) }}" required>
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="text" name="end_time" id="end_time" class="form-input w-full"
                       value="{{ old('end_time', $discount->end_time) }}" required>
            </div>

            <div class="mb-4">
                <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-input w-full"
                       value="{{ old('discount', $discount->discount) }}" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">
                Update Discount
            </button>
        </form>
    </div>
@endsection
