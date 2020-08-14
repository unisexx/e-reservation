<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Model\ManageResource;
use App\Model\ManageRoom;
use App\User;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
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
        // DB::enableQueryLog();

        // ตรวจสอบ permission
        ChkPerm('user-view');

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $st_bureau_code = $request->get('st_bureau_code');
        $permission_group_id = $request->get('permission_group_id');

        $rs = User::select('*');

        if (!empty($keyword)) {
            $rs = $rs->where(function ($q) use ($keyword) {
                $q = $q->where(DB::raw('CONCAT_WS(" ", givename, middlename, familyname)'), 'LIKE', "%$keyword%");
                $q = $q->orWhere('idcard', 'LIKE', "%$keyword%");
            });
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($st_bureau_code)) {
            $rs = $rs->where('st_bureau_code', $st_bureau_code);
        }

        if (!empty($permission_group_id)) {
            $rs = $rs->where('permission_group_id', $permission_group_id);
        }

        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=ผู้ใช้งาน_" . date('Ymdhis') . ".xls"); //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);

            $user = $rs->orderBy('id', 'desc')->get();

            return view('setting.user.index', compact('user'));

        } else {

            $user = $rs->orderBy('id', 'desc')->paginate(10);

            return view('setting.user.index', compact('user'));

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('user-create', 'setting/user');

        return view('setting.user.create');
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
            // 'name'                => 'required',
            'st_prefix_code'      => 'required',
            'idcard'              => 'required',
            'st_department_code'  => 'required',
            'st_bureau_code'      => 'required',
            'st_division_code'    => 'required',
            'permission_group_id' => 'required',
            'email'               => 'required|unique:users',
            'password'            => 'required',
            'confirm_password'    => 'same:password',
            'givename'            => 'required',
            'familyname'          => 'required',
        ], [
            // 'name.required'                => 'ชื่อ-สกุลผู้ใช้งาน ห้ามเป็นค่าว่าง',
            'st_prefix_code.required'      => 'คำนำหน้าชื่อ ห้ามเป็นค่าว่าง',
            'idcard.required'              => 'เลขบัตรประชาชน ห้ามเป็นค่าว่าง',
            'st_department_code.required'  => 'หน่วยงาน ห้ามเป็นค่าว่าง',
            'permission_group_id.required' => 'สิทธิ์การใช้งาน ห้ามเป็นค่าว่าง',
            'email.required'               => 'อีเมล์ ห้ามเป็นค่าว่าง',
            'email.unique'                 => 'อีเมล์นี้ถูกใช้แล้ว',
            'password.required'            => 'Password ห้ามเป็นค่าว่าง',
            'confirm_password.same'        => 'Confirm Password ต้องเหมือนกับ Password',
            'st_department_code.required'  => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'      => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'    => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'givename.required'            => 'ชื่อตัว ห้ามเป็นค่าว่าง',
            'familyname.required'          => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        if ($requestData['password']) {
            $requestData['password'] = bcrypt($request->password);
        }

        if ($requestData['idcard']) {
            $requestData['idcard'] = str_replace("-", "", $request->idcard);
        }

        $user = User::create($requestData);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');

        return redirect('setting/user');
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
        $user = User::findOrFail($id);

        return view('setting.user.show', compact('user'));
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
        ChkPerm('user-edit', 'setting/user');

        $user = User::findOrFail($id);

        return view('setting.user.edit', compact('user'));
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
            // 'name'                => 'required',
            'st_prefix_code'      => 'required',
            'idcard'              => 'required',
            'st_department_code'  => 'required',
            'permission_group_id' => 'required',
            'email'               => 'required|unique:users,email,' . $id . ',id',
            'confirm_password'    => 'same:password',
            'st_department_code'  => 'required',
            'st_bureau_code'      => 'required',
            'st_division_code'    => 'required',
            'givename'            => 'required',
            'familyname'          => 'required',
        ], [
            // 'name.required'                => 'ชื่อ-สกุลผู้ใช้งาน ห้ามเป็นค่าว่าง',
            'st_prefix_code.required'      => 'คำนำหน้าชื่อ ห้ามเป็นค่าว่าง',
            'idcard.required'              => 'เลขบัตรประชาชน ห้ามเป็นค่าว่าง',
            'st_department_code.required'  => 'หน่วยงาน ห้ามเป็นค่าว่าง',
            'permission_group_id.required' => 'สิทธิ์การใช้งาน ห้ามเป็นค่าว่าง',
            'email.required'               => 'อีเมล์ ห้ามเป็นค่าว่าง',
            'email.unique'                 => 'อีเมล์นี้ถูกใช้แล้ว',
            'confirm_password.same'        => 'Confirm Password ต้องเหมือนกับ Password',
            'st_department_code.required'  => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required'      => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required'    => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'givename.required'            => 'ชื่อตัว ห้ามเป็นค่าว่าง',
            'familyname.required'          => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        if ($requestData['password']) {
            $requestData['password'] = bcrypt($request->password);
        } else {
            unset($requestData['password']);
        }

        if ($requestData['idcard']) {
            $requestData['idcard'] = str_replace("-", "", $request->idcard);
        }

        $user = User::findOrFail($id);

        /**
         * ถ้ามีการเปลี่ยนแปลง permission_group_id ให้ เคลียร์ค่า manage_room, manage_resource
         * ถ้าไม่เคลียร์จะทำให้เห็นห้องกับทรัพยากรตามที่ถูกตั้งค่าไว้ตอนอยู่สิทธิ์การใช้งานเก่า
         */
        $user->permission_group_id = $request->permission_group_id;
        // dd($user->isDirty('permission_group_id'));
        if ($user->isDirty('permission_group_id')) {
            ManageRoom::where('user_id', $id)->delete();
            ManageResource::where('user_id', $id)->delete();
        }

        $user->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');

        return redirect('setting/user')->with('flash_message', 'User updated!');
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
        ChkPerm('user-delete', 'setting/user');

        User::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');

        return redirect('setting/user')->with('flash_message', 'User deleted!');
    }
}
