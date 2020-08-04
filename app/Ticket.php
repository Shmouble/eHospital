<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];
    
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
    
    public function schedules()
    {
        return $this->belongsTo('App\Schedule');
    }
}
