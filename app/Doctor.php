<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Schedule;

class Doctor extends Model
{
    use Notifiable, HasRoles;
    protected $guarded = ['id'];
    
    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}
