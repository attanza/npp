<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'order_no', 'name', 'email', 'phone', 'qty', 'lat', 'lng', 'status', 'is_complete',
      'code', 'completed_at', 'address', 'product_id'
    ];

    protected $dates = ['completed_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
