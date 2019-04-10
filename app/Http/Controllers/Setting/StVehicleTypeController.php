<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StVehicleType;
use Illuminate\Http\Request;

// use App\Http\Requests\StVehicleTypeRequest;

class StVehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        // ChkPerm('st-vehicle-type-view');

        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $stvehicletype = StVehicleType::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $stvehicletype = StVehicleType::latest()->paginate($perPage);
        }

        return view('setting.st-vehicle-type.index', compact('stvehicletype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        // ChkPerm('st-vehicle-type-create', 'setting/st-vehicle-type');

        return view('setting.st-vehicle-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StVehicleTypeRequest $request)
    {
        $requestData = $request->all();
        
        // ไฟล์แนบ
        if ($request->hasFile('image')) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

            $requestData['image'] = $imageName;
        }
        
        StVehicleType::create($requestData);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle-type');
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
        $stvehicletype = StVehicleType::findOrFail($id);

        return view('setting.st-vehicle-type.show', compact('stvehicletype'));
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
        // ChkPerm('st-vehicle-type-edit','setting/st-vehicle-type');

        $stvehicletype = StVehicleType::findOrFail($id);

        return view('setting.st-vehicle-type.edit', compact('stvehicletype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StVehicleTypeRequest $request, $id)
    {
        $requestData = $request->all();

        // ไฟล์แนบ
        if ($request->hasFile('image')) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

            $requestData['image'] = $imageName;
        }
        
        $stvehicletype = StVehicleType::findOrFail($id);
        $stvehicletype->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle-type');
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
        // ChkPerm('st-vehicle-type-delete','setting/st-vehicle-type');

        StVehicleType::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle-type');
    }
}
