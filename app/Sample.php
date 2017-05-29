<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['domain_id', 'bsr', 'est'];

    public function domain() {
        return $this->belongsTo('App\Domain', 'domain_id');
    }
}
