<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'domain_id', 'title', 'price', 'asin', 'isbn'];

    public function category() {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    public function histories() {
        return $this->hasMany('App\ProductHistory', 'product_id');
    }

    public function items() {
        return $this->hasMany('App\Item', 'product_id');
    }
}
