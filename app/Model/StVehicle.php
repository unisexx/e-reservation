<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StVehicle extends Model
{
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
}
