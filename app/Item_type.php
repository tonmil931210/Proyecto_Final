<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_type extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id'
    ];

	public function items()
	{
	return $this->hasMany('App\Item', 'item_type_id');
	}

}
