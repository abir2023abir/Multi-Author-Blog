<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Events\UserActivity;
use App\Events\AdminStatsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            'spam_comments' => Comment::where('status', 'spam')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'stats'));
    }

    public function show(Comment $comment)
    {
        $comment->load(['user', 'post', 'replies']);
        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'approved_comment', [
            'comment_id' => $comment->id,
            'post_title' => $comment->post->title,
            'commenter_name' => $comment->user->name ?? 'Anonymous'
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($comment)
            ->withProperties(['post_title' => $comment->post->title])
            ->log('approved_comment');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment approved successfully'
        ]);
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'rejected_comment', [
            'comment_id' => $comment->id,
            'post_title' => $comment->post->title,
            'commenter_name' => $comment->user->name ?? 'Anonymous'
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($comment)
            ->withProperties(['post_title' => $comment->post->title])
            ->log('rejected_comment');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment rejected successfully'
        ]);
    }

    public function markAsSpam(Comment $comment)
    {
        $comment->update(['status' => 'spam']);

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'marked_comment_spam', [
            'comment_id' => $comment->id,
            'post_title' => $comment->post->title,
            'commenter_name' => $comment->user->name ?? 'Anonymous'
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($comment)
            ->withProperties(['post_title' => $comment->post->title])
            ->log('marked_comment_spam');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment marked as spam'
        ]);
    }

    public function destroy(Comment $comment)
    {
        $commentId = $comment->id;
        $postTitle = $comment->post->title;
        $commenterName = $comment->user->name ?? 'Anonymous';

        $comment->delete();

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'deleted_comment', [
            'comment_id' => $commentId,
            'post_title' => $postTitle,
            'commenter_name' => $commenterName
        ]));

        $this->dispatchStatsUpdate();

        // Log activity
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['post_title' => $postTitle, 'commenter_name' => $commenterName])
            ->log('deleted_comment');

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,spam,delete',
            'comment_ids' => 'required|array|min:1',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        $comments = Comment::whereIn('id', $request->comment_ids);
        $action = $request->action;

        switch ($action) {
            case 'approve':
                $comments->update(['status' => 'approved']);
                $message = 'Comments approved successfully';
                break;
            case 'reject':
                $comments->update(['status' => 'rejected']);
                $message = 'Comments rejected successfully';
                break;
            case 'spam':
                $comments->update(['status' => 'spam']);
                $message = 'Comments marked as spam successfully';
                break;
            case 'delete':
                $comments->delete();
                $message = 'Comments deleted successfully';
                break;
        }

        // Dispatch real-time events
        event(new UserActivity(Auth::user(), 'bulk_action_comments', [
            'action' => $action,
            'count' => count($request->comment_ids)
        ]));

        $this->dispatchStatsUpdate();

        return redirect()->route('admin.comments.index')->with('success', $message);
    }

    public function getStats()
    {
        $stats = [
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            'rejected_comments' => Comment::where('status', 'rejected')->count(),
            'spam_comments' => Comment::where('status', 'spam')->count(),
            'comments_today' => Comment::whereDate('created_at', today())->count(),
            'comments_this_week' => Comment::where('created_at', '>=', now()->subWeek())->count(),
            'comments_this_month' => Comment::where('created_at', '>=', now()->subMonth())->count(),
        ];

        return response()->json($stats);
    }

    public function getRecentComments()
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => \Str::limit($comment->content, 100),
                    'user' => $comment->user ? [
                        'name' => $comment->user->name,
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name)
                    ] : null,
                    'post' => [
                        'title' => $comment->post->title,
                        'slug' => $comment->post->slug
                    ],
                    'status' => $comment->status,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            });

        return response()->json($comments);
    }

    private function dispatchStatsUpdate()
    {
        $stats = [
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            'spam_comments' => Comment::where('status', 'spam')->count(),
        ];

        event(new AdminStatsUpdated($stats));
    }
}
