<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $comments = Comment::with(['food', 'order.orderItems.food'])
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedComments = $this->groupCommentsByRestaurant($comments);

        return view('admin.comments.index', compact('groupedComments'));
    }

    protected function groupCommentsByRestaurant($comments)
    {
        $groupedComments = [];

        foreach ($comments as $comment) {
            $restaurantName = $this->getRestaurantName($comment);

            if (!isset($groupedComments[$restaurantName])) {
                $groupedComments[$restaurantName] = [];
            }

            $groupedComments[$restaurantName][] = $comment;

            foreach ($comment->replies as $reply) {
                $groupedComments[$restaurantName][] = $reply;
            }
        }

        return $groupedComments;
    }

    protected function getRestaurantName($comment)
    {
        if ($comment->order && $comment->order->resturant) {
            return $comment->order->resturant->name;
        } elseif ($comment->food && $comment->food->resturant) {
            return $comment->food->resturant->name;
        } elseif ($comment->resturant) {
            return $comment->resturant->name;
        }

        // اگر نام رستوران مشخص نشده باشد، مقدار پیش‌فرض را برگردانید
//        return 'Default Restaurant Name';
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $comment->update([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully');
    }


}
