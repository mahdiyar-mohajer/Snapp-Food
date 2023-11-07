<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
//        $users = User::query()->get()->all();
        $users = User::query()->paginate(5);
        return view('admin.dashboard', compact('users'));
    }
    public function create()
    {
        return view('admin.create');
    }

//    public function toggleStatus(Request $request,$id)
//    {
//        $user = User::find($id);
//        if ($user) {
//            // Validate the status value to prevent tampering.
//            $validStatuses = ['active', 'inactive'];
//            $newStatus = $request->input('status');
//
//            if (in_array($newStatus, $validStatuses)) {
//                $user->update(['status' => $newStatus]);
//                // Add any additional logic or notifications as needed
//                return redirect()->back()->with('success', 'User status updated successfully.');
//            }
//        }
//        return redirect()->back()->with('error', 'User not found.');
//    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::find($id);

        // Check if the user exists
        if ($user) {
            $validStatuses = ['active', 'inactive'];
            $newStatus = $request->input('status');

            // Check if the user email is not 'mahdiyar@gmail.com' and the new status is valid
            if ($user->email !== 'mahdiyar@gmail.com' && in_array($newStatus, $validStatuses)) {
                $user->update(['status' => $newStatus]);
                // Add any additional logic or notifications as needed
                return redirect()->back()->with('success', 'User status updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Permission denied to change the status.');
            }
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function promoteToAdmin(Request $request,$id)
    {
        $user = User::query()->find($id);
// Find the "admin" role
        $adminRole = Role::where('name', 'admin')->first();
// Check if the role and user exist
        if ($adminRole && $user) {
            $user->assignRole($adminRole);
            return redirect()->back()->with('success', 'User promoted to admin successfully.');
        } else {
            return redirect()->back()->with('error', 'User or role not found.');
        }
    }
}
