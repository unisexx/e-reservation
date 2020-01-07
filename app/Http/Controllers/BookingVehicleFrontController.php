<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingVehicleRequest;
use App\Model\BookingVehicle;
use Illuminate\Http\Request;

class BookingVehicleFrontController extends Controller
{
    public function create()
    {
        return view('booking-vehicle-front.create');
    }

    public function store(BookingVehicleRequest $request)
    {
        $requestData = $request->all();
        $requestData['request_date'] = Date2DB($request->request_date);
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $requestData['status'] = 'รออนุมัติ';
        $data = BookingVehicle::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingVehicle::find($data->id);
        $rs->code = 'RV' . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-vehicle-front/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_room_id = $request->get('st_vehicle_id');

        $rs = BookingVehicle::select('*');

        if (!empty($st_room_id)) {
            $rs = $rs->where('st_vehicle_id', $st_room_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%");
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();
        return view('include.__booking-vehicle-show', compact('rs'))->withFrom('frontend');
    }

    public function summary($id)
    {
        $rs = BookingVehicle::findOrFail($id);
        return view('include.__booking-summary', compact('rs'))->withType('vehicle')->withFrom('frontend');
    }
}
