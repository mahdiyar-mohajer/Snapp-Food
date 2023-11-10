<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComments(Request $request)
    {
        $foodId = $request->input('food_id');
        $restaurantId = $request->input('resturant_id');

        $comments = Comment::where('food_id', $foodId)
            ->where('resturant_id', $restaurantId)
            ->with('user:name')
            ->get();

        return response()->json($comments);
    }
    public function postComment(Request $request)
    {
        $request->validate([
            'food_id' => 'required',
            'resturant_id' => 'required',
//            'cart_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->food_id = $request->input('food_id');
        $comment->resturant_id = $request->input('resturant_id');
//        $comment->cart_id = $request->input('cart_id');
        $comment->rating = $request->input('rating');
        $comment->comment = $request->input('comment');

        $comment->user_id = Auth::id();

        $comment->save();

        return response()->json(['message' => 'کامنت با موفقیت اضافه شد']);
    }
}
