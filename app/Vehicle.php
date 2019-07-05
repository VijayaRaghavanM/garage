<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * Eloquent Reverse relationship between Order and User
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
