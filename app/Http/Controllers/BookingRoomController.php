<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\BookingRoom;

use App\Http\Requests\BookingRoomRequest;

class BookingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-view');

        $keyword = $request->get('search');
        $data_type = $request->get('date_type');
        $date_select = $request->get('date_select');
        $perPage = 10;

        $rs = BookingRoom::select('*');

        if (!empty($date_select)) {
            if($data_type == 'start_date'){
                $rs = $rs->where('start_date',Date2DB($date_select));
            }elseif($data_type == 'end_date'){
                $rs = $rs->where('end_date',Date2DB($date_select));
            }
        }

        if (!empty($keyword)) {
            $rs = $rs->where(function($q) use ($keyword){
                $q->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('title', 'LIKE', "%$keyword%")
                    ->orWhere('request_name', 'LIKE', "%$keyword%");
            });
        }

        if (@$_GET['export'] == 'excel') {

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=จองห้องประชุม_".date('Ymdhis').".xls");  //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            $rs = $rs->orderBy('id','desc')->get();
            return view('booking-room.index', compact('rs'));

        } else {

            $rs = $rs->orderBy('id','desc')->paginate($perPage);
            return view('booking-room.index', compact('rs'));

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-create', 'booking-room');

        return view('booking-room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRoomRequest $request)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        $data = BookingRoom::create($requestData);

        // อัพเดทรหัสการจอง โดยเอา ไอดี มาคำนวน
        $rs = BookingRoom::find($data->id);
        $rs->code = 'RR'.sprintf("%05d", $data->id);
        $rs->save();
        

        set_notify('success', 'บันทึกข้อมูลสำเร็จ');
        return redirect('booking-room');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $rs = BookingRoom::select('*');
        $rs = $rs->orderBy('id','desc')->get();
        return view('booking-room.show', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-edit','booking-room');

        $rs = BookingRoom::findOrFail($id);
        return view('booking-room.edit', compact('rs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookingRoomRequest $request, $id)
    {
        $requestData = $request->all();
        $requestData['start_date'] = Date2DB($request->start_date);
        $requestData['end_date'] = Date2DB($request->end_date);
        
        $rs = BookingRoom::findOrFail($id);
        $rs->update($requestData);

        set_notify('success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect('booking-room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // ตรวจสอบ permission
        ChkPerm('booking-room-delete','booking-room');

        BookingRoom::destroy($id);

        set_notify('success', 'ลบข้อมูลสำเร็จ');
        return redirect('booking-room');
    }
}
