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
    public function getComments(Request $request)
    {
        $foodId = $request->input('food_id');
        $restaurantId = $request->input('resturant_id');

        $comments = Comment::where('food_id', $foodId)
            ->where('resturant_id', $restaurantId)
            ->with('user:name')
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
            // Find the order associated with the user
            $order = Order::where('user_id', $user->id)->where('status', 'DONE')->latest()->first();

            // Initialize variables for food_id, resturant_id, and order_id
            $food_id = null;
            $resturant_id = null;
            $order_id = null;

            // Check the type of model and set corresponding values
            if ($model instanceof Food) {
                $food_id = $model->id;
                $resturant_id = $model->resturant_id;
            } elseif ($model instanceof Resturant) {
                $resturant_id = $model->id;
            } elseif ($model instanceof Order) {
                $order_id = $model->id;
                $resturant_id = $model->resturant_id; // Add this line
            }

            if ($order) {
                // If the user has an active order, associate the comment with the order
                $comment = new Comment([
                    'comment' => $request->input('comment'),
                    'rating' => $request->input('rating'),
                    'user_id' => $user->id,
                    'food_id' => $food_id,
                    'resturant_id' => $resturant_id,
                    'order_id' => $order_id,
                ]);

                // Check if the comment is associated with an order item
                if ($model instanceof OrderItem) {
                    // If it's an order item, find the corresponding food
                    $food = Food::find($model->food_id);
                    if ($food) {
                        $comment->food_id = $food->id;
                    }
                }

                // Associate the comment with the specific model (Food, Restaurant, or Order)
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
