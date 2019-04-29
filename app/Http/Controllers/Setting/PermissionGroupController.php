<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\PermissionGroup;
use App\Model\PermissionRole;

use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        // ChkPerm('permission-group-view');

        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $permissiongroup = PermissionGroup::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $permissiongroup = PermissionGroup::latest()->paginate($perPage);
        }

        return view('setting.permission-group.index', compact('permissiongroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('permission-group-create', 'setting/permission-group');
        
        return view('setting.permission-group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
		], [
            'title.required' => 'ชื่อสิทธิ์การใช้งาน ห้ามเป็นค่าว่าง'
        ]);

        $requestData = $request->all();
        $permissiongroup = PermissionGroup::create($requestData);

        /** 
         * บันทึกสิทธิ์การใช้งาน
         * */
        if(isset($request->pm)){
            foreach($request->pm as $key => $value){
                $pm = new PermissionRole;
                $pm->permission_group_id = $permissiongroup->id;
                $pm->permission_id  = $value;
                $pm->save();
            }
        }

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('setting/permission-group');
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
        $permissiongroup = PermissionGroup::findOrFail($id);

        return view('setting.permission-group.show', compact('permissiongroup'));
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
        ChkPerm('permission-group-edit', 'setting/permission-group');

        $permissiongroup = PermissionGroup::findOrFail($id);

        return view('setting.permission-group.edit', compact('permissiongroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
		], [
            'title.required' => 'ชื่อสิทธิ์การใช้งาน ห้ามเป็นค่าว่าง'
        ]);

        $requestData = $request->all();

        $permissiongroup = PermissionGroup::findOrFail($id);
        $permissiongroup->update($requestData);

        /**
         * ลบทั้งหมดออกแล้วบันทึกใหม่
         */
        PermissionRole::where('permission_group_id',$permissiongroup->id)->delete();

        /** 
         * บันทึกสิทธิ์การใช้งาน
         * */
        if(isset($request->pm)){
            foreach($request->pm as $key => $value){
                $pm = new PermissionRole;
                $pm->permission_group_id = $permissiongroup->id;
                $pm->permission_id  = $value;
                $pm->save();
            }
        }

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('setting/permission-group');
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
        ChkPerm('permission-group-delete', 'setting/permission-group');

        PermissionGroup::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/permission-group');
    }
}
