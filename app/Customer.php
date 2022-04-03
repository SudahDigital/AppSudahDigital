<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{   
    protected $table = "customers";
 
    protected $fillable = ['store_code','name','email','phone','store_name','city_id','address','payment_term'];

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function cities(){
        return $this->belongsTo('App\City','city_id');
    }

    public function type_cust(){
        return $this->belongsTo('App\TypeCustomer','cust_type');
    }

    public function orders(){
        return $this->hasMany('App\Order','customer_id');
    }

    public function pareto(){
        return $this->belongsTo('App\CatPareto','pareto_id');
    }

    public function store_targets(){
        return $this->hasMany('App\Store_Targets','customer_id');
    }

    public function PointClaim(){
        return $this->hasMany('App\PointClaim','custpoint_id');
    }

    public function spv_sales(){
        return $this->belongsTo('App\Spv_sales','user_id','sls_id');
    }

    public function sales_targets(){
        return $this->belongsTo('App\Sales_Targets','user_id','user_id');
    }

    public function CustomerPrice(){
        return $this->belongsTo('App\CustomerDiscount','pricelist_id');
    }

    public function custPoints(){
        return $this->hasMany('App\CustomerPoint','customer_id');
    }

}
