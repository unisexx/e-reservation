<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingBossRequest;
use App\Mail\Summary;
use App\Model\BookingBoss;
use Auth;
use Illuminate\Http\Request;
use Mail;

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

            if ($req->date_type) {
                if ($req->date_type == 'start_date') {
                    $q->where('start_date', Date2DB($req->date_select));
                } elseif ($req->date_type == 'end_date') {
                    $q->where('end_date', Date2DB($req->date_select));
                }
            }

            if ($req->status) {
                $q->where('status', $req->status);
            }

            // ถ้ามีสิทธิ์ดูแลผู้บริหาร จะสามารถเห็นรายการจองเฉพาะผู้บริหารที่ตัวเองดูแลเท่านั้น
            if (CanPerm('boss-manager')) {
                $q->whereHas('stBoss', function ($r) {
                    $r->whereHas('stBossRes', function ($s) {
                        $s->where('user_id', @Auth::user()->id);
                    });
                });
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
        if ($requestData['self_booking'] == 1) {
            $requestData['booking_user_id'] = @Auth::user()->id;
        } else {
            $requestData['booking_user_id'] = '';
        }
        $rs = BookingBoss::create($requestData);

        // รหัสการจอง
        $this->genCode($rs);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-boss/summary/' . $rs->id);
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
        // dd($requestData['self_booking']);
        $requestData['start_date'] = Date2DB($req->start_date);
        $requestData['end_date'] = Date2DB($req->end_date);
        if ($requestData['self_booking'] == 1) {
            $requestData['booking_user_id'] = @Auth::user()->id;
        } else {
            $requestData['booking_user_id'] = null;
        }

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
        if ($email == 1) {
            $this->sendEmail($rs);
        }
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

            if ($req->st_boss_id) {
                $q->where('st_boss_id', $req->st_boss_id);
            }

            if ($req->search) {
                $q->where(function ($q) use ($req) {
                    $q->where('code', 'like', '%' . $req->search . '%')
                        ->orWhere('title', 'like', '%' . $req->search . '%')
                        ->orWhere('room_name', 'like', '%' . $req->search . '%')
                        ->orWhereHas('stBoss', function ($q) use ($req) {
                            $q->where('name', 'like', '%' . $req->search . '%');
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

    public function sendEmail($rs)
    {
        $recipient = [$rs->request_email];
        Mail::to($recipient)->queue(new Summary($rs->id, 'booking-boss', 'update'));
    }

    public function testEmail($id)
    {
        $rs = BookingBoss::findOrFail($id);
        $this->sendEmail($rs);
    }

    public function summary($id)
    {
        $rs = BookingBoss::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('boss')->withFrom('backend');
    }
}
