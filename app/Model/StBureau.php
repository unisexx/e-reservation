<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StBureau extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'st_bureaus';

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
    protected $fillable = ['code', 'title'];

    public function stVehicle()
    {
        return $this->hasMany('App\Model\StVehicle', 'st_bureau_code', 'code');
    }
}
