<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDiscount extends Model
{
    public function typeCustomer(){
        return $this->belongsTo('App\TypeCustomer','type');
    }

    public function item(){
        return $this->hasMany('App\CustomerDiscProd','cust_disc_id');
    }

    public function getTotalItemAttribute(){
        $total = 0;
        foreach($this->item as $p){
            $total = $total+1;
        }
        return $total;
    }

    public function customers(){
        return $this->hasMany('App\Customer','pricelist_id');
    }
}
