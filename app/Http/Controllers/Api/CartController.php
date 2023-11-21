<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartController extends Controller
{


//    public function addItem(Request $request)
//    {
//        $foodId = $request->input('food_id');
//        $quantity = $request->input('quantity', 1);
//        $restaurantId = $request->input('resturant_id');
//
//        $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
//        if (!$foodItem) {
//            return response()->json(['message' => 'غذا پیدا نشد'], 404);
//        }
//
//        $restaurant = Resturant::find($restaurantId);
//        if (!$restaurant) {
//            return response()->json(['message' => 'رستوران پیدا نشد'], 404);
//        }
//        $cartId = Str::uuid();
//        $cartKey = $restaurantId . '_' . $foodId . '_' . $cartId;
//
//        $cart = (array) Redis::hgetall('cart');
//
//        if (array_key_exists($cartKey, $cart)) {
//            $cartItem = json_decode($cart[$cartKey], true);
//            $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] + $quantity : $quantity;
//        } else {
//            $cartItem = [
//                'id' => $cartId,
//                'food' => $foodItem,
//                'quantity' => $quantity,
//            ];
//        }
//
//        $cartItem['cart_id'] = $cartId;
//
//        $cart[$cartKey] = json_encode($cartItem);
//        Redis::hmset('cart', $cart);
//
//        // Calculate the total price of food items in the cart
//        $totalFoodPrice = 0;
//        foreach ($cart as $cartKey => $cartItem) {
//            $cartItem = json_decode($cartItem, true);
//            $foodId = $cartItem['food']['id'];
//            $quantity = $cartItem['quantity'];
//
//            $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
//            if ($foodItem) {
//                $totalFoodPrice += $foodItem->price * $quantity;
//            }
//        }
//
//        // Calculate the shipping price
//        $shippingPrice = $restaurant->ship_price;
//
//        // Update the total price of the order
//        $totalOrderPrice = $totalFoodPrice + $shippingPrice;
//        $userId = auth()->user()->id;
//
//        $order = Order::create([
//            'user_id' => $userId,
//            'total_price' => $totalOrderPrice,
//            'status' => 0,
//            // دیگر فیلدها را اضافه کنید
//        ]);
//
//        // Add order items to the order
//        foreach ($cart as $cartKey => $cartItem) {
//            $cartItem = json_decode($cartItem, true);
//            $foodId = $cartItem['food']['id'];
//            $quantity = $cartItem['quantity'];
//
//            $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
//            if ($foodItem) {
//                $orderItem = new OrderItem([
//                    'food_id' => $foodId,
//                    'count' => $quantity,
//                    'price' => $foodItem->price,
//                ]);
//                $order->items()->save($orderItem);
//            }
//        }
//
//        // Clear the cart after creating the order
//        Redis::del('cart');
//
//        return response()->json(['message' => 'سفارش با موفقیت ایجاد شد'], 200);
//
//    }

    public function addItem(Request $request)
    {
        // Retrieve input data
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity', 1);
        $restaurantId = $request->input('resturant_id');

        // Find food item and restaurant
        $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
        $restaurant = Resturant::find($restaurantId);

        // Check if food item and restaurant exist
        if (!$foodItem) {
            return response()->json(['message' => 'غذا پیدا نشد'], 404);
        }

        if (!$restaurant) {
            return response()->json(['message' => 'رستوران پیدا نشد'], 404);
        }

        // Generate cart key
        $cartId = Str::uuid();
        $cartKey = $restaurantId . '_' . $foodId . '_' . $cartId;

        // Retrieve cart data from Redis
        $cart = (array) Redis::hgetall('cart');

        // Update or add the food item to the cart
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

        // Set cart ID
        $cartItem['cart_id'] = $cartId;

        // Update the cart in Redis
        $cart[$cartKey] = json_encode($cartItem);
        Redis::hmset('cart', $cart);

        // Calculate the total price of food items in the cart
        $totalFoodPrice = $this->calculateTotalFoodPrice($cart, $restaurantId);

        // Calculate the shipping price
        $shippingPrice = $restaurant->ship_price;

        // Update the total price of the order
        $totalOrderPrice = $totalFoodPrice + $shippingPrice;

        // Create a new order
        $userId = auth()->user()->id;
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $totalOrderPrice,
            'resturant_id' => $restaurantId,
            'status' => 0,
            // Add other fields as needed
        ]);

        // Add order items to the order
        $this->addOrderItemsToOrder($cart, $order, $restaurantId);

        // Clear the cart after creating the order
        Redis::del('cart');

        return response()->json(['message' => 'سفارش با موفقیت ایجاد شد'], 200);
    }

    /**
     * Calculate the total price of food items in the cart.
     *
     * @param array $cart
     * @param int $restaurantId
     * @return float
     */
    private function calculateTotalFoodPrice(array $cart, int $restaurantId): float
    {
        $totalFoodPrice = 0;

        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);
            $foodId = $cartItem['food']['id'];
            $quantity = $cartItem['quantity'];

            $foodItem = Food::where('resturant_id', $restaurantId)->find($foodId);
            if ($foodItem) {
                $totalFoodPrice += $foodItem->price * $quantity;
            }
        }

        return $totalFoodPrice;
    }

    /**
     * Add order items to the order.
     *
     * @param array $cart
     * @param Order $order
     * @param int $restaurantId
     * @return void
     */
    private function addOrderItemsToOrder(array $cart, Order $order, int $restaurantId): void
    {
        foreach ($cart as $cartKey => $cartItem) {
            $cartItem = json_decode($cartItem, true);
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
        $cart = (array)Redis::hgetall('cart');
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
        $cart = (array)Redis::hgetall('cart');

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

    public function cancelOrder(Request $request, $orderId)
    {
        $userId = auth()->user()->id;
        $order = Order::where('user_id', $userId)->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'سفارش پیدا نشد'], 404);
        }

        // چک کنید که سفارش قابل لغو است یا خیر (مثلاً در وضعیت "In Review" قابل لغو نیست)
        if ($order->status !== 0) {
            return response()->json(['message' => 'این سفارش قابل لغو نیست'], 400);
        }

        // انجام عملیات لغو
        $order->status = -1; // -1 به معنای لغو شده است
        $order->save();

        return response()->json(['message' => 'سفارش لغو شد'], 200);
    }

    public function confirmOrder(Request $request, $orderId)
    {
        $userId = auth()->user()->id;
        $order = Order::where('user_id', $userId)->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'سفارش پیدا نشد'], 404);
        }

        // چک کنید که سفارش قابل تایید است یا خیر (مثلاً در وضعیت "In Review" قابل تایید است)
        if ($order->status !== 0) {
            return response()->json(['message' => 'این سفارش قابل تایید نیست'], 400);
        }

        // انجام عملیات تایید
        $order->status = 1; // 1 به معنای تایید شده است
        $order->save();

        return response()->json(['message' => 'سفارش تایید شد'], 200);
    }

    // متدهای دیگر بر اساس نیاز اضافه شوند

    public function viewOrders(Request $request)
    {
        $userId = auth()->user()->id;
        $orders = Order::where('user_id', $userId)->with('items')->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function viewOrder(Request $request, $orderId)
    {
        $userId = auth()->user()->id;
        $order = Order::where('user_id', $userId)->with('items')->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'سفارش پیدا نشد'], 404);
        }

        return response()->json(['order' => $order], 200);
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
