<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\StBureau;
use App\Model\StDivision;
use App\Model\StRoom;
use App\Model\StVehicle;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;

use DB;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function report1(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('report-1-view');

        // DB::enableQueryLog();

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = StRoom::select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if(!empty($start_date) and !empty($end_date)){
            $rs = $rs->WhereHas('bookingRoom', function($q) use ($start_date, $end_date){
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        }elseif(!empty($start_date) and empty($end_date)){
            $rs = $rs->WhereHas('bookingRoom', function($q) use ($start_date){
                $q->where('start_date', Date2DB($start_date));
            });
        }elseif(empty($start_date) and !empty($end_date)){
            $rs = $rs->WhereHas('bookingRoom', function($q) use ($end_date){
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id','desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report1', compact('rs'));
    }

    public function report1_detail(Request $request){
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_room_id = $request->get('st_room_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingRoom::select('*');

        // if (!empty($keyword)) {
        //     $rs = $rs->where('name', 'LIKE', "%$keyword%");
        // }

        // if (!empty($st_department_code)) {
        //     $rs = $rs->where('st_department_code', $st_department_code);
        // }

        if (!empty($st_room_id)) {
            $rs = $rs->where('st_room_id', $st_room_id);
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        if(!empty($start_date) and !empty($end_date)){
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        }elseif(!empty($start_date) and empty($end_date)){
            $rs = $rs->where('start_date', Date2DB($start_date));
        }elseif(empty($start_date) and !empty($end_date)){
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id','desc')->get();

        return view('report.report1_detail', compact('rs'));
    }

    public function report2(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('report-2-view');

        // DB::enableQueryLog();

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = StVehicle::select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('brand', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if(!empty($start_date) and !empty($end_date)){
            $rs = $rs->WhereHas('bookingVehicle', function($q) use ($start_date, $end_date){
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        }elseif(!empty($start_date) and empty($end_date)){
            $rs = $rs->WhereHas('bookingVehicle', function($q) use ($start_date){
                $q->where('start_date', Date2DB($start_date));
            });
        }elseif(empty($start_date) and !empty($end_date)){
            $rs = $rs->WhereHas('bookingVehicle', function($q) use ($end_date){
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id','desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report2', compact('rs'));
    }

    public function report2_detail(Request $request){
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_vehicle_id = $request->get('st_vehicle_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingVehicle::select('*');

        // if (!empty($keyword)) {
        //     $rs = $rs->where('name', 'LIKE', "%$keyword%");
        // }

        // if (!empty($st_department_code)) {
        //     $rs = $rs->where('st_department_code', $st_department_code);
        // }

        if (!empty($st_vehicle_id)) {
            $rs = $rs->where('st_vehicle_id', $st_vehicle_id);
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        if(!empty($start_date) and !empty($end_date)){
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        }elseif(!empty($start_date) and empty($end_date)){
            $rs = $rs->where('start_date', Date2DB($start_date));
        }elseif(empty($start_date) and !empty($end_date)){
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id','desc')->get();

        return view('report.report2_detail', compact('rs'));
    }
}
