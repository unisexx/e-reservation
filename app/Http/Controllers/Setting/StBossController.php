<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StBossRequest;
use App\Model\StBoss;
use App\Model\StBossRes;
use Illuminate\Http\Request;

class StBossController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        // ตรวจสอบ permission
        ChkPerm('st-boss-view');

        $rs = StBoss::where(function ($q) use ($req) {
            if ($req->search) {
                $q->where('name', 'LIKE', "%$req->search%");
            }
        })->orderBy('id', 'desc')->paginate(10);

        return view('setting.st-boss.index', compact('rs'));
    }

    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('st-boss-create', 'setting/st-boss');

        return view('setting.st-boss.create');
    }

    public function store(StBossRequest $request)
    {
        $requestData = $request->all();
        $rs = StBoss::create($requestData);

        // บันทึกสถานะ
        $this->saveRes($request, $rs);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/st-boss');
    }

    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-boss-edit', 'setting/st-boss');

        $rs = StBoss::findOrFail($id);

        return view('setting.st-boss.edit', compact('rs'));
    }

    public function update(StBossRequest $request, $id)
    {
        // dd($request->all());
        $requestData = $request->all();

        $rs = StBoss::findOrFail($id);
        $rs->update($requestData);

        // บันทึกสถานะ
        $this->saveRes($request, $rs);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/st-boss');
    }

    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-boss-delete', 'setting/st-boss');

        StBoss::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-boss');
    }

    public function saveRes(Request $request, $rs)
    {
        // ลบรายการ (ถ้ามี)
        if (isset($request->removeRes['id'])) {
            StBossRes::whereIn('id', $request->removeRes['id'])->delete();
        }

        if (is_array($request->res)):
            foreach ($request->res['res_name'] as $i => $item) {
                StBossRes::updateOrCreate(
                    [
                        'id' => @$request->res['id'][$i],
                    ],
                    [
                        'st_boss_id'         => $rs->id,
                        'res_name'           => @$item,
                        'res_tel'            => @$request->res['res_tel'][$i],
                        'st_department_code' => @$request->res['st_department_code'][$i],
                        'st_bureau_code'     => @$request->res['st_bureau_code'][$i],
                        'st_division_code'   => @$request->res['st_division_code'][$i],
                    ]
                );
            }
        endif;
    }
}
