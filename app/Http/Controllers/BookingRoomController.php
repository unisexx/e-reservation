<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRoomRequest;
use App\Model\BookingRoom;
use Auth;
use Illuminate\Http\Request;
use Mail;

class BookingRoomController extends Controller
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
     * @return \Illuminate\Http\Response
     */
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
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         * เห็นเฉพาะห้องที่อยู่ในสังกัดของตัวเอง
         */
        if (CanPerm('access-self')) {
            $rs = $rs->whereHas('st_room', function ($q) {
                $q->where('st_division_code', Auth::user()->st_division_code);
            });
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
            header("Content-Disposition: attachment; filename=จองห้องประชุม_" . date('Ymdhis') . ".xls"); //File name extension was wrong
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-create', 'booking-room');

        return view('booking-room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $rs = BookingRoom::select('*');
        $rs = $rs->orderBy('id', 'desc')->get();
        return view('booking-room.show', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-edit', 'booking-room');

        $rs = BookingRoom::findOrFail($id);
        return view('booking-room.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            Mail::send([], [], function ($message) use ($rs) {
                $message->to($rs->request_email)
                    ->subject('อัพเดทสถานะการจองห้องประชุม')
                    ->setBody(
                        'รหัสการจอง: ' . $rs->code . '<br>' .
                        'หัวข้อการประชุม / ห้องประชุม: ' . $rs->title . ' / ' . $rs->st_room->name . '<br>' .
                        'สถานะการจอง: ' . $rs->status . '<br><br>' .
                        'สามารถดูรายละเอียดการจองได้ที่: <a href="' . url('booking-room-front/show') . '" target="_blank">http://msobooking.m-society.go.th/</a>'
                        , 'text/html'); // for HTML rich messages
            });

        }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('booking-room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-delete', 'booking-room');

        BookingRoom::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('booking-room');
    }

    /**
     * custom method by เดียร์ ชริลแมว
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function summary($id)
    {
        $rs = BookingRoom::findOrFail($id);
        return view('booking-room.summary', compact('rs'));
    }
}
