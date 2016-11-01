<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolution extends Model
{
    protected $fillable = [
        'item_id', 'order_id', 'number', 'comment'
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'devolutions';


    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

}
