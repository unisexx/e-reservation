<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class StVehicleType extends Model
{
    // logsActivity
    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_vehicle_types';

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
    protected $fillable = ['name','status'];

    // logsActivity
    protected static $logAttributes = ['name','status'];
    protected static $logOnlyDirty = true;
}
