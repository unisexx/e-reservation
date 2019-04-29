<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StRoom;
use Illuminate\Http\Request;

use App\Http\Requests\StRoomRequest;

class StRoomController extends Controller
{
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
        $perPage = 10;

        if (!empty($keyword)) {
            $stroom = StRoom::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $stroom = StRoom::latest()->paginate($perPage);
        }

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
        if ($request->hasFile('image')) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

            $requestData['image'] = $imageName;
        }
        
        StRoom::create($requestData);

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
        ChkPerm('st-room-edit','setting/st-room');

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

        // ไฟล์แนบ
        if ($request->hasFile('image')) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/room/'), $imageName);

            $requestData['image'] = $imageName;
        }
        
        $stroom = StRoom::findOrFail($id);
        $stroom->update($requestData);

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
        ChkPerm('st-room-delete','setting/st-room');

        StRoom::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-room');
    }
}
