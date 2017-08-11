<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'address', 'about', 'lat', 'lng', 'photo_name', 'photo_path', 'location'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getPhotoPathAttribute($value)
    {
        if ($value == null) {
            return asset(Storage::url('public/defaults/male.png'));
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset(Storage::url('public/defaults/male.png'));
        } else {
            return asset(Storage::url($value));
        }
    }
}
