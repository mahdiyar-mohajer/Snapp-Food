<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
//    public function update(Request $request)
//    {
//        try {
//            $request->validate([
//                'name' => 'required|string',
//                'phone' => 'required|string',
//                'email' => 'required|email',
//            ]);
//
//            Redis::hmset('user', [
//                'name' => $request->name,
//                'phone' => $request->phone,
//                'email' => $request->email,
//            ]);
//
//            return response()->json([
//                'message' => 'Personal information updated successfully',
//            ]);
//        } catch (ValidationException $e) {
//            return response()->json([
//                'message' => 'Validation error',
//                'errors' => $e->errors(),
//            ], 422);
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => 'An error occurred while updating personal information',
//                'error' => $e->getMessage(),
//            ], 500);
//        }
//    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
            ]);

            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'message' => 'یوزر پیدا نشد',
                ], 404);
            }

            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'اطلاعات شخصی با موفقیت به روز شد',
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
