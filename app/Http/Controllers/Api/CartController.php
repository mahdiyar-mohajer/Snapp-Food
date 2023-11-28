<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function addItem(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity', 1);
        $restaurantId = $request->input('resturant_id');

        $validationResult = $this->validateRequest($foodId, $restaurantId);

        if ($validationResult) {
            return $validationResult;
        }

        $cart = $this->getCart();

        list($cart, $cartId) = $this->handleCartItem($foodId, $restaurantId, $quantity, $cart);

        Redis::hmset('cart', $cart);

        $totalFoodPrice = $this->calculateTotalFoodPrice($cart, $restaurantId);

        return response()->json([ 'total_food_price' => $totalFoodPrice], 200);
    }

    private function handleCartItem($foodId, $restaurantId, $quantity, $cart)
    {
        $cartId = Str::uuid();
        $cartKey = $restaurantId . '_' . $foodId . '_' . $cartId;

        if (!isset($cart['resturant_id'])) {
            $cart['resturant_id'] = $restaurantId;
        }

        $found = false;

        foreach ($cart as $existingCartKey => $existingCartItem) {
            $existingCartItem = json_decode($existingCartItem, true);

            if (
                is_array($existingCartItem) &&
                isset($existingCartItem['food']['id']) &&
                $existingCartItem['food']['id'] == $foodId &&
                str_contains($existingCartKey, $restaurantId)
            ) {
                $existingCartItem['quantity'] += $quantity;
                $cart[$existingCartKey] = json_encode($existingCartItem);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart = $this->addNewCartItem($foodId, $quantity, $cartId, $cart, $cartKey);
        }

        return array($cart, $cartId);
    }

    public function approveOrder($cartId)
    {
        $userId = auth()->user()->id;

        $cart = (array) Redis::hgetall('cart');

        $restaurantId = $cart['resturant_id'] ?? null;

        if (!$restaurantId) {
            return response()->json(['message' => 'Restaurant ID not found in the cart'], 400);
        }

        $totalFoodPrice = $this->calculateTotalFoodPrice($cart, $restaurantId);
        $totalOrderPrice = $this->calculateTotalOrderPrice($totalFoodPrice, $restaurantId);
        $order = $this->createOrder($totalOrderPrice, $restaurantId);

        $this->addOrderItemsToOrder($cart, $order, $restaurantId);

        Redis::del('cart');

        return response()->json(['message' => 'سفارش با موفقیت تایید شد.', 'order_id' => $order->id], 200);
    }

    private function validateRequest($foodId, $restaurantId)
    {
        $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
        $restaurant = Resturant::find($restaurantId);
        if (!$restaurant) {
            return response()->json(['message' => 'رستوران پیدا نشد'], 404);
        }
        if (!$foodItem) {
            return response()->json(['message' => 'غذا پیدا نشد'], 404);
        }

        return null;
    }

    private function getCart()
    {
        $cart = (array) Redis::hgetall('cart');
        return $cart;
    }

    private function updateExistingCartItem($cartKey, $quantity, $cart)
    {
        $cartItem = json_decode($cart[$cartKey], true);

        $cartItem['quantity'] = $quantity;

        $foodItem = Food::find($cartItem['food']['id']);

        if ($foodItem) {
            $cart[$cartKey] = json_encode($cartItem);

            Redis::hmset('cart', $cart);

            return $cart;
        } else {
            unset($cart[$cartKey]);
            Redis::hmset('cart', $cart);

            return $cart;
        }
    }

    private function addNewCartItem($foodId, $quantity, $cartId, $cart, $cartKey)
    {
        $foodItem = Food::find($foodId);
        $cartItem = [
            'id' => $cartId,
            'food' => $foodItem,
            'quantity' => $quantity,
        ];
        $cartItem['cart_id'] = $cartId;
        $cart[$cartKey] = json_encode($cartItem);
        return $cart;
    }

    private function calculateTotalOrderPrice($totalFoodPrice, $restaurantId)
    {
        $restaurant = Resturant::find($restaurantId);

        $shippingPrice = $restaurant->ship_price;

        $totalOrderPrice = $totalFoodPrice + $shippingPrice;

        return $totalOrderPrice;
    }

    private function createOrder($totalOrderPrice, $restaurantId)
    {
        $userId = auth()->user()->id;
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $totalOrderPrice,
            'resturant_id' => $restaurantId,
            'status' => 'PENDING',
        ]);
        return $order;
    }

    private function calculateTotalFoodPrice(array $cart, int $restaurantId): float
    {
        $totalFoodPrice = 0;

        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);

            if (is_array($cartItem) && isset($cartItem['food']['id'])) {
                $foodId = $cartItem['food']['id'];
                $quantity = $cartItem['quantity'];

                $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
                if ($foodItem) {
                    $totalFoodPrice += $foodItem->price * $quantity;
                }
            }
        }

        return $totalFoodPrice;
    }

    private function addOrderItemsToOrder(array $cart, Order $order, int $restaurantId): void
    {
        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);

            if (is_array($cartItem) && isset($cartItem['food']['id'])) {
                $foodId = $cartItem['food']['id'];
                $quantity = $cartItem['quantity'];

                $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
                if ($foodItem) {
                    $orderItem = new OrderItem([
                        'food_id' => $foodId,
                        'count' => $quantity,
                        'price' => $foodItem->price,
                    ]);
                    $order->items()->save($orderItem);
                }
            }
        }
    }



    public function removeItem(Request $request, $foodId)
    {
        $cart = $this->getCart();

        if (!empty($cart)) {
            $cartKey = $this->findCartItemKey($cart, $foodId);

            if ($cartKey !== null) {
                Redis::hdel('cart', $cartKey);
                return response()->json(['message' => 'غذا از سبد خرید حذف شد'], 200);
            }
        }

        return response()->json(['message' => 'غذای مورد نظر در سبد خرید پیدا نشد'], 404);
    }

    private function findCartItemKey(array $cart, $foodId)
    {
        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);

            if (is_array($cartItem) && isset($cartItem['food']['id']) && $cartItem['food']['id'] == $foodId) {
                return $cartKey;
            }
        }

        return null;
    }

    public function viewCart(Request $request)
    {
        $cart = (array) Redis::hgetall('cart');
        $totalPrice = 0;
        $cartDetails = [];

        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);

            if (!str_contains($cartKey, '_')) {
                unset($cart[$cartKey]);
                continue;
            }

            $explodedKeys = explode('_', $cartKey);

            if (count($explodedKeys) < 3) {
                unset($cart[$cartKey]);
                continue;
            }

            [$restaurantId, $foodId, $cartId] = $explodedKeys;


            $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);

            if (!$foodItem) {
                unset($cart[$cartKey]);
                continue;
            }

            $quantity = $cartItem['quantity'];
            $restaurant = Resturant::find($restaurantId);

            if (!$restaurant) {
                unset($cart[$cartKey]);
                continue;
            }

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
        }
//        $shippingPrice =  $restaurant->ship_price;

//        $totalPrice += $shippingPrice;

        return response()->json([
            'carts' => array_values($cartDetails),
            'total_price' => $totalPrice,
//            'shipping_price' => $shippingPrice,
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



    public function viewOrderStatus(Request $request, $orderId)
    {
        $userId = auth()->user()->id;
        $order = Order::where('user_id', $userId)->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'سفارش پیدا نشد'], 404);
        }

        return response()->json(['status' => $order->status], 200);
    }
}
