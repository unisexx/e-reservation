<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

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
    protected $fillable = ['perm_id', 'name', 'display_name'];

    public function permission_roles() {
        return $this->hasMany('App\Model\PermissionRole', 'permission_id', 'id');
    }
}
