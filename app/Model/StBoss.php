<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StBoss extends Model
{
    protected $fillable = [
        'name',
        'position_more',
        'tel',
        'status',
        'st_position_level_id',
        'res_name',
        'res_tel',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'st_boss_position_id',
        'color',
        'abbr',
        'order',
    ];

    public function stBossPosition()
    {
        return $this->belongsTo('App\Model\StBossPosition');
    }

    public function stPositionLevel()
    {
        return $this->belongsTo('App\Model\StPositionLevel');
    }

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

    public function bookingBoss()
    {
        return $this->hasMany('App\Model\BookingBoss', 'st_boss_id', 'id');
    }

    public function stBossRes()
    {
        return $this->hasMany('App\Model\StBossRes');
    }

    // หา user ปัจจบันที่อยู่ใน permission group ที่มีการตั้งค่าเป็นผู้ดูแลผูุ้บริหารอยู่
    public function availableStBossRes()
    {
        return $this->stBossRes()->whereHas('user', function ($q) {
            $q->whereHas('permission_group', function ($r) {
                $r->whereHas('permissionRole', function ($s) {
                    $s->where('permission_id', 93);
                });
            });
        });
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->stBossRes()->delete();
        });
    }
}
