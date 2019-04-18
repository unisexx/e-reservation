<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\StBureau;
use App\Model\StDivision;

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

    public function ajaxGetBureau(){
        $data['rs'] = StBureau::where('code','like', $_GET['st_department_code'].'%')->orderBy('code','asc')->get();

        return $data['rs'];
    }

    public function ajaxGetDivision(){
        $data['rs'] = StDivision::where('code','like', $_GET['st_bureau_code'].'%')->orderBy('code','asc')->get();

        return $data['rs'];
    }
}
