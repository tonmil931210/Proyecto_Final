<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumer_order extends Model
{
    protected $fillable = [
        'order_id',
    ];

    protected $guarded = [
        'id'
    ];


    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
