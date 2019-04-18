<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StDriver;
use Illuminate\Http\Request;

class StDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-driver-view');

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $st_bureau_code = $request->get('st_bureau_code');
        $st_division_code = $request->get('st_division_code');
        $perPage = 10;

        $rs = StDriver::select('*');

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($st_bureau_code)) {
            $rs = $rs->where('st_bureau_code', $st_bureau_code);
        }

        if (!empty($st_division_code)) {
            $rs = $rs->where('st_division_code', $st_division_code);
        }

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        $rs = $rs->orderBy('id','desc')->paginate($perPage);


        return view('setting.st-driver.index', compact('rs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        // ChkPerm('st-driver-create', 'setting/st-driver');

        return view('setting.st-driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'               => 'required',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
            'tel'                => 'required',
		], [
            'name.required'               => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'กรม ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนัก ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่ม ห้ามเป็นค่าว่าง',
            'tel.required'                => 'เบอร์ติดต่อ ห้ามเป็นค่าว่าง',
        ]);
        
        $requestData = $request->all();
        
        StDriver::create($requestData);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('setting/st-driver');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $rs = StDriver::findOrFail($id);

        return view('setting.st-driver.show', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-driver-edit','setting/st-driver');

        $rs = StDriver::findOrFail($id);

        return view('setting.st-driver.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'               => 'required',
            'st_department_code' => 'required',
            'st_bureau_code'     => 'required',
            'st_division_code'   => 'required',
            'tel'                => 'required',
		], [
            'name.required'               => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'กรม ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'     => 'สำนัก ห้ามเป็นค่าว่าง',
            'st_division_code.required'   => 'กลุ่ม ห้ามเป็นค่าว่าง',
            'tel.required'                => 'เบอร์ติดต่อ ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        $rs = StDriver::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('setting/st-driver');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-driver-delete','setting/st-driver');

        StDriver::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-driver');
    }
}
