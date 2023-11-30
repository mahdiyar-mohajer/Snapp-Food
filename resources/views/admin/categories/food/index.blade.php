@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto mt-10 p-5">
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
        <h1 class="text-2xl font-semibold mb-6">دسته بندی غذا</h1>
        <a href="{{ route('food-categories.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">ایجاد دسته بندی</a>
        <table class="table-auto w-full">
            <thead>
            <tr>
                <th class="px-4 py-2">نام</th>
                <th class="px-4 py-2">اکشن</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2 flex">
                        <a href="{{ route('food-categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">ویرایش</a>
                        <form action="{{ route('food-categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
