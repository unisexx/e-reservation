<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManageRoom extends Model
{
    protected $table      = 'manage_rooms';
    protected $primaryKey = 'id';
    protected $fillable   = ['st_room_id', 'user_id', 'create_by_user_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
