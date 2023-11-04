<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $existingUser = User::query()->where('email', $validatedData['email'])->first();
        if ($existingUser) {
            return back()->with('error', 'ایمیل تکراری است!');
        }

        $data = [
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password
        ];

        User::query()->create($data);

        return redirect()->route('seller.dashboard');

    }
    public function showRegister()
    {
        return view('auth.register');
    }
}
