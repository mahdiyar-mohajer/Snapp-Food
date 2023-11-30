@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-2xl font-semibold mb-6">ویرایش دسته بندی غذا</h1>
        <form action="{{ route('food-categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">اسم دسته بندی</label>
                <input type="text" name="name" id="name" class="block w-full mt-1 py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300" value="{{ $category->name }}">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">به روز رسانی</button>
        </form>
    </div>
@endsection
