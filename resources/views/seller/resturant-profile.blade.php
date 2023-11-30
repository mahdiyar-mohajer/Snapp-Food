@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')

    <div class="container mx-auto">
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
        <div class="py-8 px-4">
            <h1 class="text-2xl font-semibold mb-4">پروفایل رستوران</h1>

            <form action="{{ route('resturant.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-600">اسم رستوران</label>
                        <input type="text" name="name" id="name" class="border rounded px-4 py-2 w-full"
                               value="{{ old('name', optional($restaurants)->name) }}">
                        @error('name')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-gray-600">شماره تلفن رستوران</label>
                        <input type="text" name="phone_number" id="phone_number" class="border rounded px-4 py-2 w-full"
                               value="{{ old('phone_number', optional($restaurants)->phone_number) }}" >
                        @error('phone_number')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    <!-- ادامه برای سایر فیلدها -->

                    <div>
                        <label for="start_time" class="block text-gray-600">ساعت شروع کار</label>
                        <input type="time" name="start_time" id="start_time" class="border rounded px-4 py-2 w-full"
                               value="{{ old('start_time', optional($restaurants)->start_time) }}" >
                        @error('start_time')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-gray-600">ساعت پایان کار</label>
                        <input type="time" name="end_time" id="end_time" class="border rounded px-4 py-2 w-full"
                               value="{{ old('end_time', optional($restaurants)->end_time) }}">
                        @error('end_time')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="ship_price" class="block text-gray-600">هزینه ارسال</label>
                        <input type="number" name="ship_price" id="ship_price" class="border rounded px-4 py-2 w-full"
                               value="{{ old('ship_price', optional($restaurants)->ship_price) }}" >
                        @error('ship_price')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="account_number" class="block text-gray-600">شماره حساب را وارد کنید</label>
                        <input type="number" name="account_number" id="account_number" class="border rounded px-4 py-2 w-full"
                               value="{{ old('ship_price', optional($restaurants)->account_number) }}" >
                        @error('account_number')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-gray-600">وضعیت</label>
                        <select name="status" id="status" class="border rounded px-4 py-2 w-full" >
                            <option value="1" {{ old('status', optional($restaurants)->status) == 1 ? 'selected' : '' }}>باز</option>
                            <option value="0" {{ old('status', optional($restaurants)->status) == 0 ? 'selected' : '' }}>بسته</option>
                        </select>
                        @error('status')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="profile_image">عکس پروفایل</label>
                        <input type="file" name="profile_image" multiple>
                        @error('profile_image')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-600 mb-2">دسته بندی را انتخاب کنید:</label>
                    @foreach($resturantCategories as $category)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="resturantCategories[]" id="category{{ $category->id }}" value="{{ $category->id }}" class="mr-2">
                            <label for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    @error('resturantCategories')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="my-4">
                    <a class="bg-green-500 text-white px-4 py-2 rounded" href="{{ route('get.coordinates') }}">آدرس</a>
                </div>

                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">ذخیره</button>
                </div>
            </form>
        </div>
    </div>

@endsection
