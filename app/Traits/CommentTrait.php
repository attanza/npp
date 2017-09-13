<?php
namespace App\Traits;

use App\Models\DreamComment;
use Carbon\Carbon;
use Purifier;

trait CommentTrait
{
    public function prepareComments($comments)
    {
        $commentsData = [];
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $parent = $this->getArrayData($comment);
                // $parent = $this->getArrayData($comment);
                $children = DreamComment::where('parent_id', $comment->id)
                  ->orderBy('created_at', 'desc')->limit(2)->get();
                if (count($children)>0) {
                    foreach ($children as $comment) {
                        $data = $this->getArrayData($comment);
                        array_unshift($parent['replies'], $data);
                    }
                }
                array_push($commentsData, $parent);
            }
        }
        return collect($commentsData);
    }

    public function getArrayData($comment)
    {
        return [
          'avatar' => $comment->owner->profile->photo_path,
          'body' => $comment->body,
          'id' => $comment->id,
          'name' => $comment->owner->first_name.' '.$comment->owner->last_name,
          'created_at' => Carbon::parse($comment->created_at)->format('Y-m-d H:i:s'),
          'replies' => [],
          'parent_id' => $comment->parent_id,
          'owner_id' => $comment->owner->id
        ];
    }

    public function getPaginateOutput($model, $data)
    {
        $response = [
            'pagination' => [
                'total' => $model->total(),
                'per_page' => $model->perPage(),
                'current_page' => $model->currentPage(),
                'last_page' => $model->lastPage(),
                'from' => $model->firstItem(),
                'to' => $model->lastItem()
            ],
            'data' => $data
        ];
        return $response;
    }
}
