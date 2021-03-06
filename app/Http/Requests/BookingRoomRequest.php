<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'st_room_id'         => 'required',
            'title'              => 'required',
            'start_date'         => 'required',
            'start_time'         => 'required',
            'end_date'           => 'required',
            'end_time'           => 'required',
            'number'             => 'required|numeric',
            // 'internet_number'    => 'required|numeric',
            'request_name'       => 'required',
            'request_position'   => 'required',
            'request_tel'        => 'required',
            'request_email'      => 'required|email:rfc,dns',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
            'captcha'            => 'sometimes|required|captcha',
            // 'g-recaptcha-response' => 'required|captcha',
        ];

        // จำนวนคนเกินห้องประชุม
        if ($this->st_room_over_people != 1) {
            $rules['number'] = 'lte:st_room_people';
        }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'st_room_id.required'         => 'เลือกห้องประชุม ห้ามเป็นค่าว่าง',
            'title.required'              => 'ชื่อเรื่อง / หัวข้อการประชุม ห้ามเป็นค่าว่าง',
            'start_date.required'         => 'วันที่เริ่มใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'start_time.required'         => 'เวลาที่เริ่มใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'end_date.required'           => 'วันที่สิ้นสุดใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'end_time.required'           => 'เวลาที่สิ้นสุดใช้ห้องประชุม ห้ามเป็นค่าว่าง',
            'number.required'             => 'จำนวนผู้เข้าร่วมประชุม ห้ามเป็นค่าว่าง',
            'number.numeric'              => 'จำนวนผู้เข้าร่วมประชุม ต้องเป็นตัวเลขเท่านั้น',
            'number.lte'                  => 'จำนวนผู้เข้าร่วมประชุม ห้ามเกินจำนวนที่รองรับของห้องประชุม',
            // 'internet_number.required'    => 'ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต ห้ามเป็นค่าว่าง',
            // 'internet_number.numeric'     => 'ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต ต้องเป็นตัวเลขเท่านั้น',
            'request_name.required'       => 'ชื่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_position.required'   => 'ตำแหน่งผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_tel.required'        => 'เบอร์ติดต่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.required'      => 'อีเมล์ผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.email'         => 'รูปแบบอีเมล์ไม่ถูกต้อง',
            'st_department_code.required' => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            // 'g-recaptcha-response.required' => 'กรุณายืนยันตัวตน ฉันไม่ใช่โปรแกรมอัตโนมัติ',
            // 'g-recaptcha-response.captcha'  => 'ระบบยืนยันตัวตนผิดพลาด!!! กรุณาติดต่อแอดมิน',
            'captcha.required'            => 'กรุณาใส่ผลบวกที่ถูกต้อง',
            'captcha.captcha'             => 'คำตอบไม่ถูกต้อง',
        ];

        // จำนวนคนเกินห้องประชุม
        if ($this->st_room_over_people != 1) {
            $messages['number.lte'] = 'จำนวนผู้เข้าร่วมประชุม ห้ามเกินจำนวนที่รองรับของห้องประชุม';
        }

        return $messages;
    }
}
