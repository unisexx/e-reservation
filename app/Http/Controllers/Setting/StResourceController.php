<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\StResource;
use Illuminate\Http\Request;

use Auth;

class StResourceController extends Controller
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
        // ChkPerm('st-resource-view');

        $keyword = $request->get('search');

        $rs = StResource::select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (CanPerm('access-self')) {
            $rs = $rs->where('st_division_code',Auth::user()->st_division_code);
        }

        $rs = $rs->orderBy('id','desc')->paginate(10);


        return view('setting.st-resource.index', compact('rs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ตรวจสอบ permission
        // ChkPerm('st-resource-create', 'setting/st-resource');

        return view('setting.st-resource.create');
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
            'code'  =>  'required',
            'name'  =>  'required',
		], [
            'code.required' => 'รหัส ห้ามเป็นค่าว่าง',
            'name.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);
        
        $requestData = $request->all();
        
        StResource::create($requestData);

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('setting/st-resource');
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
        $rs = StResource::findOrFail($id);

        return view('setting.st-resource.show', compact('rs'));
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
        // ChkPerm('st-resource-edit','setting/st-resource');

        $rs = StResource::findOrFail($id);

        return view('setting.st-resource.edit', compact('rs'));
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
            'code'  =>  'required',
            'name'  =>  'required',
		], [
            'code.required' => 'รหัส ห้ามเป็นค่าว่าง',
            'name.required' => 'ชื่อสกุล ห้ามเป็นค่าว่าง',
        ]);

        $requestData = $request->all();

        $rs = StResource::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('setting/st-resource');
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
        // ChkPerm('st-resource-delete','setting/st-resource');

        StResource::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('setting/st-resource');
    }
}
