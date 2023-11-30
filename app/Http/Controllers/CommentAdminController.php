<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentAdminController extends Controller
{
    public function showDeleteRequests()
    {
        $deleteRequests = Comment::where('delete_request', true)->get();
        return view('admin.comments.delete-requests', compact('deleteRequests'));
    }
    public function approveDeleteRequest($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('admin.comments.delete-requests')->with('success', 'Delete request approved successfully.');
    }
    public function rejectDeleteRequest($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['delete_request' => false]);
        return redirect()->route('admin.comments.delete-requests')->with('success', 'Delete request rejected successfully.');
    }


}
