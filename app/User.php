<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    // logsActivity
    use LogsActivity;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'idcard', 'st_department_code', 'st_bureau_code', 'st_division_code', 'permission_group_id', 'tel', 'status', 'prefix', 'givename', 'middlename', 'familyname', 'st_prefix_code',
    ];

    // logsActivity
    // column ที่ทำการเก็บ log
    protected static $logAttributes = ['email', 'password', 'idcard', 'st_department_code', 'st_bureau_code', 'st_division_code', 'permission_group_id', 'tel', 'status', 'prefix', 'givename', 'middlename', 'familyname', 'st_prefix_code'];

    // เก็บ log เฉพาะฟิลด์ที่มีการเปลี่ยนแปลง ในกรณีที่มีการแก้ไขข้อมูล
    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // relation
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

    public function permission_group()
    {
        return $this->hasOne('App\Model\PermissionGroup', 'id', 'permission_group_id');
    }

    public function prefix()
    {
        return $this->hasOne('App\Model\StPrefix', 'code', 'st_prefix_code');
    }
}
