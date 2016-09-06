<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retornable_order extends Model
{
    protected $fillable = [
        'order_id', 'date',
    ];

    protected $guarded = [
        'id'
    ];


    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
