<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::query()->get()->all();
        return view('admin.dashboard', compact('users'));
    }
    public function create()
    {
        return view('admin.create');
    }
}
