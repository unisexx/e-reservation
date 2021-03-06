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
            'name'                => 'required',
            'st_boss_position_id' => 'required',
            'tel'                 => 'required',
            'color'               => 'required',
            'abbr'                => 'required|min:2|max:2',
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
            'name.required'                => 'ชื่อ ห้ามเป็นค่าว่าง',
            'st_boss_position_id.required' => 'ตำแหน่ง ห้ามเป็นค่าว่าง',
            'tel.required'                 => 'เบอร์ติดต่อ ห้ามเป็นค่าว่าง',
            'color.required'               => 'สี ห้ามเป็นค่าว่าง',
            'abbr.required'                => 'อักษรย่อ ห้ามเป็นค่าว่าง',
            'abbr.min'                     => 'อักษรย่อ ขนาด 2 ตัวอักษร',
            'abbr.max'                     => 'อักษรย่อ ขนาด 2 ตัวอักษร',
        ];
    }
}
