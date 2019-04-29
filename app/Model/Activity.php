<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

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
        'plan_id',
        'project_id',
        'name',
        'essence',
        'target',
        'benefit',
    ];
}
