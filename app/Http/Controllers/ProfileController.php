<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Profile;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Auth;
use Session;
use App\Jobs\UploadAvatarJob;

class ProfileController extends Controller
{
    public function show($username)
    {
        if ($username != Auth::user()->username) {
            return redirect('/')->withError('Akses tidak diperkenankan');
        }

        $user = User::with('profile')->where('username', $username)->first();
        if (count($user) == 0) {
            return redirect('/')->withError('User tidak ditemukan');
        }
        Session::flash('success', 'Hallo '.$user->first_name);
        return view('profile.show')->withUser($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        $user = User::with('profile')->find($id);
        Session::flash('success', 'Updated');
        return response()->json([
          'user' => $user
        ], 200);
    }

    public function updateDetail(ProfileUpdateRequest $request, $id)
    {
        $profile = Profile::where('user_id', $id)->first();
        $profile->update($request->all());
        return response()->json([
          'profile' => $profile
        ], 200);
    }

    public function uploadAvatar(Request $request, $id)
    {
        $this->validate($request, [
            'file' => 'required|string'
        ]);
        $profile = Profile::where('user_id', $id)->first();

        $file = $request->input('file');

        $this->dispatch(new UploadAvatarJob($profile, $file));

        return response()->json([
            'profile' => $profile
        ], 200);
    }
}
