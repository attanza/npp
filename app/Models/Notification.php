<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
      'user_id', 'notifiable_id', 'notifiable_type', 'data', 'read', 'read_at'
    ];

    protected $dates = ['read_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
