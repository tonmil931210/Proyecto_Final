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
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function order_status()
    {
        return $this->belongsTo('App\Order_status');
    }

    public function items(){
        return $this->belongsToMany('App\Item', 'order_items', 'order_id', 'item_id')->withPivot('number', 'date');;
    }
}
