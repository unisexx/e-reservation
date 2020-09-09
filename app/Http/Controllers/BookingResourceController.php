<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingResourceRequest;
use App\Mail\Status;
use App\Model\BookingResource;
use App\Model\ManageResource;
use Auth;
use Illuminate\Http\Request;
use Mail;

class BookingResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-resource-view');

        $keyword = $request->get('search');
        $st_resource_id = $request->get('st_resource_id');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $status = $request->get('status');
        $perPage = 10;

        $rs = BookingResource::select('*');

        /**
         *  ถ้า user ที่ login นี้ ได้ถูกเลือกเป็นผู้จัดการจองทรัพยากร (Manage booking) ใน setting/st-resource ให้แสดงเฉพาะการจองของทรัพยากรที่ถูกต้องค่าไว้ โดยไม่สนว่าจะเป็น access-self หรือ access-all
         */
        $is_manageresource = ManageResource::select('st_resource_id')->where('user_id', Auth::user()->id)->get()->toArray();
        // dd($is_manageroom);
        if ($is_manageresource) {
            $rs = $rs->whereIn('st_resource_id', $is_manageresource);
        } else {
            /**
             * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
             * เห็นเฉพาะทรัพยากรที่อยู่ในสังกัดของตัวเอง
             */
            if (CanPerm('access-self')) {
                $rs = $rs->whereHas('stResource', function ($q) {
                    $q->where('st_division_code', Auth::user()->st_division_code);
                });
            }
        }
        $rs_all = $rs->get();

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

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
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

            return view('booking-resource.index', compact('rs', 'rs_all'));

        }

    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-resource-create', 'booking-resource');

        return view('booking-resource.create');
    }

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

        return redirect('booking-resource/summary/' . $rs->id);
    }

    public function show(Request $request)
    {
        $keyword = $request->get('search');
        $st_resource_id = $request->get('st_resource_id');
        $status = $request->get('status');

        $rs = BookingResource::select('*');
        $rs_all = $rs->get();

        if (!empty($st_resource_id)) {
            $rs = $rs->where('st_resource_id', $st_resource_id);
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        return view('include.__booking-resource-show', compact('rs', 'rs_all'))->withFrom('backend');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-resource-edit', 'booking-resource');

        $rs = BookingResource::findOrFail($id);

        return view('booking-resource.edit', compact('rs'));
    }

    public function update(BookingResourceRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $requestData['approve_by_id'] = Auth::user()->id;
        $requestData['approve_date'] = date('Y-m-d H:i:s');

        $rs = BookingResource::findOrFail($id);

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

        return redirect('booking-resource');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-resource-delete', 'booking-resource');

        BookingResource::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('booking-resource');
    }

    public function summary($id)
    {
        $rs = BookingResource::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('resource')->withFrom('backend');
    }

    public function sendEmailStatus($rs)
    {
        Mail::to($rs->request_email)->queue(new Status($rs->id, 'booking-resource'));
    }
}
