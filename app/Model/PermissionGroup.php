<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// logsActivity
use Spatie\Activitylog\Traits\LogsActivity;

class PermissionGroup extends Model
{
    // logsActivity
    use LogsActivity;
    protected $table = 'permission_groups';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'status'];

    // logsActivity
    protected static $logAttributes = ['title', 'status'];
    protected static $logOnlyDirty = true;

    // relation
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function stUser()
    {
        return $this->hasMany('App\User', 'permission_group_id', 'id');
    }

    public function permissionRole()
    {
        return $this->hasMany('App\Model\PermissionRole');
    }
}
