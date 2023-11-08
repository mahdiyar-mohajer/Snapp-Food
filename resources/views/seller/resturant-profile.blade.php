@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')


    <div class="container mx-auto">
        <div class="py-8">
            <h1 class="text-2xl font-semibold mb-4">Complete Your Restaurant Profile</h1>
            @if(session('success'))
                <div class="bg-green-200 text-green-800 px-4 py-2 rounded auto-dismiss">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-200 text-red-800 px-4 py-2 rounded auto-dismiss">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('resturant.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-600">Restaurant Name</label>
                    <input type="text" name="name" id="name" class="border rounded px-4 py-2 w-full"
                           value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-600">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="border rounded px-4 py-2 w-full"
                           value="{{ old('phone_number') }}" required>
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-gray-600">Opening Time</label>
                    <input type="time" name="start_time" id="start_time" class="border rounded px-4 py-2 w-full"
                           value="{{ old('start_time') }}" required>
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-gray-600">Closing Time</label>
                    <input type="time" name="end_time" id="end_time" class="border rounded px-4 py-2 w-full"
                           value="{{ old('end_time') }}" required>
                </div>

                <div class="mb-4">
                    <label for="ship_price" class="block text-gray-600">Shipping Price</label>
                    <input type="number" name="ship_price" id="ship_price" class="border rounded px-4 py-2 w-full"
                           value="{{ old('ship_price') }}" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-600">Status</label>
                    <select name="status" id="status" class="border rounded px-4 py-2 w-full" required>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" multiple>
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Profile</button>
                </div>

                <!-- Add more form fields for other restaurant details if needed -->


            </form>
        </div>
    </div>
@endsection
