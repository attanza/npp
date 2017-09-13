<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentStoreRequest;
use App\Models\DreamComment;
use App\Traits\CommentTrait;
use App\Jobs\DreamCommentJob;
use Auth;

class ParentCommentController extends Controller
{
    use CommentTrait;

    public function getParentComments(Request $request, $dreamId)
    {
        $comments = DreamComment::where('parent_id', 0)
            ->where('dream_id', $dreamId)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        $data = $this->prepareComments($comments);
        $response = $this->getPaginateOutput($comments, $data);
        return response()->json($response, 206);
    }

    public function saveComment(CommentStoreRequest $request)
    {
        $comment = new DreamComment;
        $this->saveToDb($comment, $request);
        $comments = []; // to adapting the prepareComments function which requires array
        array_push($comments, DreamComment::find($comment->id));
        $data = $this->prepareComments($comments);
        dispatch(new DreamCommentJob($comments[0]));
        return response()->json([
            'comment' => $data[0]
        ], 201);
    }

    public function updateComment(CommentStoreRequest $request, $id)
    {
        $comment = DreamComment::find($id);
        if ($this->checkIfOwner($comment)) {
            $this->saveToDb($comment, $request);
            $comments = []; // to adapting the prepareComments function which requires array
            array_push($comments, DreamComment::find($comment->id));
            $data = $this->prepareComments($comments);
            return response()->json([
                'comment' => $data[0]
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Akses tidak diperkenankan'
            ], 403);
        }
    }

    public function destroy($id)
    {
        $comment = DreamComment::find($id);
        if (count($comment) == 0) {
            return response()->json([
                'msg' => 'Tanggapan tidak ditemukan'
            ], 400);
        }
        if ($comment->dream->user->id == Auth::id() || $comment->owner->id == Auth::id()) {
            $parent_id = $comment->parent_id;
            // if the comment to delete is a parent comment then delete children
            if ($parent_id == 0) {
                $this->deleteAllChild($comment->id);
            }
            $comment->delete();
            return response()->json(['msg' => 'deleted'], 200);
        } else {
            return response()->json([
                'msg' => 'Akses tidak diperkenankan'
            ], 403);
        }
    }

    private function saveToDb($comment, $request)
    {
        $comment->user_id = $request->input('user_id');
        $comment->dream_id = $request->input('dream_id');
        $comment->parent_id = $request->input('parent_id');
        $comment->body = clean($request->input('body'));
        $comment->save();
        return $comment;
    }

    private function deleteAllChild($parent_id)
    {
        $children = DreamComment::where('parent_id', $parent_id)->get();
        if (count($children) > 0) {
            foreach ($children as $comment) {
                $comment->delete();
            }
        }
    }

    public function checkIfOwner($comment)
    {
        if ($comment->owner->id == Auth::id()) {
            return true;
        }
        return false;
    }
}
