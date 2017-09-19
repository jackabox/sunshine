<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    // table
    protected $table = 'product_releases';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
