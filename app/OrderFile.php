<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{   
    protected $table = "order_files";

    protected $fillable = [
        'order_id', 
        'order_file', 
    ];

    public function orders(){
        return $this->belongsTo('App\Order','order_id');
    }
}
