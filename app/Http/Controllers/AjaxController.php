<?php

namespace App\Http\Controllers;

use App\Model\BookingResource;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use App\Model\StBureau;
use App\Model\StDivision;
use App\Model\StDriver;
use App\Model\StRoom;
use App\Model\StVehicle;
use Auth;
use DB;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function ajaxRequest()
    {
        return view('ajax.magicsuggest');
    }

    public function ajaxGetBureau()
    {
        $data['rs'] = StBureau::where('code', 'like', $_GET['st_department_code'] . '%')->orderBy('code', 'asc')->get();

        return $data['rs'];
    }

    public function ajaxGetDivision()
    {
        $data['rs'] = StDivision::where('code', 'like', $_GET['st_bureau_code'] . '%')->orderBy('code', 'asc')->get();

        return $data['rs'];
    }

    public function ajaxGetBureauVehicle()
    {
        $data['rs'] = StVehicle::select('st_bureau_code')->where('st_department_code', 'like', $_GET['st_department_code'] . '%')->where('status', 'พร้อมใช้')->with('bureau')->distinct()->orderBy('st_bureau_code', 'asc')->get();

        return $data['rs'];
    }

    public function ajaxGetDivisionVehicle()
    {
        $data['rs'] = StVehicle::select('st_division_code')->where('st_bureau_code', 'like', $_GET['st_bureau_code'] . '%')->where('status', 'พร้อมใช้')->with('division')->distinct()->orderBy('st_division_code', 'asc')->get();

        return $data['rs'];
    }

    public function ajaxGetRoom()
    {
        $rs = StRoom::select('*')->where('status', '1');

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (!Auth::guest()) {
            if (CanPerm('access-self')) {
                $rs = $rs->where('st_division_code', Auth::user()->st_division_code);
            }
        }

        if (!empty($_GET['search'])) {
            $rs = $rs->where('name', 'like', '%' . $_GET['search'] . '%');
        }

        if (!empty($_GET['depertment_code'])) {
            $rs = $rs->where('st_department_code', $_GET['depertment_code']);
        }

        if (!empty($_GET['bureau_code'])) {
            $rs = $rs->where('st_bureau_code', $_GET['bureau_code']);
        }

        $rs = $rs->orderBy('id', 'asc')->get();

        return view('ajax.ajaxGetRoom', compact('rs'));
    }

    public function ajaxGetVehicle()
    {
        $rs = StVehicle::select('*')->where('status', 'พร้อมใช้');

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if (!Auth::guest()) {
            if (CanPerm('access-self')) {
                $rs = $rs->where('st_division_code', Auth::user()->st_division_code);
            }
        }

        $rs = $rs->where(function ($q) {
            $q->where('brand', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('seat', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('color', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('reg_number', 'like', '%' . $_GET['search'] . '%')
                ->orWhereHas('st_driver', function ($q) {
                    $q->where('name', 'like', '%' . $_GET['search'] . '%');
                })
                ->orWhereHas('st_vehicle_type', function ($q) {
                    $q->where('name', 'like', '%' . $_GET['search'] . '%');
                });
        });

        if (!empty($_GET['depertment_code'])) {
            $rs = $rs->where('st_department_code', $_GET['depertment_code']);
        }

        if (!empty($_GET['bureau_code'])) {
            $rs = $rs->where('st_bureau_code', $_GET['bureau_code']);
        }

        if (!empty($_GET['req_st_department_code'])) {
            $rs = $rs->where('st_department_code', $_GET['req_st_department_code']);
        }

        if (!empty($_GET['req_st_bureau_code'])) {
            $rs = $rs->where('st_bureau_code', $_GET['req_st_bureau_code']);
        }

        if (!empty($_GET['req_st_division_code'])) {
            $rs = $rs->where('st_division_code', $_GET['req_st_division_code']);
        }

        $rs = $rs->orderBy('id', 'asc')->get();

        // dd($rs);
        return view('ajax.ajaxGetVehicle', compact('rs'));
    }

    public function ajaxRoomChkOverlap()
    {
        $st_room_id = $_GET['st_room_id'];
        $start_date = Date2DB($_GET['start_date']);
        $end_date = Date2DB($_GET['end_date']);
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $id = $_GET['id'];

        $rs = BookingRoom::select('*')->where('st_room_id', $st_room_id)
            ->where(function ($q) use ($start_date, $end_date) {
                $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date, $start_date, $end_date, $end_date]);
            })
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time, $start_time, $end_time, $end_time]);
            });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id', '<>', $id);
        }

        $rs = $rs->get();

        // dump($rs);

        if ($rs->count() >= 1) {
            return view('ajax.ajaxRoomChkOverlap', compact('rs'));
        } else {
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxVehicleChkOverlap()
    {
        $st_vehicle_id          = @$_GET['st_vehicle_id'];
        $start_date             = Date2DB($_GET['start_date']);
        $end_date               = Date2DB($_GET['end_date']);
        $start_time             = $_GET['start_time'];
        $end_time               = $_GET['end_time'];
        $req_st_department_code = @$_GET['req_st_department_code'];
        $req_st_bureau_code     = @$_GET['req_st_bureau_code'];
        $req_st_division_code   = @$_GET['req_st_division_code'];
        $id                     = $_GET['id'];

        $rs = BookingVehicle::select('*');

        if (!empty($st_vehicle_id)) {
            $rs = $rs->where('st_vehicle_id', $st_vehicle_id);
        }

        if (!empty($req_st_department_code)) {
            $rs = $rs->where('req_st_department_code', $req_st_department_code);
        }

        if (!empty($req_st_bureau_code)) {
            $rs = $rs->where('req_st_bureau_code', $req_st_bureau_code);
        }

        if (!empty($req_st_division_code)) {
            $rs = $rs->where('req_st_division_code', $req_st_division_code);
        }
        
        $rs = $rs->where(function ($q) use ($start_date, $end_date) {
                $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date, $start_date, $end_date, $end_date]);
            })
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time, $start_time, $end_time, $end_time]);
            });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id', '<>', $id);
        }

        $rs = $rs->get();

        if ($rs->count() >= 1) {
            return view('ajax.ajaxVehicleChkOverlap', compact('rs'));
        } else {
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxResourceChkOverlap()
    {
        $st_resource_id = $_GET['st_resource_id'];
        $start_date = Date2DB($_GET['start_date']);
        $end_date = Date2DB($_GET['end_date']);
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $id = $_GET['id'];

        $rs = BookingResource::select('*')
            ->where('st_resource_id', $st_resource_id)
            ->where(function ($q) use ($start_date, $end_date) {
                $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date, $start_date, $end_date, $end_date]);
            })
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time, $start_time, $end_time, $end_time]);
            });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id', '<>', $id);
        }

        $rs = $rs->get();

        if ($rs->count() >= 1) {
            return view('ajax.ajaxResourceChkOverlap', compact('rs'));
        } else {
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxGetBookingRoom()
    {
        $data['rs'] = BookingRoom::where('code', $_GET['search'])->first();

        return $data['rs'];
    }

    public function ajaxGetDriver()
    {
        $st_department_code = $_GET['st_department_code'];
        $st_bureau_code = $_GET['st_bureau_code'];
        $st_division_code = $_GET['st_division_code'];

        $rs = StDriver::select('*');

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($st_bureau_code)) {
            $rs = $rs->where('st_bureau_code', $st_bureau_code);
        }

        if (!empty($st_division_code)) {
            $rs = $rs->where('st_division_code', $st_division_code);
        }

        $data['rs'] = $rs->get();

        return $data['rs'];
    }

    public function ajaxSetDefaultRoom(){
        DB::table('st_rooms')->update(['is_default' => 0]);
        DB::table('st_rooms')->where('id', $_GET['id'])->update(['is_default' => 1]);
    }
}
