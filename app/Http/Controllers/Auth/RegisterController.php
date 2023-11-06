<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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

        $user = User::query()->create($data);

        $sellerRole = Role::query()->where('name', 'seller')->first();
        if ($sellerRole) {
            $user->assignRole($sellerRole);
        }

        return redirect()->route('seller.dashboard');

    }
    public function showRegister()
    {
        return view('auth.register');
    }
}
