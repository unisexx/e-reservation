<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRoomRequest;
// use App\Jobs\SendEmail;
use App\Mail\Summary;
use App\Model\BookingRoom;
use Illuminate\Http\Request;
use Mail;

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

        // ส่งเมล์
        $this->sendEmail($rs);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-room-front/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_room_id = $request->get('st_room_id');
        $status = $request->get('status');

        $rs = BookingRoom::with('department', 'bureau', 'division', 'st_room');
        $rs_all = $rs->get();

        // ถ้าไม่ได้มาจากช่องค้นหา ให้ select room ตามค่าที่ตั้ง default ไว้ในเมนูตั้งค่าห้อง
        if (!empty($st_room_id)) {
            $rs = $rs->where('st_room_id', $st_room_id);
        } else {
            $rs = $rs->whereHas('st_room', function ($q) {
                $q->where('is_default', 1);
            });
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('title', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        return view('include.__booking-room-show', compact('rs', 'rs_all'))->withFrom('frontend');
    }

    public function summary($id)
    {
        $rs = BookingRoom::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('room')->withFrom('frontend');
    }

    public function sendEmail($rs)
    {
        if ($rs->use_conference == 1) {
            $recipient = [$rs->request_email, 'tsd.ictc@m-society.go.th', 'puwadon.k@m-society.go.th'];
        } else {
            $recipient = [$rs->request_email, 'tsd.ictc@m-society.go.th'];
        }
        Mail::to($recipient)->queue(new Summary($rs->id, 'booking-room', 'create'));
    }

    function print($id) {
        $rs = BookingRoom::with('st_room', 'division', 'bureau', 'department')->findOrFail($id);

        return view('include.__booking-print', compact('rs'))->withType('room')->withFrom('frontend');
    }

    public function testEmail($id)
    {
        $rs = BookingRoom::findOrFail($id);
        $this->sendEmail($rs);
    }
}
