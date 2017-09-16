<?php

namespace App\Http\Controllers\NppAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Activation;
use Carbon\Carbon;
use Session;
use Mail;
use App\Mail\ActivationCodeMail;

class ActivationController extends Controller
{
    public function activate($email, $code)
    {
        // find User
        $user = User::where('email', $email)->first();
        if (count($user) == 0) {
            Session::flash('error', 'User tidak ditemukan');
            return redirect('/');
        }
        // Matching Activation Code
        $activation = Activation::where('user_id', $user->id)
            ->where('code', $code)->first();
        if (count($activation) == 0) {
            Session::flash('error', 'Kode tidak valid');
            return redirect('/');
        }
        // check if Activated
        if ($user->is_active) {
            Session::flash('success', 'Akun anda telah diaktifkan, silahkan login.');
            return redirect('/');
        }
        // activate User
        $activation->update([
            'completed' => 1,
            'completed_at' => Carbon::now()
        ]);
        $user->update([
            'is_active' => 1
        ]);
        // return
        Session::flash('success', 'Akun anda telah diaktifkan, silahkan login.');
        return redirect('/');
    }

    public function resendActivation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Find User
        $user = User::with('activation')->where('email', $request->email)->first();
        if (count($user) == 0) {
            return response()->json([
              'msg' => 'User tidak ditemukan '
            ], 422);
        }

        // chek Activation
        $this->chekActivation($user);

        // Send Activation Mail
        Mail::to($user)->send(new ActivationCodeMail($user));
        return response()->json([
          'msg' => 'Email akan dikirmkan dalam beberapa saat'
        ], 200);
    }

    private function chekActivation($user)
    {
        $activation = Activation::where('user_id', $user->id)->first();
        if (count($activation) == 0) {
            Activation::create([
              'user_id' => $user->id,
              'code' => str_random(60)
            ]);
        }
    }
}
