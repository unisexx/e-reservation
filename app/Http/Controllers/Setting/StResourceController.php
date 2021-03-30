<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Model\ManageResource;
use App\Model\StResource;
use Auth;
use Illuminate\Http\Request;

class StResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-resource-view');

        $keyword = $request->get('search');

        $rs = StResource::withCount('bookingResource');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (CanPerm('access-self')) {
            $rs = $rs->where('st_division_code', Auth::user()->st_division_code);
        }

        $rs = $rs->orderBy('id', 'desc')->paginate(10);

        return view('setting.st-resource.index', compact('rs'));
    }

    public function create()
    {
        // ตรวจสอบ permission
        // ChkPerm('st-resource-create', 'setting/st-resource');

        return view('setting.st-resource.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ], [
            'code.required' => 'รหัส ห้ามเป็นค่าว่าง',
            'name.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        $stresource = StResource::create($requestData);

        // บันทึกผู้จัดการทรัพยากร
        if (isset($request->manage_resource_user_id)) {
            foreach ($request->manage_resource_user_id as $user_id) {
                ManageResource::updateOrCreate(
                    [
                        'st_resource_id'    => $stresource->id,
                        'user_id'           => $user_id,
                        'create_by_user_id' => Auth::user()->id,
                    ]
                );
            }
        }

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/st-resource');
    }

    public function show($id)
    {
        $rs = StResource::findOrFail($id);

        return view('setting.st-resource.show', compact('rs'));
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-resource-edit','setting/st-resource');

        $rs = StResource::findOrFail($id);

        return view('setting.st-resource.edit', compact('rs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ], [
            'code.required' => 'รหัส ห้ามเป็นค่าว่าง',
            'name.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        $rs = StResource::findOrFail($id);
        $rs->update($requestData);

        // บันทึกผู้จัดการจองทรัพยากร
        if (isset($request->manage_resource_user_id)) {
            foreach ($request->manage_resource_user_id as $user_id) {
                ManageResource::updateOrCreate(
                    [
                        'st_resource_id'    => $rs->id,
                        'user_id'           => $user_id,
                        'create_by_user_id' => Auth::user()->id,
                    ]
                );
            }
        }

        // ลบผู้จัดการจองทรัพยากรที่ไม่ได้ถูกเลือกในฟอร์ม
        if (isset($request->manage_resource_user_id)) {
            ManageResource::where('st_resource_id', $rs->id)->whereNotIn('user_id', $request->manage_resource_user_id)->delete();
        } else {
            ManageResource::where('st_resource_id', $rs->id)->delete();
        }

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/st-resource');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-resource-delete','setting/st-resource');

        StResource::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-resource');
    }
}
