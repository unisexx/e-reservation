<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingVehicleRequest extends FormRequest
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
            'gofor'              => 'required',
            'number'             => 'required|numeric',
            'request_date'       => 'required',
            'request_time'       => 'required',
            'start_date'         => 'required',
            'start_time'         => 'required',
            'end_date'           => 'required',
            'end_time'           => 'required',
            'point_place'        => 'required',
            'point_time'         => 'required',
            'destination'        => 'required',
            'request_name'       => 'required',
            'request_tel'        => 'required',
            'request_email'      => 'required',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
        ];

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gofor.required'              => 'ไปเพื่อ ห้ามเป็นค่าว่าง',
            'number.required'             => 'จำนวนผู้โดยสาร ห้ามเป็นค่าว่าง',
            'number.numeric'              => 'จำนวนผู้โดยสาร ต้องเป็นตัวเลขเท่านั้น',
            'request_date.required'       => 'วันที่ขอใช้ ห้ามเป็นค่าว่าง',
            'request_time.required'       => 'เวลาที่ขอใช้ ห้ามเป็นค่าว่าง',
            'start_date.required'         => 'วันที่เริ่ม ห้ามเป็นค่าว่าง',
            'start_time.required'         => 'เวลาที่เริ่ม ห้ามเป็นค่าว่าง',
            'end_date.required'           => 'วันที่สิ้นสุด ห้ามเป็นค่าว่าง',
            'end_time.required'           => 'เวลาที่สิ้นสุด ห้ามเป็นค่าว่าง',
            'point_place.required'        => 'สถานที่ขึ้นรถ ห้ามเป็นค่าว่าง',
            'point_time.required'         => 'เวลาที่ขึ้นรถ ห้ามเป็นค่าว่าง',
            'destination.required'        => 'สถานที่ไป ห้ามเป็นค่าว่าง',
            'request_name.required'       => 'ชื่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_tel.required'        => 'เบอร์ติดต่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.required'      => 'อีเมล์ผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
        ];
    }
}