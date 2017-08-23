<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class DreamComment extends Model
{
    protected $fillable = ['user_id', 'dream_id', 'parent_id', 'body'];

    public $with = ['owner', 'allRepliesWithOwner'];

    public function replies()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function allRepliesWithOwner()
    {
        return $this->replies()->with(__FUNCTION__, 'owner');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dream()
    {
        return $this->belongsTo('App\Models\Dream');
    }
}
