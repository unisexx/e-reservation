<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StVehicleType extends Model
{
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
}
