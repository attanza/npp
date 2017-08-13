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
use App\Models\Media;
use Auth;
use App\Events\AvatarUploaded;
use App\User;
use App\Traits\GlobalTrait;

class UploadAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalTrait;

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

        $media = Media::where('mediable_id', $profile->id)
            ->where('mediable_type', 'App\Models\Profile')->first();
        if (count($media) > 0) {
            $this->deletePhotoIfExists($media->folder, $media->filename);
        }

        $mainImage = Image::make($image_data)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($folder).$mainFileName);

        $profile->photo_path = 'public/avatars/'.$mainFileName;
        $profile->photo_name = $mainFileName;
        $profile->save();

        $this->saveMedia($profile->id, 'App\Models\Profile', 'public/avatars/', $mainFileName, $image_data);

        $user = User::find($profile->user_id);
        event(new AvatarUploaded($user->username, $profile->photo_path));
    }
}
