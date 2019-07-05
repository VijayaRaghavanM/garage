<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{


    /**
     * Eloquent Relationship between Client and Order
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }


    /**
     * Eloquent Reverse relationship between Client and User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    } 
}
