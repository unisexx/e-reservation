<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StPositionLevel extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    public function stBoss()
    {
        return $this->hasMany('App\Model\StBoss', 'st_position_level_id', 'id');
    }
}
