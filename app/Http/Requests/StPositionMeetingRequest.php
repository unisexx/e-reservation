<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StPositionMeetingRequest extends FormRequest
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
            'name' => 'required',
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
            'name.required' => 'ชื่อตำแหน่ง ห้ามเป็นค่าว่าง',
        ];
    }
}
