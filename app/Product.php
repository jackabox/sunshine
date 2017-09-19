<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // table
    protected $table = 'products';

    public function releases()
    {
        return $this->hasMany('App\Release');
    }

}
