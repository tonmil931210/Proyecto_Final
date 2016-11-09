<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Historic extends Model
{
    protected $fillable = [
        'name_item', 'item_id', 'type', 'number', 
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'historic';

}
