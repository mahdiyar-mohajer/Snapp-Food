<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['ایمیل یا پسوردت اشتباهه'],
            ]);
        }
        $token = $user->createToken('userToken')->plainTextToken;
        return [
            'token' => $token,
            'message' => 'به مکتب فود خوش آمدین'
        ];
    }


    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
//            'email_verified_at' => now(),
//            'remember_token' => Str::random(10),
        ]);

        $token = $user->createToken('userToken')->plainTextToken;
        return [
            'token' => $token,
            'message' => 'ثبت نام با موفقیت انجام شد',
        ];
    }


    public function logout(Request $request)
    {
        $request->user()->tokens('userToken')->delete();

        return response()->json([
            'message' => 'شما خارج شدین',
        ]);
    }
}
