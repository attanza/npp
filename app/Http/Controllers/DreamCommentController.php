<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DreamComment;
use App\Models\Dream;
use App\Http\Requests\CommentStoreRequest;
use App\Jobs\DreamCommentJob;
use Purifier;

class DreamCommentController extends Controller
{
    public function dreamComments($id)
    {
        $comments = DreamComment::where('dream_id', $id)
            ->where('parent_id', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        $response = [
            'pagination' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem()
            ],
            'comments' => $comments
        ];
        return response()->json($response, 200);
    }

    public function store(CommentStoreRequest $request)
    {
        if (isset($request->index)) {
            $index = $request->index;
        } else {
            $index = 'index';
        }
        $comment = DreamComment::create([
            'user_id' => $request->user_id,
            'dream_id' => $request->dream_id,
            'parent_id' => $request->parent_id,
            'body' => clean($request->body),
        ]);
        $data = DreamComment::find($comment->id);
        dispatch(new DreamCommentJob($data, $index));

        return response()->json([
          'comment' => $data
        ], 200);
    }
}
