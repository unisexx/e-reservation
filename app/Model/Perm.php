<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Perm extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'perms';

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
    protected $fillable = ['parent_id', 'name', 'order'];

    public function childs()
    {
        return $this->belongsTo('App\Model\Perm', 'id', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne('App\Model\Perm', 'id', 'parent_id');
    }

    public function permissions()
    {
        return $this->belongsTo('App\Model\Permission', 'id', 'perm_id');
    }
}
