<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRoomRequest;
use App\Model\BookingRoom;
use Illuminate\Http\Request;

class BookingRoomFrontController extends Controller
{
    public function create()
    {
        return view('booking-room-front.create');
    }

    public function store(BookingRoomRequest $request)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $requestData['status'] = 'รออนุมัติ';
        $data = BookingRoom::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingRoom::find($data->id);
        $rs->code = 'RR' . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-room-front/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_room_id = $request->get('st_room_id');

        $rs = BookingRoom::select('*');

        if (!empty($st_room_id)) {
            $rs = $rs->where('st_room_id', $st_room_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('title', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();
        return view('booking-room-front.show', compact('rs'));
    }

    public function summary($id)
    {
        $rs = BookingRoom::findOrFail($id);
        return view('include.__booking-summary', compact('rs'))->withType('room')->withFrom('frontend');
    }
}
