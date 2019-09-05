<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\StBureau;
use App\Model\StDivision;
use App\Model\StRoom;
use App\Model\StVehicle;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use App\Model\BookingResource;

use Auth;

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

    public function ajaxGetRoom()
    {
        $rs = StRoom::select('*')->where('status', '1');

        /**
         * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
         */
        if(!Auth::guest()){
            if (CanPerm('access-self')) {
                $rs = $rs->where('st_division_code',Auth::user()->st_division_code);
            }
        }

        if (!empty($_GET['search'])) {
            $rs = $rs->where('name', 'like', '%' . $_GET['search'] . '%');
        }

        if (!empty($_GET['depertment_code'])) {
            $rs = $rs->where('st_department_code',$_GET['depertment_code']);
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
        if(!Auth::guest()){
            if (CanPerm('access-self')) {
                $rs = $rs->where('st_division_code',Auth::user()->st_division_code);
            }
        }

        $rs = $rs->where(function($q){
                    $q->where('brand', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('seat', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('color', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('reg_number', 'like', '%' . $_GET['search'] . '%')
                    ->orWhereHas('st_driver',function($q){
                        $q->where('name', 'like', '%' . $_GET['search'] . '%');
                    })
                    ->orWhereHas('st_vehicle_type',function($q){
                        $q->where('name', 'like', '%' . $_GET['search'] . '%');
                    });
                });

        $rs = $rs->orderBy('id', 'asc')->get();

        // dd($rs);
        return view('ajax.ajaxGetVehicle', compact('rs'));
    }

    public function ajaxRoomChkOverlap(){
        $st_room_id = $_GET['st_room_id'];
        $start_date = Date2DB($_GET['start_date']);
        $end_date = Date2DB($_GET['end_date']);
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $id = $_GET['id'];

        $rs = BookingRoom::select('*')->where('st_room_id',$st_room_id)
                ->where(function($q) use ($start_date,$end_date){
                    $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date,$start_date,$end_date,$end_date]);
                })
                ->where(function($q) use ($start_time,$end_time){
                    $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time,$start_time,$end_time,$end_time]);
                });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id','<>',$id);
        }
                
        $rs = $rs->get();

        // dump($rs);
        
        if($rs->count() >= 1){
            return view('ajax.ajaxRoomChkOverlap', compact('rs'));
        }else{
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxVehicleChkOverlap(){
        $st_vehicle_id = $_GET['st_vehicle_id'];
        $start_date = Date2DB($_GET['start_date']);
        $end_date = Date2DB($_GET['end_date']);
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $id = $_GET['id'];

        $rs = BookingVehicle::select('*')
                ->where('st_vehicle_id',$st_vehicle_id)
                ->where(function($q) use ($start_date,$end_date){
                    $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date,$start_date,$end_date,$end_date]);
                })
                ->where(function($q) use ($start_time,$end_time){
                    $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time,$start_time,$end_time,$end_time]);
                });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id','<>',$id);
        }
                
        $rs = $rs->get();
        
        if($rs->count() >= 1){
            return view('ajax.ajaxVehicleChkOverlap', compact('rs'));
        }else{
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxResourceChkOverlap(){
        $st_resource_id = $_GET['st_resource_id'];
        $start_date = Date2DB($_GET['start_date']);
        $end_date = Date2DB($_GET['end_date']);
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $id = $_GET['id'];

        $rs = BookingResource::select('*')
                ->where('st_resource_id',$st_resource_id)
                ->where(function($q) use ($start_date,$end_date){
                    $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date,$start_date,$end_date,$end_date]);
                })
                ->where(function($q) use ($start_time,$end_time){
                    $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time,$start_time,$end_time,$end_time]);
                });

        if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
            $rs = $rs->where('id','<>',$id);
        }
                
        $rs = $rs->get();
        
        if($rs->count() >= 1){
            return view('ajax.ajaxResourceChkOverlap', compact('rs'));
        }else{
            return 'ไม่เหลื่อม';
        }
    }

    public function ajaxGetBookingRoom(){
        $data['rs'] = BookingRoom::where('code', $_GET['search'])->first();

        return $data['rs'];
    }
}
