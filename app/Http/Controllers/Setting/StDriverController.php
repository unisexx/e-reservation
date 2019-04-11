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
        $perPage = 10;

        if (!empty($keyword)) {
            $rs = StDriver::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $rs = StDriver::latest()->paginate($perPage);
        }

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
            'name' => 'required',
		], [
            'name.required' => 'ชื่อประเภทรถ ห้ามเป็นค่าว่าง',
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

        $stvehicletype = StDriver::findOrFail($id);

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
            'name' => 'required',
		], [
            'name.required' => 'ชื่อประเภทรถ ห้ามเป็นค่าว่าง',
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
