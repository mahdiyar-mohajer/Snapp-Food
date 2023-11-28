<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::with('image')->get();

        return view('welcome', compact('banners'));
    }
}
