<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingBossRequest;
// use App\Jobs\SendEmail;
use App\Mail\Summary;
use App\Model\BookingBoss;
use Illuminate\Http\Request;
use Mail;

class BookingBossFrontController extends Controller
{
    public function create()
    {
        return view('booking-boss-front.create');
    }

    public function store(BookingBossRequest $req)
    {
        $requestData = $req->all();
        $requestData['start_date'] = Date2DB($req->start_date);
        $requestData['end_date'] = Date2DB($req->end_date);
        $requestData['status'] = 'รออนุมัติ';
        $rs = BookingBoss::create($requestData);

        // รหัสการจอง
        $this->genCode($rs);

        // ส่งเมล์
        $this->sendEmail($rs);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('booking-boss-front/summary/' . $rs->id);
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

        return view('include.__booking-boss-show', compact('rs', 'rs_all'))->withFrom('frontend');
    }

    public function summary($id)
    {
        $rs = BookingBoss::findOrFail($id);

        return view('include.__booking-summary', compact('rs'))->withType('boss')->withFrom('frontend');
    }

    public function genCode($rs)
    {
        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingBoss::find($rs->id);
        $rs->code = 'BS' . sprintf("%05d", $rs->id);
        $rs->save();
    }

    // public function sendEmailSummary($rs)
    // {
    //     SendEmail::dispatch($rs->id, 'booking-boss');
    // }

    function print($id) {
        $rs = BookingBoss::with('st_room', 'division', 'bureau', 'department')->findOrFail($id);

        return view('include.__booking-print', compact('rs'))->withType('boss')->withFrom('frontend');
    }

    public function sendEmail($rs)
    {
        $recipient = [$rs->request_email];
        Mail::to($recipient)->queue(new Summary($rs->id, 'booking-boss', 'create'));
    }

    public function testEmail($id)
    {
        $rs = BookingBoss::findOrFail($id);
        $this->sendEmail($rs);
    }
}
