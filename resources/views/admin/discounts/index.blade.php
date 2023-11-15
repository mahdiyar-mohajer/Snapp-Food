@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto my-4">
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
        <h2 class="text-2xl font-semibold mb-4">All Discounts (Admin)</h2>

        @if(count($discounts) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead>
                    <tr>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Restaurant Name</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Food Name</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Start Time</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">End Time</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Discount</th>
                        <th class="border-b font-semibold text-sm text-gray-800 px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $discount)
                        <tr>
                            <td class="border-b px-6 py-4">
                                @if ($discount->resturant)
                                    {{ $discount->resturant->name }}
                                @else
                                    <span class="text-red-500">Restaurant not found</span>
                                @endif
                            </td>
                            <td class="border-b px-6 py-4">{{ $discount->food->name }}</td>
                            <td class="border-b px-6 py-4">{{ $discount->start_time }}</td>
                            <td class="border-b px-6 py-4">{{ $discount->end_time }}</td>
                            <td class="border-b px-6 py-4">{{ $discount->discount }}%</td>
                            <td class="border-b px-6 py-4">
                                <a href="{{ route('admin.discounts.edit', $discount) }}"
                                   class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                                <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No discounts available.</p>
        @endif
    </div>
@endsection
