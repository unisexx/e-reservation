<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StBossRes extends Model
{
    protected $fillable = [
        'res_name',
        'res_tel',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'st_boss_id',
    ];
}
