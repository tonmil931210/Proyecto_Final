<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'itemType_id', 'price', 'number', 'min_stock', 'reorder',      
    ];

    protected $guarded = [
        'id'
    ];

    public function item_type()
    {
        return $this->belongsTo('App\Item_type', 'itemType_id');
    }

    public function orders(){
        return $this->belongsToMany('Order', 'order_item', 'item_id', 'order_id');
    }
}

