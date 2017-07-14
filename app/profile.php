<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class profile extends Model
{
    protected $fillable = array('DOB');
    protected $appends = array('age');

    public function details(){
      return $this->belongsTo('User');
    }

    public function getAgeAttribute() {
     return Carbon::parse($this->attributes['DOB'])->age;
}

}
