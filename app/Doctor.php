<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = ['id'];
    
    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}
