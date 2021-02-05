<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StProvince extends Model
{
    protected $table = 'st_provinces';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'name',
        'status',
    ];
}
