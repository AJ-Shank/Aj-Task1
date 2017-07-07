<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $fillable = array('age', 'DOB');

    public function details(){
      return $this->belongsTo('details');
    }
}
