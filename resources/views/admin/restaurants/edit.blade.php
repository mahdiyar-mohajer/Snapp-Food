@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')

    <div class="container mx-auto">
        <div class="py-8 px-4">
            <h1 class="text-2xl font-semibold mb-4">پروفایل رستوران</h1>

            <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div class="mb-4">
                        <label for="name" class="block text-gray-600">نام رستوران</label>
                        <input type="text" name="name" id="name" class="border rounded px-4 py-2 w-full"
                               value="{{ old('name', $restaurant->name) }}" required>
                        @error('name')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-gray-600">شماره تلفن رستوران</label>
                        <input type="text" name="phone_number" id="phone_number" class="border rounded px-4 py-2 w-full"
                               value="{{ old('phone_number', $restaurant->phone_number) }}" required>
                        @error('phone_number')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="start_time" class="block text-gray-600">ساعت شروع کار</label>
                        <input type="time" name="start_time" id="start_time" class="border rounded px-4 py-2 w-full"
                               value="{{ old('start_time', $restaurant->start_time) }}" required>
                        @error('start_time')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_time" class="block text-gray-600">ساعت پایان کار</label>
                        <input type="time" name="end_time" id="end_time" class="border rounded px-4 py-2 w-full"
                               value="{{ old('end_time', $restaurant->end_time) }}" required>
                        @error('end_time')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="ship_price" class="block text-gray-600">هزینه ارسال</label>
                        <input type="number" name="ship_price" id="ship_price" class="border rounded px-4 py-2 w-full"
                               value="{{ old('ship_price', $restaurant->ship_price) }}" required>
                        @error('ship_price')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="account_number" class="block text-gray-600">شماره حساب</label>
                        <input type="number" name="account_number" id="account_number" class="border rounded px-4 py-2 w-full"
                               value="{{ old('account_number', $restaurant->account_number) }}" required>
                        @error('account_number')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">ذخیره</button>
                </div>

            </form>
        </div>
    </div>

@endsection

