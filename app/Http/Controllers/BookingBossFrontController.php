<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingBossRequest;
use App\Model\BookingBoss;
use Illuminate\Http\Request;

class BookingBossFrontController extends Controller
{
    public function create()
    {
        return view('booking-resource-front.create');
    }

    public function store(BookingBossRequest $request)
    {
        // $requestData = $request->all();
        // $requestData['start_date'] = Date2DB($request->start_date);
        // $requestData['end_date'] = Date2DB($request->end_date);
        // $requestData['status'] = 'รออนุมัติ';
        // $data = BookingResource::create($requestData);

        // // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        // $rs = BookingResource::find($data->id);
        // $rs->code = $data->stResource->code . sprintf("%05d", $data->id);
        // $rs->save();

        // // ส่งเมล์
        // $this->sendEmailSummary($rs);

        // set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        // return redirect('booking-resource-front/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        // $keyword = $request->get('search');
        // $st_resource_id = $request->get('st_resource_id');
        // $status = $request->get('status');

        // $rs = BookingResource::select('*');
        // $rs_all = $rs->get();

        // if (!empty($st_resource_id)) {
        //     $rs = $rs->where('st_resource_id', $st_resource_id);
        // }

        // if (!empty($keyword)) {
        //     $rs = $rs->where(function ($q) use ($keyword) {
        //         $q->where('code', 'LIKE', "%$keyword%")
        //             ->orWhere('request_name', 'LIKE', "%$keyword%");
        //     });
        // }

        // if (!empty($status)) {
        //     $rs = $rs->where('status', $status);
        // }

        // $rs = $rs->orderBy('id', 'desc')->with('stResource')->get();

        // return view('include.__booking-resource-show', compact('rs', 'rs_all'))->withFrom('frontend');
    }

    public function summary($id)
    {
        $rs = BookingBoss::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('boss')->withFrom('frontend');
    }

    function print($id) {
        $rs = BookingBoss::with('st_room', 'division', 'bureau', 'department')->findOrFail($id);

        return view('include.__booking-print', compact('rs'))->withType('boss')->withFrom('frontend');
    }
}
