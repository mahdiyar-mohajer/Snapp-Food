@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold">غذاها</h2>

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

                <div class="my-4">
                    <a href="{{ route('foods.create') }}" class="bg-green-500 text-white font-semibold px-4 py-2 rounded hover:bg-green-600">اضافه کردن غذا</a>
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
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($foods as $food)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->raw_material }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $food->price }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                                <a href="{{ route('foods.show', $food) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="{{ route('foods.edit', $food) }}" class="text-blue-500 hover:text-blue-700 ml-2">Edit</a>
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
    <script>
        const searchForm = document.getElementById('food-search-form');
        const searchInput = document.getElementById('food-search-input');
        const searchResults = document.getElementById('food-search-results');

        searchForm.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const filteredFoods = [];

            // Perform the client-side search
            for (const food of foods) {
                if (food.name.toLowerCase().includes(query) || food.raw_material.toLowerCase().includes(query)) {
                    filteredFoods.push(food);
                }
            }

            // Render the search results
            renderSearchResults(filteredFoods);
        });

        function renderSearchResults(results) {
            searchResults.innerHTML = '';

            if (results.length > 0) {
                for (const result of results) {
                    const resultItem = document.createElement('div');
                    resultItem.innerText = result.name;
                    searchResults.appendChild(resultItem);
                }
            } else {
                const noResultsMessage = document.createElement('div');
                noResultsMessage.innerText = 'No results found.';
                searchResults.appendChild(noResultsMessage);
            }
        }
    </script>
@endsection

