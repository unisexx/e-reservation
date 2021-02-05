<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookingBoss extends Model
{
    protected $fillable = [
        'st_boss_id',
        'title',
        'boss_status',
        'room_name',
        'place',
        'owner',
        'tel',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'request_name',
        'request_position',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'approve_by_id',
        'approve_date',
        'self_booking',
        'booking_user_id',
    ];

    public function department()
    {
        return $this->hasOne('App\Model\StDepartment', 'code', 'st_department_code');
    }

    public function bureau()
    {
        return $this->hasOne('App\Model\StBureau', 'code', 'st_bureau_code');
    }

    public function division()
    {
        return $this->hasOne('App\Model\StDivision', 'code', 'st_division_code');
    }

    public function stBoss()
    {
        return $this->hasOne('App\Model\StBoss', 'id', 'st_boss_id');
    }

    public function approver()
    {
        return $this->belongsTo('App\User', 'approve_by_id', 'id');
    }

    public function getBossStatusTxt()
    {
        $data = array(
            1 => 'เป็นประธาน',
            2 => 'เป็นรองประธาน',
            3 => 'เป็นกรรมการ',
            4 => 'เป็นเกียรติ',
        );

        return @$data[$this->boss_status];
    }
}
