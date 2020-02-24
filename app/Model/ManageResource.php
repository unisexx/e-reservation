<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManageResource extends Model
{
    protected $table = 'manage_resources';
    protected $primaryKey = 'id';
    protected $fillable = ['st_resource_id', 'user_id', 'create_by_user_id'];
}
