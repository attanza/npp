<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Product extends Model
{
    protected $fillable = [
      'code', 'name', 'stock', 'price', 'description', 'photo'
    ];

    public function getPhotoAttribute($value)
    {
        if ($value == null) {
            return asset(Storage::url('public/defaults/product.png'));
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset(Storage::url('public/defaults/product.png'));
        } else {
            return asset(Storage::url($value));
        }
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
