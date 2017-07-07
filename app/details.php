<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class details extends Model
{
    protected $fillable = array('name', 'email');

    public function profile(){
      return $this->hasOne('profile');
    }
}
