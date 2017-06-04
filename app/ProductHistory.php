<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $fillable = ['product_id', 'pages', 'bsr', 'currency', 'price', 'est', 'monthly_rev', 'reviews'];

    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
