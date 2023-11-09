<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController
{
    public function index()
    {
        $addresses = Address::all();

        return response()->json([
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'address' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            // Assuming you have a User model and a relationship between User and Address models
            $user = auth()->user(); // Get the authenticated user

            $address = new Address([
                'title' => $request->title,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            $user->addresses()->save($address);

            return response()->json([
                'message' => 'آدرس با موفقیت ثبت شد',
                'address' => $address,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'خطای اعتبار سنجی',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'یک خطایی رخ داد دوباره تلاش کن',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function setCurrent(Request $request)
    {
        try {
            $request->validate([
                'address' => 'required|string',
            ]);

            $address = Address::where('address', $request->address)->first();

            if (!$address) {
                return response()->json([
                    'message' => 'آدرس پیدا نشد',
                ], 404);
            }

            $user = auth()->user();
            $address->user_id = $user->id;
            $address->save();

            return response()->json([
                'message' => 'آدرس فعلی با موفقیت اضافه شد',
                'address' => $address,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'خطای اعتبار سنجی',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'یک خطایی رخ داد دوباره تلاش کن',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
