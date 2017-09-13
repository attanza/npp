<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentStoreRequest;
use App\Models\DreamComment;
use App\Traits\CommentTrait;

class ChildCommentController extends Controller
{
    use CommentTrait;

    public function getChildComments(Request $request, $parentId)
    {
        $comments = DreamComment::where('parent_id', $parentId)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $data = $this->prepareComments($comments);
        $response = $this->getPaginateOutput($comments, $data);
        return response()->json($response, 206);
    }

    public function saveComment(CommentStoreRequest $request)
    {
        $comment = new DreamComment;
        $comment->user_id = $request->input('user_id');
        $comment->dream_id = $request->input('dream_id');
        $comment->parent_id = $request->input('parent_id');
        $comment->body = clean($request->input('body'));
        $comment->save();
        $comments = []; // to adapting the prepareComments function which requires array
        array_push($comments, DreamComment::find($comment->id));
        $data = $this->prepareComments($comments);
        return response()->json([
          'comment' => $data[0]
        ], 200);
    }
}
