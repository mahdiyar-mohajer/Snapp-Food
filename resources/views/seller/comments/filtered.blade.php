@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Filtered Seller Comments</h1>

        <div id="filtered-comments-container">
            @foreach($filteredComments as $comment)
                <div class="comment-container bg-gray-100 p-4 mb-4">
                    <p class="text-lg font-semibold">Comment: {{ $comment->comment }}</p>
                    <p class="text-gray-600">Rating: {{ $comment->rating }}</p>

                    @if($comment->user)
                        <p class="text-purple-500">User: {{ $comment->user->name }}</p>
                    @endif

                    @if($comment->food)
                        <p class="text-green-500">Food: {{ $comment->food->name }}</p>
                    @endif

                    @if($comment->order)
                        <p class="text-blue-500">Order: {{ $comment->order->id }}</p>

                        @if ($comment->order->orderItems->count() > 0)
                            <p class="text-green-500">Food Items in Order:</p>
                            <ul>
                                @foreach($comment->order->orderItems as $orderItem)
                                    <li>{{ optional($orderItem->food)->name }} (تعداد: {{ $orderItem->count }})</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif

                    <div class="mt-4">
                        <form action="{{ route('comments.reply', $comment) }}" method="post" class="reply-form">
                            @csrf
                            <textarea name="reply" class="w-full p-2 border rounded" placeholder="Reply to this comment"></textarea>
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
@endsection


