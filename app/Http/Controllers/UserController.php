<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Notification;
use App\Models\Dream;
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
            ->limit(10)->get();
        $unreads = [];
        foreach ($unreadData as $not) {
            // find respective model data from notifiable_type and notifiable_id
            $data = $this->getDataFromModel($not);
            $msgData = json_decode($not->data);
            $with = [
              'avatar' => $data['avatar'],
              'url' => $data['url'],
              'msg' => $msgData->msg,
              'id' => $not->id
            ];
            array_push($unreads, $with);
        }
        return collect($unreads);
    }

    private function getDataFromModel($array)
    {
        $modelType = $array->notifiable_type;
        $id = $array->notifiable_id;
        $avatar = '';
        $url = '';
        if ($modelType == 'App\Models\Boost') {
            $model = \App\Models\Boost::find($id);
            if (count($model) == 1) {
                $avatar = $model->user->profile->photo_path;
                $dream = Dream::find($model->boostable_id);
                $url = route('dream.show', $dream->slug);
            }
        } elseif ($modelType == 'App\Models\DreamComment') {
            $model = \App\Models\DreamComment::find($id);
            if (count($model) == 1) {
                $avatar = $model->owner->profile->photo_path;
                $url = route('dream.show', $model->dream->slug);
            }
        }
        return [
          'avatar' => $avatar,
          'url' => $url
        ];
    }
}
