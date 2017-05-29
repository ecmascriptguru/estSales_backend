<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $fillable = ['product_id', 'bsr', 'currency', 'price', 'est'];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
