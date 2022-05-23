<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodNumber extends Model
{
    public function orders(){
        return $this->belongsTo('App\Order','order_id');
    }

    public function partialDelivery()
    {
    	return $this->belongsTo('App\PartialDelivery','partial_id');
    }
}
