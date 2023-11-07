@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold">Edit Food Item</h2>

                <form action="{{ route('foods.update', $food) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="form-input w-full" value="{{ $food->name }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="raw_material" class="block text-sm font-medium text-gray-700">Raw Material</label>
                        <input type="text" name="raw_material" id="raw_material" class="form-input w-full" value="{{ $food->raw_material }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" class="form-input w-full" value="{{ $food->price }}" required>
                    </div>

                    <!-- Add more fields as needed -->

                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
