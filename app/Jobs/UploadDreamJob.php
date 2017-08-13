<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use Image;
use App\Models\Dream;
use App\Models\Media;
use App\Traits\GlobalTrait;
use App\Events\UploadDreamEvent;

class UploadDreamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalTrait;

    public $file;
    public $dream;

    public function __construct(Dream $dream, string $file)
    {
        $this->file = $file;
        $this->dream = $dream;
    }

    public function handle()
    {
        $data = $this->file;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $image_data = base64_decode($data);

        $folder = 'app/public/dreams/';
        $mainFileName = str_slug($this->dream->dream).uniqid().'.'.'jpg';

        $this->dream->update([
          'photo' => 'public/dreams/'.$mainFileName
        ]);

        if (!file_exists(storage_path($folder))) {
            mkdir(storage_path($folder), 0755, true);
        }

        $media = Media::where('mediable_id', $this->dream->id)
            ->where('mediable_type', 'App\Models\Dream')->first();
        if (count($media) > 0) {
            $this->deletePhotoIfExists($media->folder, $media->filename);
        }

        $mainImage = Image::make($image_data)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($folder).$mainFileName);

        $this->saveMedia($this->dream->id, 'App\Models\Dream', 'public/dreams/', $mainFileName, $image_data);

        event(new UploadDreamEvent($this->dream->user->username, $this->dream));
    }
}
