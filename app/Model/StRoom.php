<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class StRoom extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_rooms';

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
        'name', 'people', 'equipment', 'res_name', 'res_tel', 'fee', 'note', 'status', 'image', 'st_department_code',
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

    // logsActivity
    protected static $logAttributes = [
        'name', 
        'people', 
        'equipment', 
        'res_name', 
        'res_tel', 
        'fee', 
        'note', 
        'status', 
        'image', 
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
    ];
    protected static $logOnlyDirty = true;
}
