<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StDepartment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_departments';

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
    protected $fillable = ['code','title'];
}
