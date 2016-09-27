<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'event_id', 'orderStatus_id', 'date', 'commnet', 'name_client'
    ];

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function order_status()
    {
        return $this->belongsTo('App\Order_status', 'orderStatus_id');
    }

    public function items(){
        return $this->belongsToMany('Item', 'order_item', 'order_id', 'item_id');
    }
}
