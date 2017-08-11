<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use Image;
use App\Models\Profile;
use Auth;
use App\Events\AvatarUploaded;
use App\User;

class UploadAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;
    public $profile;

    public function __construct(Profile $profile, string $file)
    {
        $this->file = $file;
        $this->profile = $profile;
    }

    public function handle()
    {
        $data = $this->file;
        $profile = $this->profile;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $image_data = base64_decode($data);

        $folder = 'app/public/avatars/';
        $mainFileName = uniqid().'.'.'jpg';

        if (!file_exists(storage_path($folder))) {
            mkdir(storage_path($folder), 0755, true);
        }

        $mainImage = Image::make($image_data)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($folder).$mainFileName);

        $profile->photo_path = 'public/avatars/'.$mainFileName;
        $profile->photo_name = $mainFileName;
        $profile->save();

        $user = User::find($profile->user_id);
        event(new AvatarUploaded($user->username, $profile->photo_path));
    }
}
