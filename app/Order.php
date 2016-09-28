<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'event_id', 'order_status_id', 'date', 'commnet', 'name_client'
    ];

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function order_status()
    {
        return $this->belongsTo('App\Order_status');
    }

    public function items(){
        return $this->belongsToMany('Item', 'order_item', 'order_id', 'item_id');
    }
}
