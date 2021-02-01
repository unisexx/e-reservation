<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StBossRequest extends FormRequest
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
            'st_position_level_id' => 'required',
            'name'                 => 'required',
            'st_boss_position_id'  => 'required',
            'tel'                  => 'required',
            'res_name'             => 'required',
            'res_tel'              => 'required',
            'st_department_code'   => 'required',
            'st_bureau_code'       => 'required',
            'st_division_code'     => 'required',
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
            'st_position_level_id.required' => 'ระดับตำแหน่ง ห้ามเป็นค่าว่าง',
            'name.required'                 => 'ชื่อ ห้ามเป็นค่าว่าง',
            'st_boss_position_id.required'  => 'ตำแหน่ง ห้ามเป็นค่าว่าง',
            'tel.required'                  => 'เบอร์ติดต่อ ห้ามเป็นค่าว่าง',
            'res_name.required'             => 'ชื่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'res_tel.required'              => 'เบอร์ติดต่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'st_department_code.required'   => 'กรม ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'       => 'สำนัก ห้ามเป็นค่าว่าง',
            'st_division_code.required'     => 'กลุ่ม ห้ามเป็นค่าว่าง',
        ];
    }
}
