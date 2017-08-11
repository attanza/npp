<?php

namespace App\Http\Controllers\NppAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use App\Events\Register;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Create User
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $username = str_slug(strtolower($first_name)).'-'.str_slug(strtolower($last_name)).'-'.time();
        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender
        ]);

        // Dispatch after Register event
        event(new Register($user));

        return response()->json([
          'msg' => 'Registrasi berhasil, email aktifasi akun akan dikirim dalam beberapa saat.'
        ], 200);
    }
}
