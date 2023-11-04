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

    public function toggleStatus(Request $request,$id)
    {
        $user = User::find($id);
        if ($user) {
            // Validate the status value to prevent tampering.
            $validStatuses = ['active', 'inactive'];
            $newStatus = $request->input('status');

            if (in_array($newStatus, $validStatuses)) {
                $user->update(['status' => $newStatus]);
                // Add any additional logic or notifications as needed
                return redirect()->back()->with('success', 'User status updated successfully.');
            }
        }
        return redirect()->back()->with('error', 'User not found.');
    }
}
