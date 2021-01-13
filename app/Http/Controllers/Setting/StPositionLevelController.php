<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StPositionLevelRequest;
use App\Model\StPositionLevel;
use Illuminate\Http\Request;

class StPositionLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-level-view');

        $rs = StPositionLevel::where(function ($q) use ($req) {
            if ($req->search) {
                $q->where('name', 'LIKE', "%$req->search%");
            }
        })->orderBy('id', 'desc')->paginate(10);

        return view('setting.st-position-level.index', compact('rs'));
    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-level-create', 'setting/st-position-level');

        return view('setting.st-position-level.create');
    }

    public function store(StPositionLevelRequest $request)
    {
        $requestData = $request->all();
        StPositionLevel::create($requestData);
        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/st-position-level');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-level-edit', 'setting/st-position-level');

        $rs = StPositionLevel::findOrFail($id);

        return view('setting.st-position-level.edit', compact('rs'));
    }

    public function update(StPositionLevelRequest $request, $id)
    {
        // dd($request->all());
        $requestData = $request->all();

        $rs = StPositionLevel::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/st-position-level');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-position-level-delete', 'setting/st-position-level');

        StPositionLevel::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-position-level');
    }
}
