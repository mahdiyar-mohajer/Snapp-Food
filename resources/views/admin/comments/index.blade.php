@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Admin Comments</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div id="comments-container">
            @foreach($groupedComments as $restaurantName => $comments)
                <h2 class="text-2xl font-bold mb-2">
                    <a href="javascript:void(0);" class="restaurant-link" data-restaurant="{{ $restaurantName }}">{{ $restaurantName }}</a>
                </h2>

                <div class="restaurant-comments" id="restaurant-comments-{{ $restaurantName }}" style="display: none;"></div>

                <hr class="my-2">

                @foreach($comments as $comment)
                    @if (!$comment->parent_id)
                        <div class="bg-gray-100 p-4 mb-4">
                            <p class="text-lg font-semibold">Comment: {{ $comment->comment }}</p>
                            <p class="text-gray-600">Rating: {{ $comment->rating }}</p>

                            <form action="{{ route('comments.destroy', $comment) }}" method="post" class="mb-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Comment</button>
                            </form>

                            <a href="{{ route('comments.edit', $comment) }}" class="text-blue-500">Edit Comment</a>


                            @if ($comment->replies->count() > 0)
                                <div class="bg-gray-200 p-2 mt-2">
                                    <p>Replies:</p>
                                    @foreach($comment->replies as $reply)
                                        <div class="bg-gray-100 p-4 mb-4">
                                            <p class="text-lg font-semibold">Reply: {{ $reply->comment }}</p>
                                            <form action="{{ route('comments.destroy', $reply) }}" method="post" class="mb-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Reply</button>
                                            </form>
                                            <a href="{{ route('comments.edit', $reply) }}" class="text-blue-500">Edit Reply</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <hr class="my-2">
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.restaurant-link').on('click', function () {
                var restaurantName = $(this).data('restaurant');
                var commentsContainer = $('#restaurant-comments-' + restaurantName);

                if (commentsContainer.is(':empty')) {
                    $.ajax({
                        url: '/admin/comments/' + restaurantName + '/fetch',
                        method: 'GET',
                        success: function(response) {
                            var comments = response.comments;
                            commentsContainer.html('<p>Comments:</p>');
                            $.each(comments, function(index, comment) {
                                commentsContainer.append('<div class="bg-gray-100 p-4 mb-4"><p class="text-lg font-semibold">Comment: ' + comment.comment + '</p><p class="text-gray-600">Rating: ' + comment.rating + '</p><form action="{{ route('comments.destroy', ':commentId') }}" method="post" class="mb-2">@csrf @method('DELETE')<button type="submit" class="bg-red-500 text-white p-2 rounded">Delete Comment</button></form><a href="{{ route('comments.edit', ':commentId') }}" class="text-blue-500">Edit Comment</a></div><hr class="my-2">'.replace(':commentId', comment.id));
                            });

                            commentsContainer.slideDown();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    commentsContainer.slideToggle();
                }
            });
        });
    </script>
@endsection

