@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
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
        <div class="my-4">
            @foreach ($foods as $food)
                <div class="mb-4">
                    <span class="font-semibold">{{ $food->name }}</span>
                    @if (!$food->discount) <!-- Check if a discount does not exist -->
                    <a href="{{ route('discounts.create', ['food' => $food->id]) }}" class="bg-green-500 text-white font-semibold px-4 py-2 rounded hover:bg-green-600">Add Discount</a>
                    @else
                        <span class="text-gray-500">Discount Added</span>
                    @endif
                    <a href="{{ route('discounts.show', ['food' => $food->id]) }}" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">View Discounts</a>
                </div>
            @endforeach
        </div>

        <h2 class="text-2xl font-semibold mb-4">All Discounts</h2>

        @if(count($discounts) > 0)
            <ul class="pl-6">
                @foreach($discounts as $discount)
                    <li class="mb-4">
                        <span class="font-semibold">Food Name:</span> {{ $discount->food->name }}<br>
                        <span class="font-semibold">Start Time:</span> {{ $discount->start_time }}<br>
                        <span class="font-semibold">End Time:</span> {{ $discount->end_time }}<br>
                        <span class="font-semibold">Discount:</span> {{ $discount->discount }}%<br>
                        <form action="{{ route('discounts.destroy', ['food' => $discount->food->id, 'discount' => $discount->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                        <a href="{{ route('discounts.edit', ['food' => $discount->food->id, 'discount' => $discount->id]) }}" class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No discounts available.</p>
        @endif

    </div>
@endsection
