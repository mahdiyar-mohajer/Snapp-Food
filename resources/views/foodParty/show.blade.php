@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8 mx-4">
        <h2 class="text-2xl font-semibold mb-4">Food Parties for {{ $food->name }}</h2>

        @if(count($foodPartiesPrices) > 0)
            <ul class="pl-6">
                @foreach($foodPartiesPrices as $foodParty)
                    <li class="mb-4">
                        <span class="font-semibold">Start Time:</span> {{ $foodParty['start_time'] }}<br>
                        <span class="font-semibold">End Time:</span> {{ $foodParty['end_time'] }}<br>
                        <span class="font-semibold">Count:</span> {{ $foodParty['count'] }}<br>
                        <span class="font-semibold">Discount:</span> {{ $foodParty['discount'] }}%<br>
                        <span class="font-semibold">مبلغ نهایی:</span> {{ $foodParty['discounted_price'] }} تومان<br>
                        <a href="{{ route('foodParty.edit', ['food' => $food->id, 'foodParty' => $foodParty['id'] ]) }}" class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>

                        <form action="{{ route('foodParty.destroy', ['food' => $food->id, 'foodParty' => $foodParty['id']]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No food parties available for {{ $food->name }}.</p>
        @endif
    </div>
@endsection




