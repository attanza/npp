<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Profile;
use Auth;

class UserController extends Controller
{
    public function getUser()
    {
        $user = User::find(Auth::id());
        $profile = Profile::where('user_id', Auth::id())->first();
        return response()->json([
          'user' => $user,
          'profile' => $profile,
        ], 200);
    }
}
