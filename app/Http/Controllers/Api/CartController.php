<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartController extends Controller
{
//    public function addItem(Request $request)
//    {
//        $foodId = $request->input('food_id');
//        $quantity = $request->input('quantity', 1);
//        $foodItem = Food::find($foodId);
//
//        if (!$foodItem) {
//            return response()->json(['message' => 'Food item not found'], 404);
//        }
//        if (!$request->session()->has('cart')) {
//            $request->session()->put('cart', []);
//        }
//
//        $cart = $request->session()->get('cart');
//
//        if (array_key_exists($foodId, $cart)) {
//            $cart[$foodId]['quantity'] += $quantity;
//        } else {
//            $cart[$foodId] = [
//                'food' => $foodItem,
//                'quantity' => $quantity,
//            ];
//        }
//
//        $request->session()->put('cart', $cart);
//
//        return response()->json(['message' => 'Food item added to cart'], 200);
//    }
//
//    public function removeItem(Request $request, $foodId)
//    {
//        $cart = $request->session()->get('cart');
//
//        if (array_key_exists($foodId, $cart)) {
//            unset($cart[$foodId]);
//            $request->session()->put('cart', $cart);
//
//            return response()->json(['message' => 'Food item removed from cart'], 200);
//        }
//
//        return response()->json(['message' => 'Food item not found in the cart'], 404);
//    }
//    public function viewCart(Request $request)
//    {
//        $cart = $request->session()->get('cart', []);
//
//        $totalPrice = 0;
//
//        foreach ($cart as $foodId => $cartItem) {
//            $foodItem = $cartItem['food'];
//            $quantity = $cartItem['quantity'];
//            $totalPrice += $foodItem->price * $quantity;
//        }
//
//        return response()->json([
//            'cart' => $cart,
//            'total_price' => $totalPrice,
//        ], 200);
//    }
//
//    public function clearCart(Request $request)
//    {
//        $request->session()->forget('cart');
//
//        return response()->json(['message' => 'Cart cleared'], 200);
//    }

    public function addItem(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity', 1);
        $foodItem = Food::find($foodId);

        if (!$foodItem) {
            return response()->json(['message' => 'Food item not found'], 404);
        }

        $cart = (array) Redis::hgetall('cart');

        if (array_key_exists($foodId, $cart)) {
            $cartItem = json_decode($cart[$foodId], true);
            $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] + $quantity : $quantity;
        } else {
            $cartItem = [
                'food' => $foodItem,
                'quantity' => $quantity,
            ];
        }

        $cart[$foodId] = json_encode($cartItem);

        Redis::hmset('cart', $cart);

        return response()->json(['message' => 'Food item added to cart'], 200);
    }

    public function removeItem(Request $request, $foodId)
    {
        if (Redis::ping()) {
            $cartItem = Redis::hget('cart', $foodId);

            if ($cartItem !== null) {
                Redis::hdel('cart', $foodId);

                return response()->json(['message' => 'Food item removed from cart'], 200);
            }
        }

        return response()->json(['message' => 'Food item not found in the cart'], 404);
    }

    public function viewCart(Request $request)
    {
        $cart = (array) Redis::hgetall('cart');

        $totalPrice = 0;
        foreach ($cart as $foodId => $cartItem) {
            $cartItem = json_decode($cartItem, true);
            $foodItem = Food::find($cartItem['food']['id'] ?? null); // Update this line
            $quantity = $cartItem['quantity'];
            if ($foodItem) {
                $totalPrice += $foodItem->price * $quantity;
                $cart[$foodId] = [
                    'food' => $foodItem,
                    'quantity' => $quantity,
                ];
            } else {
                unset($cart[$foodId]);
            }
        }

        return response()->json([
            'cart' => $cart,
            'total_price' => $totalPrice,
        ], 200);
    }

    public function clearCart(Request $request)
    {
        Redis::del('cart');

        return response()->json(['message' => 'Cart cleared'], 200);
    }
}
