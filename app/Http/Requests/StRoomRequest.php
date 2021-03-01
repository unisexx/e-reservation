<?php

namespace App\Http\Requests;

use App\Model\StRoom;
use Illuminate\Foundation\Http\FormRequest;

class StRoomRequest extends FormRequest
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
            // 'image'             => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name'               => 'required',
            'people'             => 'required|numeric',
            'equipment'          => 'required',
            'res_name'           => 'required',
            'res_tel'            => 'required',
            'fee'                => 'required',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
            'st_province_id'     => 'required',
        ];

        if ($this->segment(3) != '') { // ถ้าเป็นการ edit, $this->segment(3) คือ ไอดี
            $stRoom = StRoom::find($this->segment(3));
            if ($stRoom->notHavingImageInDb()) { // เช็กฐานข้อมูลว่าฟิลด์ image มีค่าหรือไม่, ถ้าไม่มีค่าให้ validate รูป แต่ถ้ามีข้อมูลรูปแล้ว ไม่ต้อง validate
                $rules['image'] = 'required';
                $rules['image.*'] = 'mimes:jpeg,png,jpg,gif|max:2048';
            }
        } else { // ถ้าเป็นการ create ให้ validate รูป
            $rules['image'] = 'required';
            $rules['image.*'] = 'mimes:jpeg,png,jpg,gif|max:2048';
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
        return [
            'image.required'              => 'ภาพห้องประชุม ห้ามเป็นค่าว่าง',
            'image.*.image'               => 'ภาพห้องประชุม เป็นไฟล์รูปนามสกุล .jpeg, .png, .jpg, .gif เท่านั้น',
            'image.*.mimes'               => 'ภาพห้องประชุม เป็นไฟล์รูปนามสกุล .jpeg, .png, .jpg, .gif เท่านั้น',
            'image.*.max'                 => 'ภาพห้องประชุม ขนาดต้องไม่เกิน 2048 kb',
            'name.required'               => 'ชื่อห้องประชุม ห้ามเป็นค่าว่าง',
            'people.required'             => 'จำนวนคนที่รองรับได้ ห้ามเป็นค่าว่าง',
            'people.numeric'              => 'จำนวนคนที่รองรับได้ ต้องเป็นตัวเลขเท่านั้น',
            'equipment.required'          => 'อุปกรณ์ที่ติดตั้งในห้อง ห้ามเป็นค่าว่าง',
            'res_name.required'           => 'ชื่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'res_tel.required'            => 'เบอร์ติดต่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'fee.required'                => 'ค่าใช้จ่าย/ค่าธรรมเนียมฯ ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'กรม ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนัก ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่ม ห้ามเป็นค่าว่าง',
            'st_province_id.required'     => 'จังหวัดที่ตั้งห้องประชุม ห้ามเป็นค่าว่าง',
        ];
    }
}
