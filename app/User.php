<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Log;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected $guarded = [
        'id'
    ];

    public function save(array $options = [])
    { 
      $this['password'] = crypt::encrypt($this['password']);
      log::info($this['type']);
      $this['type'] = strtolower($this['type']);
      log::info('entre4');
      parent::save();
      // after save code
    }

    public function tokens()
    {
    return $this->hasMany('App\Token');
    }

    public function events()
    {
    return $this->hasMany('App\Event');
    }
}
