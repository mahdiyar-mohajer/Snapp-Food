@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold">Create Food Item</h2>

                <form action="{{ route('foods.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class=" mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="raw_material" class="block text-sm font-medium text-gray-700">Raw Material</label>
                        <input type="text" name="raw_material" id="raw_material" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Food Categories</label>
                        @foreach($foodCategories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="foodCategories[]" value="{{ $category->id }}" class="mr-2">
                                <span>{{ $category->name }}</span>
                            </div>
                        @endforeach
                    </div>

                    <label for="food_image">food Image</label>
                    <input type="file" name="food_image" multiple>

                    <div class="text-center mt-2">
                        <button type="submit"
                                class="bg-blue-500 text-white font-semibold px-4 py-2 rounded hover:bg-blue-600">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
