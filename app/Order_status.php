<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    protected $fillable = [
        'name',    
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'order_status';

    public function orders()
    {
    return $this->hasMany('App\Order', 'order_status_id');
    }
}
