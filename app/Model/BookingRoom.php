<?php

namespace App\Model;

use App\Model\ManageRoom;

// logsActivity
use Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BookingRoom extends Model
{
    // logsActivity
    use LogsActivity;

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
        'internet_number',
        'request_name',
        'request_position',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'president_name',
        'president_position',
        'approve_by_id',
        'approve_date',
        'use_conference',
        'status_conference',
        'approve_conference_by_id',
        'approve_conference_date',
        'st_province_code',
    ];

    /**
     * Scope
     */
    public function scopeFilterByPermissionView($q)
    {
        /**
         *  ถ้า user ที่ login นี้ ได้ถูกเลือกเป็นผู้จัดการจองห้อง (Manage booking) ใน setting/st-room ให้แสดงเฉพาะการจองของห้องที่ถูกต้องค่าไว้ โดยไม่สนว่าจะเป็น access-self หรือ access-all
         */
        // ส่วนผู้จัดการจองห้อง
        $is_manageroom = ManageRoom::select('st_room_id')->where('user_id', Auth::user()->id)->get()->toArray();
        if ($is_manageroom) {
            return $q->whereIn('st_room_id', $is_manageroom);
        } else { // ส่วนเห็นเฉพาะกลุ่มตัวเอง
            /**
             * เห็นเฉพาะห้องที่อยู่ในกลุ่มของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, ถ้าเป็น default คือเห็นทั้งหมด
             */
            if (CanPerm('access-self')) {
                return $q->whereHas('st_room', function ($s) {
                    $s->where('st_division_code', Auth::user()->st_division_code);
                });
            }
        }

    }

    // relation
    public function department()
    {
        return $this->hasOne('App\Model\StDepartment', 'code', 'st_department_code');
    }

    public function bureau()
    {
        return $this->hasOne('App\Model\StBureau', 'code', 'st_bureau_code');
    }

    public function division()
    {
        return $this->hasOne('App\Model\StDivision', 'code', 'st_division_code');
    }

    public function st_room()
    {
        return $this->hasOne('App\Model\StRoom', 'id', 'st_room_id');
    }

    public function approver()
    {
        return $this->belongsTo('App\User', 'approve_by_id', 'id');
    }

    public function conferenceApprover()
    {
        return $this->belongsTo('App\User', 'approve_conference_by_id', 'id');
    }

    public function getConferenceTxt()
    {
        $data = array(
            0 => 'ไม่ใช้งาน',
            1 => 'ใช้งาน',
        );

        return @$data[$this->use_conference];
    }

    public function getStatusConferenceIcon()
    {
        $status_conference = $this->status_conference == '' ? 'รออนุมัติ' : $this->status_conference;

        $data = array(
            'รออนุมัติ'  => 'vdo-conference-gray.png',
            'อนุมัติ'    => 'vdo-conference2.png',
            'ไม่อนุมัติ' => 'vdo-conference-not.png',
        );

        return @$data[$status_conference];
    }

    // logsActivity
    protected static $logAttributes = [
        'code',
        'st_room_id',
        'title',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'number',
        'internet_number',
        'request_name',
        'request_position',
        'st_department_code',
        'st_bureau_code',
        'st_division_code',
        'request_tel',
        'request_email',
        'note',
        'status',
        'president_name',
        'president_position',
        'approve_by_id',
        'approve_date',
        'use_conference',
        'approve_conference_by_id',
        'approve_conference_date',
        'st_province_code',
    ];
    protected static $logOnlyDirty = true;
}
