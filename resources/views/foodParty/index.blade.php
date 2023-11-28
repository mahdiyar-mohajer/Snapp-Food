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
                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Food Name</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($foods as $food)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $food->name }}</td>
                            <td class="px-4 py-2 border-b space-x-2">
                                @if (!$food->foodParty)
                                    <a href="{{ route('foodParty.create', ['food' => $food->id]) }}" class="bg-green-500 text-white font-semibold px-3 py-1 rounded hover:bg-green-600">Add</a>
                                @else
                                    <span class="text-gray-500">Added</span>
                                @endif

                                    <a href="{{ route('foodParty.show', ['food' => $food->id]) }}" class="bg-blue-500 text-white font-semibold px-3 py-1 rounded hover:bg-blue-600">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($foodParties) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Start Time</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">End Time</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Count</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Discount</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($foodParties as $foodParty)
                        <tr>
                            <td class="border-b px-6 py-4">{{ $foodParty->start_time }}</td>
                            <td class="border-b px-6 py-4">{{ $foodParty->end_time }}</td>
                            <td class="border-b px-6 py-4">{{ $foodParty->count }}</td>
                            <td class="border-b px-6 py-4">{{ $foodParty->discount }}%</td>
                            <td class="border-b px-6 py-4">
                                <form action="{{ route('foodParty.destroy', ['food' => $foodParty->food->id, 'foodParty' => $foodParty['id']]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                                <a href="{{ route('foodParty.edit', ['food' => $foodParty->food->id, 'foodParty' => $foodParty['id']]) }}" class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $foodParties->links('custom-pagination') }}
            </div>
        @else
            <p class="text-gray-500">No food parties available.</p>
        @endif
    </div>
@endsection
