<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StVehicleRequest;
use App\Model\StVehicle;
use Auth;
use Illuminate\Http\Request;

class StVehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $rs = StVehicle::withCount('bookingVehicle');

        if (!empty($st_vehicle_type_id)) {
            $rs = $rs->where('st_vehicle_type_id', $st_vehicle_type_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where('brand', 'LIKE', "%$keyword%");
        }

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (CanPerm('access-self')) {
            $rs = $rs->where('st_division_code', Auth::user()->st_division_code);
        }

        $rs = $rs->orderBy('id', 'desc')->paginate(10);

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
        ChkPerm('st-vehicle-edit', 'setting/st-vehicle');

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
        ChkPerm('st-vehicle-delete', 'setting/st-vehicle');

        StVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-vehicle');
    }
}
