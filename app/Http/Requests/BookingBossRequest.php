<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingBossRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'st_position_level_id' => 'sometimes|required',
            'st_boss_id'           => 'required',
            'title'                => 'required',
            'boss_status'          => 'required',
            'room_name'            => 'required',
            'place'                => 'required',
            'owner'                => 'required',
            'start_date'           => 'required',
            'start_time'           => 'required',
            'end_date'             => 'required',
            'end_time'             => 'required',
            'request_name'         => 'required',
            'request_position'     => 'required',
            'request_tel'          => 'required',
            'request_email'        => 'required|email',
            'st_department_code'   => 'required',
            'st_bureau_code'       => 'required',
            'st_division_code'     => 'required',
            'captcha'              => 'sometimes|required|captcha',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'st_position_level_id.required' => 'ระดับตำแหน่งผู้บริหาร ห้ามเป็นค่าว่า่ง',
            'st_boss_id.required'           => 'เลือกผู้บริหาร ห้ามเป็นค่าว่าง',
            'title.required'                => 'ชื่อเรื่อง / หัวข้อการประชุม ห้ามเป็นค่าว่าง',
            'boss_status.required'          => 'สถานะผู้บริหาร ห้ามเป็นค่าว่าง',
            'room_name.required'            => 'ชื่อห้องประชุม ห้ามเป็นค่าว่าง',
            'place.required'                => 'สถานที่ ห้ามเป็นค่าว่าง',
            'owner.required'                => 'ชื่อเจ้าของงาน ห้ามเป็นค่าว่าง',
            'start_date.required'           => 'วันที่เริ่มใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'start_time.required'           => 'เวลาที่เริ่มใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'end_date.required'             => 'วันที่สิ้นสุดใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'end_time.required'             => 'เวลาที่สิ้นสุดใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'request_name.required'         => 'ชื่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_position.required'     => 'ตำแหน่งผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_tel.required'          => 'เบอร์ติดต่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.required'        => 'อีเมล์ผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.email'           => 'รูปแบบอีเมล์ไม่ถูกต้อง',
            'st_department_code.required'   => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'       => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'     => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'captcha.required'              => 'กรุณาใส่ผลบวกที่ถูกต้อง',
            'captcha.captcha'               => 'คำตอบไม่ถูกต้อง',
        ];

        return $messages;
    }
}
