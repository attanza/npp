<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;
use Auth;
use App\User;

class NotificationController extends Controller
{
    public function getRead($id)
    {
        $not = Notification::find($id);
        if (count($not) == 0) {
            return response()->json([
                'msg' => 'Notifikasi tidak ditemukan'
            ], 422);
        }
        if ($not->read) {
            return response()->json([
                'msg' => 1
            ], 200);
        }
        $not->read = 1;
        $not->read_at = Carbon::now();
        $not->save();
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function index()
    {
        return view('notification.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
            'paginate' => 'required|integer',
            'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->paginate);
        $not_detail = $this->getNotDetail($notifications);
        $response = [
            'pagination' => [
                'total' => $notifications->total(),
                'per_page' => $notifications->perPage(),
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'from' => $notifications->firstItem(),
                'to' => $notifications->lastItem()
            ],
            'notifications' => $not_detail
        ];
        return response()->json($response, 200);
    }

    private function getNotDetail($notifications)
    {
        $data = [];
        foreach ($notifications as $not) {
            $model = $not->notifiable_type::find($not->notifiable_id);
            if ($model) {
                $sender = User::find($model->user_id);
                $modelWith = $this->getModelType($not->notifiable_type, $not->notifiable_id);
                array_push($data, [
                    'id' => $not->id,
                    'avatar' => $sender->profile->photo_path,
                    'msg' => json_decode($not->data)->msg,
                    'created_at' => Carbon::parse($not->created_at)->format('Y-m-d H:i:s'),
                    'type' => $modelWith['type'],
                    'url' => $modelWith['url'],
                    'read' => $not->read
                ]);
            }
        }
        return $data;
    }

    private function getModelType($type, $id)
    {
        $dream = Auth::user()->dream;
        $url = route('dream.show', $dream->slug);

        if ($type == 'App\Models\Boost') {
            $type = "<span class='icon is-small'><i class='fa fa-bolt'></i></span>";
        } elseif ($type == 'App\Models\DreamComment') {
            $type = '<span class="icon is-small"><i class="fa fa-comment"></i></span>';
        }
        return [
            'type' => $type,
            'url' => $url
        ];
    }
}
