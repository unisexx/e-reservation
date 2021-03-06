<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class StVehicle extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_vehicles';

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
        'st_vehicle_type_id',
        'brand',
        'seat',
        'color',
        'reg_number',
        'st_driver_id',
        'status',
        'image',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'res_name',
        'res_tel',
        'st_province_code',
    ];

    /** Dear Custom Function */
    // เช็กว่ามีฟิลด์อัพโหลดรูป (image) ในฐานข้อมูลมีค่าหรือไม่, ใช่ใน validate
    public function notHavingImageInDb()
    {
        return (empty($this->image)) ? true : false;
        //return true;
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

    public function st_vehicle_type()
    {
        return $this->hasOne('App\Model\StVehicleType', 'id', 'st_vehicle_type_id');
    }

    public function st_driver()
    {
        return $this->hasOne('App\Model\StDriver', 'id', 'st_driver_id');
    }

    public function bookingVehicle()
    {
        return $this->hasMany('App\Model\BookingVehicle', 'st_vehicle_id', 'id');
    }

    public function stProvince()
    {
        return $this->hasOne('App\Model\StProvince', 'code', 'st_province_code');
    }

    // logsActivity
    protected static $logAttributes = [
        'st_vehicle_type_id',
        'brand',
        'seat',
        'color',
        'reg_number',
        'st_driver_id',
        'status',
        'image',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'res_name',
        'res_tel',
    ];
    protected static $logOnlyDirty = true;
}
