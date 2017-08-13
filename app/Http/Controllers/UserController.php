<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Profile;
use App\Models\Media;
use Auth;
use Storage;

class UserController extends Controller
{
    public function getUser()
    {
        $user = User::with('profile', 'dream')->find(Auth::id());

        return response()->json([
            'user' => $user
        ], 200);
    }
}
