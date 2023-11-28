@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Create Banner</h1>

        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" class="form-input w-full border rounded-md">
                @error('title')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Text:</label>
                <textarea name="text" id="text" class="form-textarea w-full border rounded-md"></textarea>
                @error('text')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                <input type="file" name="image" id="image" class="form-input w-full border rounded-md">
                @error('image')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Banner
            </button>
        </form>
    </div>
@endsection
