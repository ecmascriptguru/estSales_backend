<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['product_id', 'tracked_by', 'caption', 'status'];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function tracks() {
        return $this->product()->histories;
    }
}
