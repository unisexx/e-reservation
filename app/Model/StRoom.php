<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StRoom extends Model
{
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
    protected $fillable = ['name','people','equipment','res_name','res_tel','res_department_id','fee','note','status'];
}