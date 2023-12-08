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
            ->where('approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments, 200);
    }

    public function getFoodComments(Request $request)
    {
        $foodId = $request->input('food_id');

        $comments = Comment::where('food_id', $foodId)
            ->where('approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments, 200);
    }


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
            if ($user->comments()->where('commentable_type', get_class($model))->where('commentable_id', $model->id)->exists()) {
                return response()->json(['message' => 'You have already commented on this item.'], 400);
            }

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
