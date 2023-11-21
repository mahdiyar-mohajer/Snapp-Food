@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')

    <div class="container mx-auto">
        <div class="py-8">
            <h1 class="text-2xl font-semibold mb-4">Restaurant Profile</h1>

            <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="name" class="block text-gray-600">Restaurant Name</label>
                    <input type="text" name="name" id="name" class="border rounded px-4 py-2 w-full"
                           value="{{ old('name', $restaurant ->name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-600">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="border rounded px-4 py-2 w-full"
                           value="{{ old('phone_number',$restaurant ->phone_number) }}" required>
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-gray-600">Opening Time</label>
                    <input type="time" name="start_time" id="start_time" class="border rounded px-4 py-2 w-full"
                           value="{{ old('start_time',$restaurant ->start_time) }}" required>
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-gray-600">Closing Time</label>
                    <input type="time" name="end_time" id="end_time" class="border rounded px-4 py-2 w-full"
                           value="{{ old('end_time',$restaurant ->end_time) }}" required>
                </div>

                <div class="mb-4">
                    <label for="ship_price" class="block text-gray-600">Shipping Price</label>
                    <input type="number" name="ship_price" id="ship_price" class="border rounded px-4 py-2 w-full"
                           value="{{ old('ship_price',$restaurant ->ship_price) }}" required>
                </div>
                <div class="mb-4">
                    <a href="{{ route('get.coordinates') }}">Coordinate</a>
                </div>
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Profile</button>
                </div>

                <!-- Add more form fields for other restaurant details if needed -->


            </form>
        </div>
    </div>
@endsection
