@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Edit Banner</h1>

{{--        @if ($errors->any())--}}
{{--            <div class="bg-red-200 text-red-800 p-4 mb-4">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}

        <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" class="form-input w-full border rounded-md" value="{{ old('title', $banner->title) }}">
                @error('title')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Text:</label>
                <textarea name="text" id="text" class="form-textarea w-full border rounded-md" >{{ old('text', $banner->text) }}</textarea>
                @error('text')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>

                @if($banner->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $banner->image->url) }}" alt="Current Image" class="max-w-full h-auto">
                    </div>
                @endif

                <input type="file" name="image" id="image" class="form-input w-full border rounded-md">

                @error('image')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-0.5 rounded relative text-right" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Banner
            </button>
        </form>
    </div>
@endsection
