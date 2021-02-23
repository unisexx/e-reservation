<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StPositionMeetingRequest;
use App\Model\StPositionMeeting;
use Illuminate\Http\Request;

class StPositionMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-meeting-view');

        $rs = StPositionMeeting::where(function ($q) use ($req) {
            if ($req->search) {
                $q->where('name', 'LIKE', "%$req->search%");
            }
        })->orderBy('id', 'desc')->paginate(10);

        return view('setting.st-position-meeting.index', compact('rs'));
    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-meeting-create', 'setting/st-position-meeting');

        return view('setting.st-position-meeting.create');
    }

    public function store(StPositionMeetingRequest $request)
    {
        $requestData = $request->all();
        StPositionMeeting::create($requestData);
        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/st-position-meeting');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-meeting-edit', 'setting/st-position-meeting');

        $rs = StPositionMeeting::findOrFail($id);

        return view('setting.st-position-meeting.edit', compact('rs'));
    }

    public function update(StPositionMeetingRequest $request, $id)
    {
        // dd($request->all());
        $requestData = $request->all();

        $rs = StPositionMeeting::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/st-position-meeting');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-meeting-delete', 'setting/st-position-meeting');

        StPositionMeeting::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-position-meeting');
    }
}
