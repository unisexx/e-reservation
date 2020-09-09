<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class BookingVehicle extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_vehicles';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'gofor',
        'number',
        'request_date',
        'request_time',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'point_place',
        'point_time',
        'destination',
        'request_name',
        'request_position',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'st_vehicle_id',
        'req_st_department_code',
        'req_st_bureau_code',
        'req_st_division_code',
        'st_driver_id',
        'approve_by_id',
        'approve_date',
    ];

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

    public function st_vehicle()
    {
        return $this->hasOne('App\Model\StVehicle', 'id', 'st_vehicle_id');
    }

    public function departmentVehicle()
    {
        return $this->hasOne('App\Model\StDepartment', 'code', 'req_st_department_code');
    }

    public function bureauVehicle()
    {
        return $this->hasOne('App\Model\StBureau', 'code', 'req_st_bureau_code');
    }

    public function divisionVehicle()
    {
        return $this->hasOne('App\Model\StDivision', 'code', 'req_st_division_code');
    }

    public function st_driver()
    {
        return $this->belongsto('App\Model\StDriver', 'st_driver_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo('App\User', 'approve_by_id', 'id');
    }

    // logsActivity
    protected static $logAttributes = [
        'code',
        'gofor',
        'number',
        'request_date',
        'request_time',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'point_place',
        'point_time',
        'destination',
        'request_name',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'st_vehicle_id',
        'st_driver_id',
        'approve_by_id',
        'approve_date',
    ];
    protected static $logOnlyDirty = true;
}
