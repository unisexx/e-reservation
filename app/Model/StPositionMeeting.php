<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StPositionMeeting extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    public function bookingBoss()
    {
        return $this->hasMany('App\Model\BookingBoss', 'boss_status', 'id');
    }
}
