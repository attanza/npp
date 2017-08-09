<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'address', 'about', 'lat', 'lng', 'photo_name', 'photo_path'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
