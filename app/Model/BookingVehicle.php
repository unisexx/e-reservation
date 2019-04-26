<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookingVehicle extends Model
{
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
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'st_vehicle_id',
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

    public function st_vehicle(){
        return $this->hasOne('App\Model\StVehicle', 'id', 'st_vehicle_id');
    }
}
