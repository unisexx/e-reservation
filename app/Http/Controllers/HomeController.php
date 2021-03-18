<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::id());

        return view('profile', compact('user'));
    }

    public function profile_save(Request $request)
    {
        $this->validate($request, [
            'now_password'          => 'required|min:4',
            'password'              => 'required|min:4|confirmed|different:now_password',
            'password_confirmation' => 'required|min:4',
        ], [
            'now_password.required'          => 'รหัสผ่านปัจจุบัน ห้ามเป็นค่าว่าง',
            'now_password.min'               => 'รหัสผ่านปัจจุบัน อย่างน้อย 4 ตัวอักษร',
            'password.required'              => 'รหัสผ่านใหม่ ห้ามเป็นค่าว่าง',
            'password.min'                   => 'รหัสผ่านใหม่อย่างน้อย 4 ตัวอักษร',
            'password.different'             => 'รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านปัจจุบัน',
            'password.confirmed'             => 'รหัสผ่านกับยืนยันรหัสผ่านใหม่ ไม่ตรงกัน',
            'password_confirmation.required' => 'ยืนยันรหัสผ่านใหม่ ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();
        $now_password = $requestData['now_password'];
        if (Hash::check($now_password, Auth::user()->password)) {

            if ($requestData['password']) {
                $requestData['password'] = bcrypt($request->password);
            } else {
                unset($requestData['password']);
            }

            $user = User::findOrFail(Auth::id());
            $user->update($requestData);

            set_notify('success', 'เปลี่ยนรหัสผ่านใหม่สำเร็จ');

            return back();

        }
    }

    // public function test()
    // {
    //     $rs = DB::table('tmp_division')->whereNotNull('st_province_id')->get();
    //     foreach ($rs as $item) {
    //         DB::table('st_divisions')->where('code', $item->code)->update(array(
    //             'st_province_code' => $item->st_province_id,
    //         ));
    //     }
    // }
}
