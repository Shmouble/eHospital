<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Schedule;

class Doctor extends Model
{
    protected $guarded = ['id'];
    
    public function schedules()
    {
        return $this->hasMany('Schedule');
    }
}
