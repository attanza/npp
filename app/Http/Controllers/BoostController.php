<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dream;
use App\Models\Boost;
use Auth;
use App\Jobs\BoostJob;
use App\User;
use DB;
use Storage;

class BoostController extends Controller
{
    public function getBoosts($id)
    {
        $users = DB::table('users')
            ->select('users.first_name', 'users.last_name', 'profiles.photo_path', 'boosts.created_at', 'dreams.slug')
            ->where('boosts.boostable_id', $id)
            ->where('boosts.boostable_type', 'App\Models\Dream')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('boosts', 'users.id', '=', 'boosts.user_id')
            ->join('dreams', 'users.id', '=', 'dreams.user_id')
            ->paginate(10);

        $boostIds = Boost::where('boostable_id', $id)
        ->where('boostable_type', 'App\Models\Dream')
        ->get()->pluck('user_id')->toArray();

        // chek if auth id already boost
        $authId = Auth::id();

        if (in_array($authId, $boostIds)) {
            $is_booster = true;
        } else {
            $is_booster = false;
        }
        return response()->json([
          'boosterData' => $this->prepareUsers($users),
          'is_booster' => $is_booster,
          'boost_count' => count($boostIds)
        ], 200);
    }

    public function giveBoost($id)
    {
        $dream = Dream::find($id);
        $dream->boosts()->create([
          'user_id' => Auth::id()
        ]);
        $booster = [
          'name' => Auth::user()->getFullname(),
          'avatar' => Auth::user()->profile->photo_path
        ];
        $this->dispatchJob($dream);
        return response()->json([
          'booster' => $booster
        ], 200);
    }

    public function listing(Request $request, $id)
    {
        $this->validate($request, [
          'query' => 'max:50'
        ]);

        $name = e($request->input('query'));
        if ($name != '') {
            // return $name;
            $users = DB::table('users')
              ->select('users.first_name', 'users.last_name', 'profiles.photo_path', 'boosts.created_at', 'dreams.slug')
              ->where('users.first_name', 'LIKE', "%$name%")
              ->orWhere('users.last_name', 'LIKE', "%$name%")
              ->where('boostable_id', $id)
              ->where('boostable_type', 'App\Models\Dream')
              ->join('profiles', 'users.id', '=', 'profiles.user_id')
              ->join('boosts', 'users.id', '=', 'boosts.user_id')
              ->join('dreams', 'users.id', '=', 'dreams.user_id')
              ->paginate(10);
        } else {
            $users = DB::table('users')
              ->select('users.first_name', 'users.last_name', 'profiles.photo_path', 'boosts.created_at', 'dreams.slug')
              ->where('boosts.boostable_id', $id)
              ->where('boosts.boostable_type', 'App\Models\Dream')
              ->join('profiles', 'users.id', '=', 'profiles.user_id')
              ->join('boosts', 'users.id', '=', 'boosts.user_id')
              ->join('dreams', 'users.id', '=', 'dreams.user_id')
              ->paginate(10);
        }

        $response = [
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'users' => $this->prepareUsers($users)
        ];
        return response()->json($response, 200);
    }

    private function dispatchJob($dream)
    {
        if ($dream->user->id != Auth::id()) {
            dispatch(new BoostJob($dream, Auth::id()));
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
              'dream_slug' => $user->slug
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
