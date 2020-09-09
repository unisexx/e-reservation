<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingVehicleRequest;
use App\Mail\Status;
use App\Model\BookingVehicle;
use Auth;
use Illuminate\Http\Request;
use Mail;

class BookingVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-vehicle-view');

        $st_vehicle_type_id = $request->get('st_vehicle_type_id');
        $keyword = $request->get('search');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $status = $request->get('status');
        $perPage = 10;

        $rs = BookingVehicle::select('*');

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         * เห็นเฉพาะยานพาหนะที่อยู่ในสังกัดของตัวเอง
         */
        if (CanPerm('access-self')) {
            // $rs = $rs->whereHas('st_vehicle', function($q){
            //     $q->where('st_division_code',Auth::user()->st_division_code);
            // });

            $rs = $rs->where('req_st_department_code', Auth::user()->st_department_code)
                ->where('req_st_bureau_code', Auth::user()->st_bureau_code)
                ->where('req_st_division_code', Auth::user()->st_division_code);
        }
        $rs_all = $rs->get();

        if (!empty($st_vehicle_type_id)) {
            $rs = $rs->whereHas('st_vehicle', function ($q) use ($st_vehicle_type_id) {
                $q->where('st_vehicle_type_id', $st_vehicle_type_id);
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
                    ->orWhere('gofor', 'LIKE', "%$keyword%")
                    ->orWhereHas('st_driver', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%$keyword%");
                    })
                    ->orWhereHas('st_vehicle', function ($q) use ($keyword) {
                        $q->where('brand', 'LIKE', "%$keyword%")
                            ->orWhere('color', 'LIKE', "%$keyword%")
                            ->orWhere('reg_number', 'LIKE', "%$keyword%")->orWhereHas('st_driver', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', "%$keyword%");
                        });
                    });
            });
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองยานพาหนะ_" . date('Ymdhis') . ".xls"); //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);

            $rs = $rs->orderBy('id', 'desc')->get();

            return view('booking-vehicle.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id', 'desc')->with('st_vehicle', 'st_driver', 'department', 'bureau', 'division')->paginate($perPage);

            return view('booking-vehicle.index', compact('rs', 'rs_all'));

        }
    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-vehicle-create', 'booking-vehicle');

        return view('booking-vehicle.create');
    }

    public function store(BookingVehicleRequest $request)
    {
        $requestData = $request->all();
        $requestData['request_date'] = Date2DB($request->request_date);
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $requestData['request_time'] = date("H:i");
        $data = BookingVehicle::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingVehicle::find($data->id);
        $rs->code = 'RV' . sprintf("%05d", $data->id);
        $rs->save();

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-vehicle/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_room_id = $request->get('st_vehicle_id');
        $st_department_code = $request->get('st_department_code');
        $st_bureau_code = $request->get('st_bureau_code');
        $st_division_code = $request->get('st_division_code');
        $status = $request->get('status');

        $rs = BookingVehicle::select('*');
        $rs_all = $rs->get();

        if (!empty($st_room_id)) {
            $rs = $rs->where('st_vehicle_id', $st_room_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($st_bureau_code)) {
            $rs = $rs->where('st_bureau_code', $st_bureau_code);
        }

        if (!empty($st_division_code)) {
            $rs = $rs->where('st_division_code', $st_division_code);
        }

        // if ($st_department_code || $st_bureau_code || $st_division_code) {
        //     $rs = $rs->orderBy('id', 'desc')->with('st_vehicle')->get();
        // }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        $rs = $rs->orderBy('id', 'desc')->with('st_vehicle')->get();

        return view('include.__booking-vehicle-show', compact('rs', 'rs_all'))->withFrom('backend');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-vehicle-edit', 'booking-vehicle');

        $rs = BookingVehicle::findOrFail($id);

        return view('booking-vehicle.edit', compact('rs'));
    }

    public function update(BookingVehicleRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['request_date'] = Date2DB($request->request_date);
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $requestData['approve_by_id'] = Auth::user()->id;
        $requestData['approve_date'] = date('Y-m-d H:i:s');

        $rs = BookingVehicle::findOrFail($id);

        $email = 0;
        $rs->status = $requestData['status'];
        if ($rs->isDirty('status')) {
            $email = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        if ($email == 1) {
            $this->sendEmailStatus($rs);
            // Mail::send([], [], function ($message) use ($rs) {
            //     $message->to($rs->request_email)
            //         ->subject('อัพเดทสถานะการจองยานพาหนะ')
            //         ->setBody(
            //             'รหัสการจอง: ' . $rs->code . '<br>' .
            //             'ไปเพื่อ: ' . $rs->gofor . '<br>' .
            //             'จุดขึ้นรถ: ' . $rs->point_place . '<br>' .
            //             'สถานที่ไป: ' . $rs->destination . '<br>' .
            //             'สถานะการจอง: ' . $rs->status . '<br><br>' .
            //             'สามารถดูรายละเอียดการจองได้ที่: <a href="' . url('booking-vehicle/show') . '" target="_blank">http://msobooking.m-society.go.th/</a>'
            //             , 'text/html'); // for HTML rich messages
            // });

        }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('booking-vehicle');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-vehicle-delete', 'booking-vehicle');

        BookingVehicle::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('booking-vehicle');
    }

    public function summary($id)
    {
        $rs = BookingVehicle::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('vehicle')->withFrom('backend');
    }

    public function sendEmailStatus($rs)
    {
        Mail::to($rs->request_email)->queue(new Status($rs->id, 'booking-vehicle'));
    }
}
