<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $fillable = [
        'name', 'finish_date', 'start_date', 'start_time', 'finish_time', 'location', 'place'   
    ];

    protected $guarded = [
        'id'
    ];

    public function orders()
    {
        return $this->hasMany('App\Order', 'event_id');
    }
}
