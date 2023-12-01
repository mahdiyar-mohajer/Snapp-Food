@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Edit Comment</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('comments.update', $comment) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="comment" class="block text-gray-600">Comment:</label>
                <textarea name="comment" id="comment" class="w-full p-2 border rounded">{{ $comment->comment }}</textarea>
            </div>

            <div class="mb-4">
                <label for="rating" class="block text-gray-600">Rating:</label>
                <input type="number" name="rating" id="rating" class="w-full p-2 border rounded" value="{{ $comment->rating }}">
            </div>

            <!-- سایر فیلدها -->

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update Comment</button>
        </form>
    </div>
@endsection
