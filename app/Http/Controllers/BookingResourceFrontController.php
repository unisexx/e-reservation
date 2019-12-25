<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingResourceRequest;
use App\Model\BookingResource;
use Illuminate\Http\Request;

// use Mail;

class BookingResourceFrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        // ChkPerm('booking-resource-view');

        $keyword = $request->get('search');
        $st_resource_id = $request->get('st_resource_id');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $perPage = 10;

        $rs = BookingResource::select('*');

        if (!empty($st_resource_id)) {
            $rs = $rs->where('st_resource_id', $st_resource_id);
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
            header("Content-Disposition: attachment; filename=จองทรัพยากรอื่นๆ_" . date('Ymdhis') . ".xls"); //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);

            $rs = $rs->orderBy('id', 'desc')->get();
            return view('booking-resource.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id', 'desc')->paginate($perPage);
            return view('booking-resource.index', compact('rs'));

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
        // ChkPerm('booking-resource-create', 'booking-resource');

        return view('booking-resource-front.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingResourceRequest $request)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $data = BookingResource::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingResource::find($data->id);
        $rs->code = $data->stResource->code . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-resource-front/summary/' . $rs->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_resource_id = $request->get('st_resource_id');

        $rs = BookingResource::select('*');

        if (!empty($st_resource_id)) {
            $rs = $rs->where('st_resource_id', $st_resource_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%");
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();
        return view('booking-resource-front.show', compact('rs'));
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
        // ChkPerm('booking-resource-edit','booking-resource');

        $rs = BookingResource::findOrFail($id);
        return view('booking-resource.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookingResourceRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);

        $rs = BookingResource::findOrFail($id);

        $email = 0;
        if ($rs->status != $requestData['status']) {
            $email = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        if ($email == 1) {

            Mail::send([], [], function ($message) use ($rs) {
                $message->to($rs->request_email)
                    ->subject('อัพเดทสถานะการจองห้องประชุม')
                    ->setBody('สถานะการจองห้องประชุม: ' . $rs->status, 'text/html'); // for HTML rich messages
            });

        }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('booking-resource');
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
        // ChkPerm('booking-resource-delete','booking-resource');

        BookingResource::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('booking-resource');
    }

    /**
     * custom method by เดียร์ ชริลแมว
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function summary($id)
    {
        $rs = BookingResource::findOrFail($id);
        return view('booking-resource-front.summary', compact('rs'));
    }
}
