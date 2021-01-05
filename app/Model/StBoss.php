<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StBoss extends Model
{
    protected $fillable = [
        'name',
        'position',
        'tel',
        'status',
        'level',
    ];
}
