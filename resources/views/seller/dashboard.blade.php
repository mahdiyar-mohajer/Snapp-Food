@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    @if ($restaurantWithImages)
        <div class="w-2/3 p-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                @if ($restaurantWithImages->image)
                    <img src="{{ asset('storage/' . $restaurantWithImages->image->url) }}"
                         alt="{{ $restaurantWithImages->name }}" class="w-full h-32 object-cover">
                @else
                    <img src="{{ asset('path/to/default-image.jpg') }}" alt="No Image" class="w-full h-32 object-cover">
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $restaurantWithImages->name }}</h2>
                    <p class="text-gray-600">{{ $restaurantWithImages->description }}</p>
                    <p>Phone: {{ $restaurantWithImages->phone_number }}</p>
                    <p>Start Time: {{ $restaurantWithImages->start_time }}</p>
                    <p>End Time: {{ $restaurantWithImages->end_time }}</p>
                    <p>Shipping Price: {{ $restaurantWithImages->ship_price }}</p>
                    <form action="{{ route('restaurant.toggleActivation') }}" method="post">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                        <button type="submit"
                                class="px-4 py-2 rounded {{ $restaurant->status == 1 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                            {{ $restaurant->status == 1 ? 'Deactivate' : 'Activate' }} Restaurant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <p>No restaurant profile found. Please create or update your restaurant profile.</p>
    @endif
@endsection
