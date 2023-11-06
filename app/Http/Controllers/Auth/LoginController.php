<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

//    public function login(LoginRequest $request)
//    {
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            $user = Auth::user(); // Get the authenticated user
//            if ($user->status === 'inactive') {
//                auth()->logout();
//                return redirect()->route('login')->with('error', 'متاسفانه اکانت شما فعال نیست. با ادمین تماس بگیرید.');
//            }
//            if ($user->hasRole('admin')) {
//                // Redirect admin to the admin route
//                return redirect()->route('admin.dashboard');
//            } elseif ($user->hasRole('seller')) {
//                // Redirect seller to the seller route
//                return redirect()->route('seller.dashboard');
//            }
//            return redirect()->route('seller.dashboard');
//        }
//
//        return back()->with('error', 'ایمیل یا پسووردت اشتباهه!');
//    }
//    protected function authenticated(Request $request, $user)
//    {
//        if ($user->status === 'inactive') {
//            auth()->logout();
//            return redirect()->route('login')->with('error', 'You cannot login because your account is deactivated. Please contact the administrator.');
//        }
//        return redirect()->intended($this->redirectPath());
//    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'inactive') {
                auth()->logout();
                return redirect()->route('login')->with('error', 'متاسفانه اکانت شما فعال نیست. با ادمین تماس بگیرید.');
            }

            $redirectRoute = $this->getRedirectRouteForUser($user);

            if ($redirectRoute) {
                session()->regenerate();
                return redirect()->route($redirectRoute);
            }
        }

        return back()->with('error', 'ایمیل یا پسووردت اشتباهه!');
    }

    private function getRedirectRouteForUser($user)
    {
        if ($user->hasRole('admin')) {
            return 'admin.dashboard';
        } elseif ($user->hasRole('seller')) {
            return 'seller.dashboard';
        }

        // Handle other roles or return a default route if needed
        return null;
    }
    public function logout(Request $request)
    {
        Auth::logout();
        session()->invalidate();
        return redirect(route('show.login'));
    }
}
