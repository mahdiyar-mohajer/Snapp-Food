@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="py-6">
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold">غذاها</h2>


                <div class="my-4">
                    <input type="text" name="search" id="foodSearch" class="border p-2" placeholder="Search for foods">
                </div>
                <div id="searchResults">
                    <!-- The search results will be displayed here -->
                </div>


                <div class=" my-4">
                    <a href="{{ route('foods.create') }}"
                       class="bg-green-500 text-white font-semibold px-4 py-2 rounded hover:bg-green-600">اضافه کردن
                        غذا</a>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            اسم
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            مواد تشکیل دهنده
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            قیمت
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            عکس
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            دسته‌بندی‌ها
                        </th>
                        <th class="px-6 py-3 bg-gray-50">اکشن</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($foods as $food)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->raw_material }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->price }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                @if ($food->image)
                                    <img src="{{ asset('storage/' . $food->image->url) }}" alt="{{ $food->name }}"
                                         class="w-16 h-16 object-cover rounded-md">
                                @else
                                    <img src="#" alt="No Image" class="w-16 h-16 object-cover rounded-md">
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                @foreach ($food->foodCategories as $category)
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                                <a href="{{ route('foods.show', $food) }}"
                                   class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="{{ route('foods.edit', $food) }}"
                                   class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
                                <form action="{{ route('foods.destroy', $food) }}" method="POST" class="inline">
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
        </div>
    </div>

    <script>
        setTimeout(function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (message) {
                message.style.display = 'none';
            });
        }, 5000); // 10 seconds
    </script>

@endsection

