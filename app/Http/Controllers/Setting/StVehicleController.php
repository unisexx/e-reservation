<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StVehicle;
use Illuminate\Http\Request;

use App\Http\Requests\StVehicleRequest;

class StVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('st-vehicle-view');

        $st_vehicle_type_id = $request->get('st_vehicle_type_id');
        $keyword = $request->get('search');
        $perPage = 10;

        $rs = StVehicle::select('*');

        if (!empty($st_vehicle_type_id)) {
            $rs = $rs->where('st_vehicle_type_id', $st_vehicle_type_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where('brand', 'LIKE', "%$keyword%");
        }

        $rs = $rs->orderBy('id', 'desc')->paginate($perPage);

        // if (!empty($keyword)) {
        //     $rs = StVehicle::where('name', 'LIKE', "%$keyword%")
        //         ->latest()->paginate($perPage);
        // } else {
        //     $rs = StVehicle::latest()->paginate($perPage);
        // }

        return view('setting.st-vehicle.index', compact('rs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('st-vehicle-create', 'setting/st-vehicle');

        return view('setting.st-vehicle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StVehicleRequest $request)
    {
        $requestData = $request->all();

        // ไฟล์แนบ
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/vehicle/'), $imageName);

            $requestData['image'] = $imageName;
        }

        StVehicle::create($requestData);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle');
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
        $rs = StVehicle::findOrFail($id);

        return view('setting.st-vehicle.show', compact('rs'));
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
        ChkPerm('st-vehicle-edit','setting/st-vehicle');

        $rs = StVehicle::findOrFail($id);

        return view('setting.st-vehicle.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StVehicleRequest $request, $id)
    {
        $requestData = $request->all();

        // ไฟล์แนบ
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/vehicle/'), $imageName);

            $requestData['image'] = $imageName;
        }

        $rs = StVehicle::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle');
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
        ChkPerm('st-vehicle-delete','setting/st-vehicle');

        StVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle');
    }
}
