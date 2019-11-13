<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use DB;

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

        $rs = User::select('*');

        if (!empty($keyword)) {
            $rs = $rs->where(DB::raw('CONCAT_WS(" ", givename, middlename, familyname)') , 'LIKE' , "%$keyword%");
        }

        $user = $rs->orderBy('id','desc')->paginate(10);

        // dd(DB::getQueryLog());

        return view('setting.user.index', compact('user'));
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
            'st_prefix_code' => 'required',
            'idcard' => 'required',
            'st_department_code' => 'required',
            'st_bureau_code' => 'required',
            'st_division_code' => 'required',
            'permission_group_id' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'same:password',
            'givename' => 'required',
            'familyname' => 'required',
        ], [
            // 'name.required'                => 'ชื่อ-สกุลผู้ใช้งาน ห้ามเป็นค่าว่าง',
            'st_prefix_code.required' => 'คำนำหน้าชื่อ ห้ามเป็นค่าว่าง',
            'idcard.required' => 'เลขบัตรประชาชน ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'หน่วยงาน ห้ามเป็นค่าว่าง',
            'permission_group_id.required' => 'สิทธิ์การใช้งาน ห้ามเป็นค่าว่าง',
            'email.required' => 'อีเมล์ ห้ามเป็นค่าว่าง',
            'email.unique' => 'อีเมล์นี้ถูกใช้แล้ว',
            'password.required' => 'Password ห้ามเป็นค่าว่าง',
            'confirm_password.same' => 'Confirm Password ต้องเหมือนกับ Password',
            'st_department_code.required' => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required' => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required' => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'givename.required' => 'ชื่อตัว ห้ามเป็นค่าว่าง',
            'familyname.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        if ($requestData['password']) {
            $requestData['password'] = bcrypt($request->password);
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
            'st_prefix_code' => 'required',
            'idcard' => 'required',
            'st_department_code' => 'required',
            'permission_group_id' => 'required',
            'email' => 'required|unique:users,email,' . $id . ',id',
            'confirm_password' => 'same:password',
            'st_department_code' => 'required',
            'st_bureau_code' => 'required',
            'st_division_code' => 'required',
            'givename' => 'required',
            'familyname' => 'required',
        ], [
            // 'name.required'                => 'ชื่อ-สกุลผู้ใช้งาน ห้ามเป็นค่าว่าง',
            'st_prefix_code.required' => 'คำนำหน้าชื่อ ห้ามเป็นค่าว่าง',
            'idcard.required' => 'เลขบัตรประชาชน ห้ามเป็นค่าว่าง',
            'st_department_code.required' => 'หน่วยงาน ห้ามเป็นค่าว่าง',
            'permission_group_id.required' => 'สิทธิ์การใช้งาน ห้ามเป็นค่าว่าง',
            'email.required' => 'อีเมล์ ห้ามเป็นค่าว่าง',
            'email.unique' => 'อีเมล์นี้ถูกใช้แล้ว',
            'confirm_password.same' => 'Confirm Password ต้องเหมือนกับ Password',
            'st_department_code.required' => 'กรมผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_bureau_code.required' => 'สำนักผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'st_division_code.required' => 'กลุ่มผู้ขอใช้ ห้ามเป็นค่าว่าง',
            'givename.required' => 'ชื่อตัว ห้ามเป็นค่าว่าง',
            'familyname.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        if ($requestData['password']) {
            $requestData['password'] = bcrypt($request->password);
        } else {
            unset($requestData['password']);
        }

        $user = User::findOrFail($id);
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
