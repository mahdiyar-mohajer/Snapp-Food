<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function addItem(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity', 1);
        $restaurantId = $request->input('resturant_id');

        $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
        if (!$foodItem) {
            return response()->json(['message' => 'غذا پیدا نشد'], 404);
        }

        $restaurant = Resturant::find($restaurantId);
        if (!$restaurant) {
            return response()->json(['message' => 'رستوران پیدا نشد'], 404);
        }
        $cartId = Str::uuid();
        $cartKey = $restaurantId . '_' . $foodId . '_' . $cartId;

        $cart = (array) Redis::hgetall('cart');

        if (array_key_exists($cartKey, $cart)) {
            $cartItem = json_decode($cart[$cartKey], true);
            $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] + $quantity : $quantity;
        } else {
            $cartItem = [
                'id' => $cartId,
                'food' => $foodItem,
                'quantity' => $quantity,
            ];
        }

        $cartItem['cart_id'] = $cartId;

        $cart[$cartKey] = json_encode($cartItem);
        Redis::hmset('cart', $cart);

        return response()->json(['message' => 'غذا به سبد خرید اضافه شد'], 200);
    }

    public function removeItem(Request $request, $foodId)
    {
        if (Redis::ping()) {
            $cartItem = Redis::hget('cart', $foodId);

            if ($cartItem !== null) {
                Redis::hdel('cart', $foodId);
                return response()->json(['message' => 'غذا از سبد خرید حذف شد'], 200);
            }
        }

        return response()->json(['message' => 'غذای مورد نظر در سبد خرید پیدا نشد'], 404);
    }

    public function viewCart(Request $request)
    {
        $cart = (array) Redis::hgetall('cart');
        $totalPrice = 0;
        $cartDetails = [];

        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);

            if (str_contains($cartKey, '_')) {
                [$restaurantId, $foodId, $cartId] = explode('_', $cartKey);
                $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
                $quantity = $cartItem['quantity'];

                if ($foodItem) {
                    $restaurant = Resturant::find($restaurantId);

                    if ($restaurant) {
                        $totalPrice += $foodItem->price * $quantity;

                        if (!isset($cartDetails[$restaurantId])) {
                            $cartDetails[$restaurantId] = [
                                'cart_id' => $cartId,
                                'restaurant' => [
                                    'id' => $restaurant->id,
                                    'name' => $restaurant->name,
                                    'image' => $restaurant->image,
                                ],
                                'items' => [],
                            ];
                        }

                        $cartDetails[$restaurantId]['items'][] = [
                            'id' => $foodItem->id,
                            'name' => $foodItem->name,
                            'image' => $foodItem->image,
                            'quantity' => $quantity,
                            'price' => $foodItem->price,
                        ];
                    } else {
                        unset($cart[$cartKey][0]);
                    }
                } else {
                    unset($cart[$cartKey]);
                }
            }
        }

        return response()->json([
            'carts' => array_values($cartDetails),
            'total_price' => $totalPrice,
        ], 200);
    }

    public function clearCart(Request $request)
    {
        Redis::del('cart');
        return response()->json(['message' => 'سبد خرید خالی شد'], 200);
    }
    public function updateCartItem(Request $request, $foodId)
    {
        $quantity = $request->input('quantity');

        if (!is_numeric($quantity) || $quantity <= 0) {
            return response()->json(['message' => 'مقدار نامعتبر برای تعداد وارد شده است'], 400);
        }

        $cartKey = $foodId;
        $cart = (array) Redis::hgetall('cart');

        if (array_key_exists($cartKey, $cart)) {
            $cartItem = json_decode($cart[$cartKey], true);
            $cartItem['quantity'] = $quantity;

            $foodItem = Food::find($foodId);

            if ($foodItem) {
                $cart[$cartKey] = json_encode($cartItem);
                Redis::hmset('cart', $cart);

                return response()->json(['message' => 'تعداد آیتم در سبد خرید به‌روز شد'], 200);
            } else {
                unset($cart[$cartKey]);
                Redis::hmset('cart', $cart);
                return response()->json(['message' => 'غذای مورد نظر در سبد خرید پیدا نشد'], 404);
            }
        }

        return response()->json(['message' => 'غذای مورد نظر در سبد خرید پیدا نشد'], 404);
    }
}
