<?php

namespace App\Http\Requests;

use App\Model\StVehicle;
use Illuminate\Foundation\Http\FormRequest;

class StVehicleRequest extends FormRequest
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
            'st_vehicle_type_id' => 'required',
            'brand'              => 'required',
            'seat'               => 'required|numeric',
            'color'              => 'required',
            'reg_number'         => 'required',
            'res_name'           => 'required',
            'res_tel'            => 'required',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
            // 'st_driver_id'       => 'required',
        ];

        if ($this->segment(3) != '') {
            // ถ้าเป็นการ edit, $this->segment(3) คือ ไอดี
            $stVehicle = StVehicle::find($this->segment(3));
            if ($stVehicle->notHavingImageInDb()) {
                // เช็กฐานข้อมูลว่าฟิลด์ image มีค่าหรือไม่, ถ้าไม่มีค่าให้ validate รูป แต่ถ้ามีข้อมูลรูปแล้ว ไม่ต้อง validate
                $rules['image'] = 'required|mimes:jpeg,png,jpg,gif|max:2048';
            }
        } else {
            // ถ้าเป็นการ create ให้ validate รูป
            $rules['image'] = 'required|mimes:jpeg,png,jpg,gif|max:2048';
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
            'image.required'              => 'ภาพยานพาหนะ ห้ามเป็นค่าว่าง',
            // 'image.image'                 => 'ภาพยานพาหนะ เป็นไฟล์รูปนามสกุล .jpeg, .png, .jpg, .gif เท่านั้น',
            'image.mimes'                 => 'ภาพยานพาหนะ เป็นไฟล์รูปนามสกุล .jpeg, .png, .jpg, .gif เท่านั้น',
            'image.max'                   => 'ภาพยานพาหนะ ขนาดต้องไม่เกิน 2048 kb',
            'st_vehicle_type_id.required' => 'ประเภท ห้ามเป็นค่าว่าง',
            'brand.required'              => 'ยี่ห้อ ห้ามเป็นค่าว่าง',
            'seat.required'               => 'ที่นั่ง ห้ามเป็นค่าว่าง',
            'seat.numeric'                => 'ที่นั่ง ต้องเป็นตัวเลขเท่านั้น',
            'color.required'              => 'สี ห้ามเป็นค่าว่าง',
            'reg_number.required'         => 'เลขทะเบียน ห้ามเป็นค่าว่าง',
            'res_name.required'           => 'ชื่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'res_tel.required'            => 'เบอร์ติดต่อผู้รับผิดชอบ ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'กรม ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนัก ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่ม ห้ามเป็นค่าว่าง',
            // 'st_driver_id.required'       => 'พนักงานขับวันนี้ ห้ามเป็นค่าว่าง',
        ];
    }
}
