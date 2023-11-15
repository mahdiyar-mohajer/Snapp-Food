@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8 mx-4">
        <h2 class="text-2xl font-semibold mb-4">تخفیف برای  {{ $food->name }}</h2>

        @if(count($discountedPrices) > 0)
            <ul class="pl-6">
                @foreach($discountedPrices as $discount)
                    <li class="mb-4">
                        <span class="font-semibold">ساعت شروع:</span> {{ $discount['start_time'] }}<br>
                        <span class="font-semibold">ساعت پایان:</span> {{ $discount['end_time'] }}<br>
                        <span class="font-semibold">درصد تخفیف:</span> {{ $discount['discount'] }}%<br>
                        <span class="font-semibold">مبلغ نهایی:</span> {{ $discount['discounted_price'] }} تومان<br><a href="{{ route('discounts.edit', ['food' => $food->id, 'discount' => $discount['id'] ]) }}" class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                        <form action="{{ route('discounts.destroy', ['food' => $food->id, 'discount' => $discount['id']]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No discounts available for {{ $food->name }}.</p>
        @endif
    </div>
@endsection




