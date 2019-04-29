<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    public $timestamps = false;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_roles';

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
    protected $fillable = ['permission_group_id', 'permission_id'];

    
}
