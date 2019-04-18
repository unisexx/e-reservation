<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StDriver extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_drivers';

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
        'tel',
        'status',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
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
}
