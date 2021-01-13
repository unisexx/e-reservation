<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingBossRequest;
use App\Model\BookingBoss;
use Auth;
use Illuminate\Http\Request;

class BookingBossController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-boss-view');

        $rs_all = BookingBoss::get();

        $rs = BookingBoss::with('stBoss')->where(function ($q) use ($req) {

            if ($req->keyword) {
                $q->where(function ($q) use ($req) {
                    $q->where('code', 'like', '%' . $req->keyword . '%')
                        ->orWhere('title', 'like', '%' . $req->keyword . '%')
                        ->orWhere('room_name', 'like', '%' . $req->keyword . '%')
                        ->orWhereHas('stBoss', function ($q) use ($req) {
                            $q->where('name', 'like', '%' . $req->keyword . '%');
                        });
                });
            }

            if ($req->date_select) {
                if ($req->data_type == 'start_date') {
                    $q->where('start_date', Date2DB($req->date_select));
                } elseif ($req->data_type == 'end_date') {
                    $q->where('end_date', Date2DB($req->date_select));
                }
            }
        });

        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองวาระผู้บริหาร_" . date('Ymdhis') . ".xls"); //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);

            $rs = $rs->orderBy('id', 'desc')->get();

            return view('booking-boss.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id', 'desc')->paginate(10);

            return view('booking-boss.index', compact('rs', 'rs_all'));

        }
    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-boss-create', 'booking-boss');

        return view('booking-boss.create');
    }

    public function store(BookingBossRequest $req)
    {
        $requestData = $req->all();
        $requestData['start_date'] = Date2DB($req->start_date);
        $requestData['end_date'] = Date2DB($req->end_date);
        $rs = BookingBoss::create($requestData);

        // รหัสการจอง
        $this->genCode($rs);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-boss-front/summary/' . $rs->id);
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-boss-edit', 'booking-boss');

        $rs = BookingBoss::findOrFail($id);

        return view('booking-boss.edit', compact('rs'));
    }

    public function update(BookingBossRequest $req, $id)
    {
        $requestData = $req->all();
        $requestData['start_date'] = Date2DB($req->start_date);
        $requestData['end_date'] = Date2DB($req->end_date);

        $rs = BookingBoss::findOrFail($id);

        $email = 0;
        $rs->status = @$requestData['status'];
        if ($rs->isDirty('status')) {
            $email = 1; // ถ้าสถานะมีการเปลี่ยนแปลง ให้ทำการส่งอีเมล์แจ้งเตือน
            $requestData['approve_by_id'] = Auth::user()->id;
            $requestData['approve_date'] = date('Y-m-d H:i:s');
        }

        $rs->update($requestData);

        // ฟอร์มอีเมล์
        // if ($email == 1) {
        //     $this->sendEmailStatus($rs);
        // }
        //-- END ฟอร์มอีเมล์

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('booking-boss');
    }

    public function genCode($rs)
    {
        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingBoss::find($rs->id);
        $rs->code = 'BS' . sprintf("%05d", $rs->id);
        $rs->save();
    }

    // public function sendEmailStatus($rs)
    // {
    //     $recipient = [$rs->request_email, 'puwadon.k@m-society.go.th', 'tsd.ictc@m-society.go.th'];
    //     Mail::to($recipient)->queue(new Status($rs->id, 'booking-room'));
    // }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-boss-delete', 'booking-boss');

        BookingBoss::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('booking-boss');
    }

    public function show(Request $req)
    {
        $rs_all = BookingBoss::get();

        $rs = BookingBoss::with('stBoss')->where(function ($q) use ($req) {

            if ($req->keyword) {
                $q->where(function ($q) use ($req) {
                    $q->where('code', 'like', '%' . $req->keyword . '%')
                        ->orWhere('title', 'like', '%' . $req->keyword . '%')
                        ->orWhere('room_name', 'like', '%' . $req->keyword . '%')
                        ->orWhereHas('stBoss', function ($q) use ($req) {
                            $q->where('name', 'like', '%' . $req->keyword . '%');
                        });
                });
            }

            if ($req->date_select) {
                if ($req->data_type == 'start_date') {
                    $q->where('start_date', Date2DB($req->date_select));
                } elseif ($req->data_type == 'end_date') {
                    $q->where('end_date', Date2DB($req->date_select));
                }
            }
        })->get();

        return view('include.__booking-boss-show', compact('rs', 'rs_all'))->withFrom('backend');
    }
}
