<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name'];

    public function initialSamples() {
        return $this->hasMany('App\InitialSample', 'domain_id');
    }

    public function samples() {
        return $this->hasMany('App\Sample', 'domain_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'domain_id');
    }
}
