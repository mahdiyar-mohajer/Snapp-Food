@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Banners</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('banners.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-4 inline-block">
            Add Banner
        </a>

        <table class="min-w-full table-auto m-4">
            <thead>
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Text</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($banners as $banner)
                <tr>
                    <td class="border px-4 py-2">{{ $banner->id }}</td>
                    <td class="border px-4 py-2">{{ $banner->title }}</td>
                    <td class="border px-4 py-2">
                        @if ($banner->image)
                            <img src="{{ asset('storage/' . $banner->image->url) }}" alt="Banner Image" class="h-12">
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $banner->text }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('banners.edit', $banner->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded inline-block">
                            Edit
                        </a>
                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="border px-4 py-2" colspan="5">No banners available.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <script>
        setTimeout(function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (message) {
                message.style.display = 'none';
            });
        }, 5000); // 10 seconds
    </script>
@endsection
