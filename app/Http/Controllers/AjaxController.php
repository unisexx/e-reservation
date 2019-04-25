<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\StBureau;
use App\Model\StDivision;
use App\Model\StRoom;
use App\Model\StVehicle;

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
        $rs = StRoom::where('status', '1')->where('name', 'like', '%' . $_GET['search'] . '%')->orderBy('id', 'asc')->get();

        return view('ajax.ajaxGetRoom', compact('rs'));
    }

    public function ajaxGetVehicle()
    {
        $rs = StVehicle::where('status', 'พร้อมใช้')
                ->where('brand', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('seat', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('color', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('reg_number', 'like', '%' . $_GET['search'] . '%')
                ->orWhereHas('st_driver',function($q){
                    $q->where('name', 'like', '%' . $_GET['search'] . '%');
                })
                ->orWhereHas('st_vehicle_type',function($q){
                    $q->where('name', 'like', '%' . $_GET['search'] . '%');
                })
                ->orderBy('id', 'asc')->get();

        // dd($rs);
        return view('ajax.ajaxGetVehicle', compact('rs'));
    }
}
