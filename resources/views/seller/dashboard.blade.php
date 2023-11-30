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
        @if ($restaurantWithImages)
            <div class="w-2/3 p-4">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    @if ($restaurantWithImages->image)
                        <img src="{{ asset('storage/' . $restaurantWithImages->image->url) }}"
                             alt="{{ $restaurantWithImages->name }}" class="w-full h-32 object-cover">
                    @else
                        <img src="{{ asset('path/to/default-image.jpg') }}" alt="No Image"
                             class="w-full h-32 object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $restaurantWithImages->name }}</h2>
                        <p class="text-gray-600">{{ $restaurantWithImages->description }}</p>
                        <p>تلفن: {{ $restaurantWithImages->phone_number }}</p>
                        <p>ساعت شروع کار: {{ $restaurantWithImages->start_time }}</p>
                        <p>ساعت پایان کار: {{ $restaurantWithImages->end_time }}</p>
                        <p>هزینه ارسال: {{ $restaurantWithImages->ship_price }}</p>
                        <p>شماره حساب: {{ $restaurantWithImages->account_number }}</p>
                        <form action="{{ route('restaurant.toggleActivation') }}" method="post">
                            @csrf
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                            <button type="submit"
                                    class="px-4 py-2 rounded {{ $restaurant->status == 1 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                {{ $restaurant->status == 1 ? 'غیر فعال کردن ' : 'فعال کردن ' }} رستوران
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <p>No restaurant profile found. Please create or update your restaurant profile.</p>
        @endif
    </div>
@endsection
