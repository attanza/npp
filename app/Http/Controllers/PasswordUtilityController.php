<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\AfterChangePasswordMail;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class PasswordUtilityController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request, $id)
    {
        $user = User::find($id);
        // return $user->password;
        if (Hash::check($request->input('old_password'), $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            // Send Email
            Mail::to($user)->send(new AfterChangePasswordMail($user));
            return response()->json([
                'msg' => 'Password berhasil diperbaharui'
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Password lama salah'
            ], 422);
        }
    }
}
