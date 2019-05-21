<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\BookingVehicle;

use App\Http\Requests\BookingVehicleRequest;

use Mail;

class BookingVehicleController extends Controller
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
        ChkPerm('booking-vehicle-view');

        $st_vehicle_type_id = $request->get('st_vehicle_type_id');
        $keyword = $request->get('search');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $perPage = 10;

        $rs = BookingVehicle::select('*');

        if (!empty($st_vehicle_type_id)) {
            $rs = $rs->whereHas('st_vehicle', function($q) use ($st_vehicle_type_id){
                        $q->where('st_vehicle_type_id', $st_vehicle_type_id);
                    });
        }

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
                    ->orWhere('gofor', 'LIKE', "%$keyword%")
                    ->orWhereHas('st_vehicle', function($q) use ($keyword){
                        $q->where('brand', 'LIKE', "%$keyword%")
                        ->orWhere('color', 'LIKE', "%$keyword%")
                        ->orWhere('reg_number', 'LIKE', "%$keyword%")->orWhereHas('st_driver', function($q) use ($keyword){
                            $q->where('name', 'LIKE', "%$keyword%");
                        });
                    });
            });
        }


        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองยานพาหนะ_".date('Ymdhis').".xls");  //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            $rs = $rs->orderBy('id','desc')->get();
            return view('booking-vehicle.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id','desc')->paginate($perPage);
            return view('booking-vehicle.index', compact('rs'));

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
        ChkPerm('booking-vehicle-create', 'booking-vehicle');

        return view('booking-vehicle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingVehicleRequest $request)
    {
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
        return redirect('booking-vehicle');
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
        return view('booking-vehicle.show', compact('rs'));
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
        ChkPerm('booking-vehicle-edit','booking-vehicle');

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

        $email = 0;
        if($rs->status != $requestData['status']){
            $email = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        if($email == 1){
            
            Mail::send([], [], function ($message) use ($rs) {
            $message->to($rs->request_email)
                ->subject('อัพเดทสถานะการจองยานพาหนะ')
                ->setBody('สถานะการจองยานพาหนะ: '.$rs->status , 'text/html'); // for HTML rich messages
            });

        }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('booking-vehicle');
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
        ChkPerm('booking-vehicle-delete','booking-vehicle');

        BookingVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('booking-vehicle');
    }
}
