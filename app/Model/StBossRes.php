<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StBossRes extends Model
{
    protected $fillable = [
        'st_boss_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
