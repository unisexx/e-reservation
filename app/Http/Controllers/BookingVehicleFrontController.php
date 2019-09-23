<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\BookingVehicle;

use App\Http\Requests\BookingVehicleRequest;

class BookingVehicleFrontController extends Controller
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
        // ChkPerm('booking-vehicle-view');

        $keyword = $request->get('search');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $perPage = 10;

        $rs = BookingVehicle::select('*');

        if (!empty($date_select)) {
            if($data_type == 'start_date'){
                $rs = $rs->where('start_date',Date2DB($date_select));
            }elseif($data_type == 'end_date'){
                $rs = $rs->where('end_date',Date2DB($date_select));
            }
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function($q) use ($keyword){
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('title', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }


        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองยานพาหนะ_".date('Ymdhis').".xls");  //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            $rs = $rs->orderBy('id','desc')->get();
            return view('booking-vehicle-front.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id','desc')->paginate($perPage);
            return view('booking-vehicle-front.index', compact('rs'));

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
        // ChkPerm('booking-vehicle-create', 'booking-vehicle');

        return view('booking-vehicle-front.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'gofor'                => 'required',
            'number'               => 'required|numeric',
            'request_date'         => 'required',
            'start_date'           => 'required',
            'start_time'           => 'required',
            'end_date'             => 'required',
            'end_time'             => 'required',
            'point_place'          => 'required',
            'point_time'           => 'required',
            'destination'          => 'required',
            'request_name'         => 'required',
            'request_tel'          => 'required',
            'request_email'        => 'required|email',
            'st_department_code'   => 'required',
            'st_bureau_code'       => 'required',
            'st_division_code'     => 'required',
            'g-recaptcha-response' => 'required|captcha',
		], [
            'gofor.required'                => 'ไปเพื่อ ห้ามเป็นค่าว่าง',
            'number.required'               => 'จำนวนผู้โดยสาร ห้ามเป็นค่าว่าง',
            'number.numeric'                => 'จำนวนผู้โดยสาร ต้องเป็นตัวเลขเท่านั้น',
            'request_date.required'         => 'วันที่ขอใช้ ห้ามเป็นค่าว่าง',
            'start_date.required'           => 'วันที่เริ่ม ห้ามเป็นค่าว่าง',
            'start_time.required'           => 'เวลาที่เริ่ม ห้ามเป็นค่าว่าง',
            'end_date.required'             => 'วันที่สิ้นสุด ห้ามเป็นค่าว่าง',
            'end_time.required'             => 'เวลาที่สิ้นสุด ห้ามเป็นค่าว่าง',
            'point_place.required'          => 'สถานที่ขึ้นรถ ห้ามเป็นค่าว่าง',
            'point_time.required'           => 'เวลาที่ขึ้นรถ ห้ามเป็นค่าว่าง',
            'destination.required'          => 'สถานที่ไป ห้ามเป็นค่าว่าง',
            'request_name.required'         => 'ชื่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_tel.required'          => 'เบอร์ติดต่อผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.required'        => 'อีเมล์ผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'request_email.email'           => 'รูปแบบอีเมล์ไม่ถูกต้อง',
            'st_department_code.required'   => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'       => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'     => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'g-recaptcha-response.required' => 'กรุณายืนยันตัวตน ฉันไม่ใช่โปรแกรมอัติโนมัติ',
            'g-recaptcha-response.captcha'  => 'ระบบยืนยันตัวตนผิดพลาด!!! กรุณาติดต่อแอดมิน',
        ]);

        $requestData = $request->all();
        $requestData['request_date'] = Date2DB($request->request_date);
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $data = BookingVehicle::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingVehicle::find($data->id);
        $rs->code = 'RV'.sprintf("%05d", $data->id);
        $rs->save();
        
        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-vehicle-front/summary/'.$rs->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rs = BookingVehicle::select('*');
        $rs = $rs->orderBy('id','desc')->get();
        return view('booking-vehicle-front.show', compact('rs'));
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
        // ChkPerm('booking-vehicle-edit','booking-vehicle');

        $rs = BookingVehicle::findOrFail($id);
        return view('booking-vehicle.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookingVehicleRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['request_date'] = Date2DB($request->request_date);
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        
        $rs = BookingVehicle::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('booking-vehicle-front/show');
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
        // ChkPerm('booking-vehicle-delete','booking-vehicle');

        BookingVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('booking-vehicle-front/show');
    }

    /**
     * custom method by เดียร์ ชริลแมว
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function summary($id)
    {
        $rs = BookingVehicle::findOrFail($id);
        return view('booking-vehicle-front.summary', compact('rs'));
    }
}
