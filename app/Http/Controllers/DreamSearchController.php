<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;

class DreamSearchController extends Controller
{
    protected $select = [
      'users.first_name', 'users.last_name', 'dreams.dream', 'dreams.keyword',
      'dreams.slug', 'profiles.photo_path', 'users.created_at', 'users.email'
    ];

    public function search(Request $request)
    {
        $this->validate($request, [
          'query' => 'required|max:100'
        ]);
        $querySearch = e($request->input('query'));
        $users = DB::table('users')
          ->select($this->select)
          ->join('dreams', 'users.id', '=', 'dreams.user_id')
          ->join('profiles', 'users.id', '=', 'profiles.user_id')
          ->where('users.is_active', 1)
          ->where('users.first_name', 'LIKE', "%$querySearch%")
          ->orWhere('users.email', 'LIKE', "%$querySearch%")
          ->orWhere('users.last_name', 'LIKE', "%$querySearch%")
          ->orWhere('dreams.dream', 'LIKE', "%$querySearch%")
          ->orWhere('dreams.keyword', 'LIKE', "%$querySearch%")
          ->get();

        $data = $this->prepareUsers($users);
        if ($request->ajax()) {
            return response()->json([
              'users' => $data
            ], 200);
        }
    }

    private function prepareUsers($users)
    {
        $data = [];
        foreach ($users as $user) {
            $avatar = $this->getAvatar($user->photo_path);
            array_push($data, [
              'name' => $user->first_name.' '.$user->last_name,
              'avatar' => $avatar,
              'created_at' => $user->created_at,
              'dream' => $user->dream,
              'email' => $user->email,
              'slug' => $user->slug
            ]);
        }
        return collect($data)->unique();
    }

    private function getAvatar($value)
    {
        if ($value == null) {
            return asset(Storage::url('public/defaults/male.png'));
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset(Storage::url('public/defaults/male.png'));
        } else {
            return asset(Storage::url($value));
        }
    }
}
