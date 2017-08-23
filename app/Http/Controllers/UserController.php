<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Profile;
use App\Models\Media;
use Auth;
use Storage;
use App\Models\DreamComment;

class UserController extends Controller
{
    public function getUser()
    {
        $user = User::with('profile', 'dream')->find(Auth::id());
        $unreads = $this->getUnreads($user);

        return response()->json([
            'user' => $user,
            'unreads' => $unreads
        ], 200);
    }

    private function getUnreads($user)
    {
        $notifications = [];
        foreach ($user->unreadNotifications as $not) {
            // find comment
            $comment_id = $not->data['comment_id'];
            $comment = DreamComment::find($comment_id);
            // find owner photo
            $avatar = $comment->owner->profile->photo_path;
            // find Dream
            $dreamPhoto = $comment->dream->photo;
            // find owners
            $comment_onwer_id = $comment->owner->id;
            $dream_owner_id = $comment->dream->user->id;
            if ($comment_onwer_id == $dream_owner_id) {
                $msg = 'membalas tanggapan mimpinya';
            } else {
                $msg = 'menanggapi mimpi '.$comment->dream->user->getFullname();
            }
            $data = [
                'avatar' => $avatar,
                'msg' => $msg,
                'dream_photo' => $dreamPhoto,
                'comment_owner' => $comment->owner->getFullname(),
                'dream_owner' => $comment->dream->user->getFullname()
            ];
            array_push($notifications, $data);
        }

        return $notifications;
    }
}
