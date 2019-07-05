<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    /**
     * Eloquent Reverse relationship between Order and Client
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }    


    /**
     * Eloquent Reverse relationship between Order and User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Eloquent Relationship between Order and Vehicle
     */
    public function vehicle()
    {
        return $this->hasOne('App\Vehicle');
    }
}
