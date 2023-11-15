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
        <h1 class="text-3xl font-semibold mb-6">Restaurant List</h1>

{{--        <a href="{{ route('admin.restaurants.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 inline-block">--}}
{{--            Add Restaurant--}}
{{--        </a>--}}

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="border-b p-2">ID</th>
                <th class="border-b p-2">Name</th>
                <th class="border-b p-2">User</th>
                <th class="border-b p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($restaurants as $restaurant)
                <tr>
                    <td class="border-b p-2">{{ $restaurant->id }}</td>
                    <td class="border-b p-2">{{ $restaurant->name }}</td>
                    <td class="border-b p-2">{{ $restaurant->user->email }}</td>
                    <td class="border-b p-2">
                        <form action="{{ route('admin.restaurant.toggleActivation') }}" method="post">
                            @csrf
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                            <button type="submit"
                                    class="px-4 py-2 rounded {{ $restaurant->status == 1 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                {{ $restaurant->status == 1 ? 'Deactivate' : 'Activate' }} Restaurant
                            </button>
                        </form>
                    </td>

                    <td class="border-b p-2">
                        <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td class="border-b p-2" colspan="3">No restaurants found.</td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>

@endsection
