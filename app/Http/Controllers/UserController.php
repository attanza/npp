<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Profile;
use App\Models\Media;
use App\Models\DreamComment;
use App\Models\Notification;
use Auth;
use Storage;

class UserController extends Controller
{
    public function getUser()
    {
        $user = User::with('profile', 'dream')->find(Auth::id());
        $unreads = $this->getUnreads($user);

        return response()->json([
            'user' => $user,
            'unreads' => $unreads,
        ], 200);
    }

    private function getUnreads($user)
    {
        $unreadData = Notification::where('user_id', Auth::id())
            ->where('read', 0)->orderBy('created_at', 'desc')
            ->get();
        $unreads = [];
        foreach ($unreadData as $not) {
            $msgData = json_decode($not->data);
            $data = [
              'avatar' => $not->user->profile->photo_path,
              'msg' => $msgData->msg
            ];
            array_push($unreads, $data);
        }
        return collect($unreads);
    }
}
