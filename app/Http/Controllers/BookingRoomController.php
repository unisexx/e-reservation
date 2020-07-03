<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRoomRequest;
use App\Model\BookingRoom;
use App\Model\ManageRoom;
use Auth;
use Illuminate\Http\Request;
use DB;

use Mail;
use App\Mail\Status;

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

        $keyword = $request->get('search');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $perPage = 10;

        $rs = BookingRoom::select('*');


        /**
         *  ถ้า user ที่ login นี้ ได้ถูกเลือกเป็นผู้จัดการจองห้อง (Manage booking) ใน setting/st-room ให้แสดงเฉพาะการจองของห้องที่ถูกต้องค่าไว้ โดยไม่สนว่าจะเป็น access-self หรือ access-all
         */
        $is_manageroom = ManageRoom::select('st_room_id')->where('user_id', Auth::user()->id)->get()->toArray();
        // dd($is_manageroom);
        if($is_manageroom){
            $rs = $rs->whereIn('st_room_id', $is_manageroom);
        }else{
            /**
             * เห็นเฉพาะห้องที่อยู่ในกลุ่มของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, ถ้าเป็น default คือเห็นทั้งหมด
             */
            if (CanPerm('access-self')) {
                $rs = $rs->whereHas('st_room', function ($q) {
                    $q->where('st_division_code', Auth::user()->st_division_code);
                });
            }
        }

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
            return view('booking-room.index', compact('rs'));

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
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $data = BookingRoom::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingRoom::find($data->id);
        $rs->code = 'RR' . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-room/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_room_id = $request->get('st_room_id');

        $rs = BookingRoom::select('*');

        if (!empty($st_room_id)) {
            $rs = $rs->where('st_room_id', $st_room_id);
        }else{
            $rs = $rs->whereHas('st_room', function($q){
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

        $rs = $rs->orderBy('id', 'desc')->get();
        return view('include.__booking-room-show', compact('rs'))->withFrom('backend');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-edit', 'booking-room');

        $rs = BookingRoom::findOrFail($id);
        return view('booking-room.edit', compact('rs'));
    }

    public function update(BookingRoomRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);

        $rs = BookingRoom::findOrFail($id);

        $email = 0;
        $rs->status = $requestData['status'];
        if ($rs->isDirty('status')) {
            $email = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        if ($email == 1) {
            $this->sendEmailStatus($rs);
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

    public function sendEmailStatus($rs){
        Mail::to($rs->request_email)->queue(new Status($rs->id, 'booking-room'));
    }
}
