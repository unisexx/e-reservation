<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\StRoomRequest;
use App\Model\ManageRoom;
use App\Model\StRoom;
use Auth;
use Illuminate\Http\Request;

class StRoomController extends Controller
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
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('st-room-view');

        $keyword = $request->get('search');

        $rs = StRoom::withCount('bookingRoom');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        if ($request->st_province_code) {
            $rs = $rs->where('st_province_code', $request->st_province_code);
        }

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (CanPerm('access-self')) {
            $rs = $rs->where('st_division_code', Auth::user()->st_division_code);
        }

        $stroom = $rs->orderBy('order', 'asc')->paginate(999);

        return view('setting.st-room.index', compact('stroom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('st-room-create', 'setting/st-room');

        return view('setting.st-room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StRoomRequest $request)
    {
        $requestData = $request->all();

        // ไฟล์แนบ
        // if ($request->hasFile('image')) {
        //     $imageName = time().'.'.request()->image->getClientOriginalExtension();
        //     request()->image->move(public_path('uploads/room/'), $imageName);

        //     $requestData['image'] = $imageName;
        // }

        // ไฟล์แนบหลายไฟล์
        if ($request->hasFile('image')) {
            $image = array();
            if ($files = $request->file('image')) {
                foreach ($files as $key => $file) {
                    $name = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/room/', $name);
                    $image[] = $name;
                }
            }
            $requestData['image'] = implode("|", $image);
        }

        // ถ้ามีการติ๊ก set default ให้เคลียร์ค่า set default ห้องทั้งหมดออกก่อน
        // if($request->is_default == 1){
        //     StRoom::query()->update(['is_default' => '0']);
        // }

        $stroom = StRoom::create($requestData);

        // บันทึกผู้จัดการห้อง
        if (isset($request->manage_room_user_id)) {
            foreach ($request->manage_room_user_id as $user_id) {
                ManageRoom::updateOrCreate(
                    [
                        'st_room_id'        => $stroom->id,
                        'user_id'           => $user_id,
                        'create_by_user_id' => Auth::user()->id,
                    ]
                );
            }
        }

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/st-room');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $stroom = StRoom::findOrFail($id);

        return view('setting.st-room.show', compact('stroom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-room-edit', 'setting/st-room');

        $stroom = StRoom::findOrFail($id);

        return view('setting.st-room.edit', compact('stroom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StRoomRequest $request, $id)
    {
        $requestData = $request->all();

        // dd($requestData['manage_room_user_id']);

        // ไฟล์แนบ
        // if ($request->hasFile('image')) {
        //     $imageName = time().'.'.request()->image->getClientOriginalExtension();
        //     request()->image->move(public_path('uploads/room/'), $imageName);

        //     $requestData['image'] = $imageName;
        // }

        // ไฟล์แนบหลายไฟล์
        if ($request->hasFile('image')) {
            $image = array();
            if ($files = $request->file('image')) {
                foreach ($files as $key => $file) {
                    $name = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/room/', $name);
                    $image[] = $name;
                }
            }
            $requestData['image'] = implode("|", $image);
        }

        // ถ้ามีการติ๊ก set default ให้เคลียร์ค่า set default ห้องทั้งหมดออกก่อน
        // if($request->is_default == 1){
        //     StRoom::query()->update(['is_default' => '0']);
        // }

        $stroom = StRoom::findOrFail($id);
        $stroom->update($requestData);

        // บันทึกผู้จัดการจองห้อง
        if (isset($request->manage_room_user_id)) {
            foreach ($request->manage_room_user_id as $user_id) {
                ManageRoom::updateOrCreate(
                    [
                        'st_room_id'        => $stroom->id,
                        'user_id'           => $user_id,
                        'create_by_user_id' => Auth::user()->id,
                    ]
                );
            }
        }

        // ลบผู้จัดการจองห้องที่ไม่ได้ถูกเลือกในฟอร์ม
        if (isset($request->manage_room_user_id)) {
            ManageRoom::where('st_room_id', $stroom->id)->whereNotIn('user_id', $request->manage_room_user_id)->delete();
        } else {
            ManageRoom::where('st_room_id', $stroom->id)->delete();
        }

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/st-room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('st-room-delete', 'setting/st-room');

        StRoom::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/st-room');
    }
}
