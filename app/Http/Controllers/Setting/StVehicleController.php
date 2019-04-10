<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StVehicle;
use Illuminate\Http\Request;

// use App\Http\Requests\StVehicleRequest;

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
        // ChkPerm('st-vehicle-view');

        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $stvehicle = StVehicle::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $stvehicle = StVehicle::latest()->paginate($perPage);
        }

        return view('setting.st-vehicle.index', compact('stvehicle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        // ChkPerm('st-vehicle-create', 'setting/st-vehicle');

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
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

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
        $stvehicle = StVehicle::findOrFail($id);

        return view('setting.st-vehicle.show', compact('stvehicle'));
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
        // ChkPerm('st-vehicle-edit','setting/st-vehicle');

        $stvehicle = StVehicle::findOrFail($id);

        return view('setting.st-vehicle.edit', compact('stvehicle'));
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
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

            $requestData['image'] = $imageName;
        }
        
        $stvehicle = StVehicle::findOrFail($id);
        $stvehicle->update($requestData);

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
        // ChkPerm('st-vehicle-delete','setting/st-vehicle');

        StVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-vehicle');
    }
}
