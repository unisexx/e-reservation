<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRoomRequest;
use App\Mail\Summary;
use App\Model\BookingRoom;
use Auth;
use Illuminate\Http\Request;
use Mail;

class BookingRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-view');

        $keyword     = $request->get('search');
        $data_type   = $request->get('date_type');
        $date_select = $request->get('date_select');
        $status      = $request->get('status');
        $perPage     = 10;

        $rs = BookingRoom::filterByPermissionView()
            ->with('st_room.department', 'st_room.bureau', 'st_room.division', 'department', 'bureau', 'division', 'approver.prefix', 'conferenceApprover.prefix')
            ->select('*')->where('use_conference', '<>', 1);

        $rs_all = $rs->get();

        if (!empty($date_select)) {
            if ($data_type == 'start_date') {
                $rs = $rs->where('start_date', Date2DB($date_select));
            } elseif ($data_type == 'end_date') {
                $rs = $rs->where('end_date', Date2DB($date_select));
            }
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

        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองห้องประชุม/อบรม_" . date('Ymdhis') . ".xls"); //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);

            $rs = $rs->orderBy('id', 'desc')->get();

            return view('booking-room.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id', 'desc')->paginate($perPage);

            return view('booking-room.index', compact('rs', 'rs_all'));

        }

    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-create', 'booking-room');

        return view('booking-room.create');
    }

    public function store(BookingRoomRequest $request)
    {
        $requestData               = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date']   = Date2DB($request->end_date);
        if ($requestData['use_conference'] == 1) {
            $requestData['status_conference'] = 'รออนุมัติ';
        }

        $data = BookingRoom::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs       = BookingRoom::find($data->id);
        $rs->code = 'RR' . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-room/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword    = $request->get('search');
        $st_room_id = $request->get('st_room_id');
        $status     = $request->get('status');

        $rs = BookingRoom::filterByPermissionView()
            ->select('*')
            ->where('use_conference', '<>', 1);

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

        $rs = $rs->orderBy('id', 'desc')->with('department', 'bureau', 'division', 'st_room')->get();

        return view('include.__booking-room-show', compact('rs'))->withFrom('backend');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        // ChkPerm('booking-room-edit', 'booking-room');

        $rs = BookingRoom::findOrFail($id);

        return view('booking-room.edit', compact('rs'));
    }

    public function update(BookingRoomRequest $request, $id)
    {
        $requestData               = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date']   = Date2DB($request->end_date);

        $rs = BookingRoom::findOrFail($id);

        // approve conference
        // $rs->status_conference = @$requestData['status_conference'];
        // if ($rs->isDirty('status_conference')) {
        //     $requestData['approve_conference_by_id'] = Auth::user()->id;
        //     $requestData['approve_conference_date'] = date('Y-m-d H:i:s');
        // }

        $email      = 0;
        $rs->status = @$requestData['status'];
        if ($rs->isDirty('status')) {
            $email                        = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
            $requestData['approve_by_id'] = Auth::user()->id;
            $requestData['approve_date']  = date('Y-m-d H:i:s');
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        if ($email == 1) {
            $this->sendEmail($rs);
        }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('booking-room');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-delete', 'booking-room');

        BookingRoom::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('booking-room');
    }

    public function summary($id)
    {
        $rs = BookingRoom::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('room')->withFrom('backend');
    }

    public function sendEmail($rs)
    {
        if ($rs->use_conference == 1) {
            $recipient = [$rs->request_email, 'tsd.ictc@m-society.go.th', 'puwadon.k@m-society.go.th'];
        } else {
            $recipient = [$rs->request_email];
        }
        Mail::to($recipient)->queue(new Summary($rs->id, 'booking-room', 'update'));
    }

    public function testEmail($id)
    {
        $rs = BookingRoom::findOrFail($id);
        $this->sendEmail($rs);
    }
}
