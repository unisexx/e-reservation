<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_rooms';

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
    protected $fillable = [
        'code',
        'st_room_id',
        'title',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'number',
        'request_name',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
    ];
}
