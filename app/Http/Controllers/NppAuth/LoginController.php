<?php

namespace App\Http\Controllers\NppAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
        // Validate User Data
        $this->validateLogin($request);
        // Find user by email
        $user = User::where('email', $request->email)->first();
        if (count($user) == 0) {
            return response()->json([
                'msg' => 'User tidak ditemukan'
            ], 422);
        }

        if (!$user->is_active) {
            return response()->json([
                'msg' => 'not activated'
            ], 201);
        }

        $remember = false;
        if ($request->has('remember')) {
            $remember = $request->remember;
        }
        if (Auth::attempt([
              'email' => $request->email, 'password' => $request->password, 'is_active' => 1
            ], $remember)) {
                $user = User::where('email', $request->email)->first();
                $user->last_login = Carbon::now();
                $user->save();
            if ($request->ajax()) {
                return response()->json(1, 200);
            }
        }
    }

    private function validateLogin($request)
    {
        $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required'
        ]);
    }
}
