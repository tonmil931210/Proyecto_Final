<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'item_type_id', 'price', 'number', 'min_stock', 'reorder', 'number_on_hold', 
    ];

    protected $guarded = [
        'id'
    ];

    public function item_type()
    {
        return $this->belongsTo('App\Item_type');
    }

    public function orders(){
        return $this->belongsToMany('Order', 'Order_item', 'item_id', 'order_id');
    }
}

