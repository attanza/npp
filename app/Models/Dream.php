<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Models\Media;

class Dream extends Model
{
    protected $fillable = [
        'user_id', 'dream', 'keyword', 'description', 'publish', 'photo'
    ];

    public $with = ['user', 'medias'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }

    public function getPhotoAttribute($value)
    {
        if ($value == null) {
            return asset(Storage::url('public/defaults/default_dream.jpg'));
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset(Storage::url('public/defaults/default_dream.jpg'));
        } else {
            return asset(Storage::url($value));
        }
    }
}
