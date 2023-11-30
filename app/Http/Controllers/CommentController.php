<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $restaurantId = Auth::user()->resturant->id;

        $comments = Comment::with(['food', 'order.orderItems.food'])
            ->where('resturant_id', $restaurantId)
            ->orderBy('created_at', 'desc')
            ->get();

        $foodOptions = $comments->pluck('food.name')->unique()->filter()->toArray();

        $orderFoodOptions = $comments->pluck('order.orderItems')->flatten(1)->pluck('food.name')->unique()->filter()->toArray();

        $mergedFoodOptions = array_merge($foodOptions, $orderFoodOptions);

        $foodOptions = array_unique($mergedFoodOptions);

        return view('seller.comments.index', compact('comments', 'foodOptions'));
    }

    public function reply(Request $request, Comment $comment)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'reply' => 'required|string',
        ]);
        $reply = new Comment([
            'comment' => $request->input('reply'),
            'rating' => $request->input('rating', 0),
            'user_id' => $user->id,
            'parent_id' => $comment->id,
            'commentable_id' => $comment->commentable_id,
            'commentable_type' => $comment->commentable_type,
        ]);

        $reply->save();

        return back()->with('success', 'Reply added successfully');
    }

    public function filter(Request $request)
    {
        $foodFilter = $request->input('food_filter');
        $restaurantId = Auth::user()->resturant->id;

        $filteredComments = Comment::with([
            'user',
            'order.orderItems.food',
            'food.resturant',
            'replies'
        ])
            ->where('resturant_id', $restaurantId)
            ->when($foodFilter, function ($query) use ($foodFilter) {
                $query->whereHas('food', function ($query) use ($foodFilter) {
                    $query->where('foods.name', $foodFilter);
                })
                    ->orWhereHas('order.orderItems.food', function ($query) use ($foodFilter) {
                        $query->where('foods.name', $foodFilter);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.comments.filtered', ['filteredComments' => $filteredComments]);
    }


    public function submitDeleteRequest($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->update(['delete_request' => true]);

        return redirect()->back()->with('success', 'Delete request submitted successfully.');
    }


}
