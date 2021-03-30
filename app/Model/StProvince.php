<?php

namespace App\Model;

use Auth;
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

    public function scopeFilterByUserBureauProvince($q)
    {
        if (Auth::user()->bureau->st_province_code != 10 && Auth::user()->bureau->st_province_code != "") {
            return $q->where('code', Auth::user()->bureau->st_province_code);
        }
    }
}
