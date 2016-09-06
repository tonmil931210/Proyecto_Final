<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $fillable = [
        'item_id', 'order_id', 'number',
    ];

    protected $guarded = [
        'id'
    ];


    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

}
