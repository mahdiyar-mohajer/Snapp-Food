<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getRestaurantComments(Request $request)
    {
        $restaurantId = $request->input('resturant_id');

        $comments = Comment::where('resturant_id', $restaurantId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments, 200);
    }

    public function getFoodComments(Request $request)
    {
        $foodId = $request->input('food_id');

        $comments = Comment::where('food_id', $foodId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments, 200);
    }
//    public function postComment(Request $request)
//    {
//        $request->validate([
//            'food_id' => 'required',
//            'resturant_id' => 'required',
////            'cart_id' => 'required',
//            'rating' => 'required',
//            'comment' => 'required',
//        ]);
//
//        $comment = new Comment();
//        $comment->food_id = $request->input('food_id');
//        $comment->resturant_id = $request->input('resturant_id');
////        $comment->cart_id = $request->input('cart_id');
//        $comment->rating = $request->input('rating');
//        $comment->comment = $request->input('comment');
//
//        $comment->user_id = Auth::id();
//
//        $comment->save();
//
//        return response()->json(['message' => 'کامنت با موفقیت اضافه شد'], 201);
//    }


    public function storeOnFood(Request $request, Food $food)
    {
        return $this->storeComment($request, $food);
    }

    public function storeOnRestaurant(Request $request, Resturant $restaurant)
    {
        return $this->storeComment($request, $restaurant);
    }

    public function storeOnOrder(Request $request, Order $order)
    {
        return $this->storeComment($request, $order);
    }

    protected function storeComment(Request $request, $model)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer',
        ]);

        $user = auth()->user();

        if ($user) {
            $order = Order::where('user_id', $user->id)->where('status', 'DONE')->latest()->first();

            $food_id = null;
            $resturant_id = null;
            $order_id = null;

            if ($model instanceof Food) {
                $food_id = $model->id;
                $resturant_id = $model->resturant_id;
            } elseif ($model instanceof Resturant) {
                $resturant_id = $model->id;
            } elseif ($model instanceof Order) {
                $order_id = $model->id;
                $resturant_id = $model->resturant_id;
            }

            if ($order) {
                $comment = new Comment([
                    'comment' => $request->input('comment'),
                    'rating' => $request->input('rating'),
                    'user_id' => $user->id,
                    'food_id' => $food_id,
                    'resturant_id' => $resturant_id,
                    'order_id' => $order_id,
                ]);

                if ($model instanceof OrderItem) {
                    $food = Food::find($model->food_id);
                    if ($food) {
                        $comment->food_id = $food->id;
                    }
                }

                $model->comments()->save($comment);

                return response()->json(['message' => 'Comment added successfully'], 201);
            } else {
                return response()->json(['message' => 'No active order found for the user.'], 404);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

}
