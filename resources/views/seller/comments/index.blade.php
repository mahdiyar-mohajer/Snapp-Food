@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Seller Comments</h1>
        @error('reply')
        <p class="text-red-500">{{ $message }}</p>
        @enderror
        @if(session('success'))
            <div class="bg-green-200 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.comments.filter') }}" method="get" class="mb-4 flex items-center">
            <select name="food_filter" class="p-2 border rounded mr-2">
                <option value="">All Foods</option>
                @foreach($foodOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Filter</button>
        </form>

        <div id="comments-container">
            @foreach($comments as $comment)
                <div
                    class="bg-gray-100 p-4 mb-4 {{ $comment->approved ? 'border-green-500' : 'border-red-500' }} border-l-4">
                    <p class="text-lg font-semibold">Comment: {{ $comment->comment }}</p>
                    <p class="text-gray-600">Rating: {{ $comment->rating }}</p>

                    @if($comment->user)
                        <p class="text-purple-500">User: {{ $comment->user->name }}</p>
                    @endif

                    @if($comment->order)
                        <p class="text-blue-500">Order: {{ $comment->order->id }}</p>

                        @if ($comment->order->orderItems->count() > 0)
                            <p class="text-green-500">Food Items:</p>
                            <ul>
                                @foreach($comment->order->orderItems as $orderItem)
                                    <li>{{ $orderItem->food->name }} (تعداد: {{ $orderItem->count }})</li>
                                @endforeach
                            </ul>
                        @endif
                    @elseif($comment->food_id && $comment->food && $comment->food->resturant)
                        <p class="text-green-500">Food: {{ $comment->food->name }}({{ $comment->food->resturant->name }}
                            )</p>
                    @elseif($comment->resturant)
                        <p class="text-orange-500">Restaurant: {{ $comment->resturant->name }}</p>
                    @endif
                    @if($comment->approved)
                        <span class="bg-green-500 text-white px-2 py-1 rounded">Approved</span>
                    @else
                        <span class="bg-red-500 text-white px-2 py-1 rounded">Not Approved</span>

                        <form action="{{ route('comments.approve', ['id' => $comment->id]) }}" method="post"
                              class="mt-2">
                            @csrf
                            @method('post')
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Approve Comment
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('comments.submitDeleteRequest', ['id' => $comment->id]) }}" method="post"
                          class="mb-2">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-red-500 text-white p-2 rounded">Submit Delete Request</button>
                    </form>

                    <div class="mt-4">
                        <form action="{{ route('comments.reply', $comment) }}" method="post" class="reply-form">
                            @csrf
                            <textarea name="reply" class="w-full p-2 border rounded"
                                      placeholder="Reply to this comment"></textarea>
                            <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded">Reply</button>
                        </form>
                    </div>

                    @if ($comment->replies->count() > 0)
                        @foreach($comment->replies as $reply)
                            <div class="bg-gray-200 p-2 mt-2">
                                <p>Reply: {{ $reply->comment }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr class="my-2">
            @endforeach
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#food-filter').on('change', function () {
                var selectedFood = $(this).val();

                $('.comment-container').each(function () {
                    var commentFood = $(this).data('food');

                    if (selectedFood === '' || selectedFood === commentFood) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

@endsection



