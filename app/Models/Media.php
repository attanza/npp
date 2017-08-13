<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Media extends Model
{
    protected $fillable = [
      'mediable_id', 'mediable_type', 'folder', 'filename', 'mime', 'size','extension', 'caption'
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getPhotoPath()
    {
        $photo_path = $this->folder.$this->filename;
        if (!Storage::disk('local')->exists($photo_path)) {
            return asset('images/resource/default_dream.jpg');
        } else {
            asset(Storage::url($photo_path));
        }
    }
}
