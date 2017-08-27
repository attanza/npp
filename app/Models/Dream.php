<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Models\Media;
use App\Models\DreamComment;

class Dream extends Model
{
    protected $fillable = [
        'user_id', 'dream', 'keyword', 'description', 'publish', 'photo', 'slug'
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
            return asset('images/resource/default_dream.jpg');
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset('images/resource/default_dream.jpg');
        } else {
            return asset(Storage::url($value));
        }
    }

    public function comments()
    {
        return $this->hasMany(DreamComment::class);
    }

    public function parentComments()
    {
        return $this->comments()->where('parent_id', 0);
    }

    public function boosts()
    {
        return $this->morphMany('App\Models\Boost', 'boostable');
    }
}
