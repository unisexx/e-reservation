<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class BookingResource extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_resources';

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
        'st_resource_id',
        'code',
        'title',
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

    public function stResource()
    {
        return $this->hasOne('App\Model\StResource', 'id', 'st_resource_id');
    }

    public function approver()
    {
        return $this->belongsTo('App\User', 'approve_by_id', 'id');
    }

    // logsActivity
    protected static $logAttributes = [
        'st_resource_id',
        'code',
        'title',
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
    ];
    protected static $logOnlyDirty = true;
}
