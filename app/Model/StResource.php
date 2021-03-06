<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class StResource extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_resources';

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
        'name',
        'code',
        'status',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
    ];

    // logsActivity
    protected static $logAttributes = [
        'name',
        'code',
        'status',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
    ];
    protected static $logOnlyDirty = true;

    public function manageResource()
    {
        return $this->hasMany('App\Model\ManageResource', 'st_resource_id', 'id');
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

    public function bookingResource()
    {
        return $this->hasMany('App\Model\BookingResource', 'st_resource_id', 'id');
    }
}
