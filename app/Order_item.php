<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $fillable = [
        'item_id', 'order_id', 'number', 'date', 'number_return', 'state'
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'order_items';


    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

}
