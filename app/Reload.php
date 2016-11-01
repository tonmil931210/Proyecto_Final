<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reload extends Model
{
    protected $fillable = [
        'item_id', 'number'
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'reloads';


    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
}
