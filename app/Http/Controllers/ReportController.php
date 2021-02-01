<?php

namespace App\Http\Controllers;

use App\Model\BookingBoss;
use App\Model\BookingResource;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use App\Model\StBoss;
use App\Model\StResource;
use App\Model\StRoom;
use App\Model\StVehicle;
use DB;
use Illuminate\Http\Request;

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

        $rs = StRoom::with('bookingRoom', 'department', 'bureau', 'division')->select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingRoom', function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->WhereHas('bookingRoom', function ($q) use ($start_date) {
                $q->where('start_date', Date2DB($start_date));
            });
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingRoom', function ($q) use ($end_date) {
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report1', compact('rs'));
    }

    public function report1_detail(Request $request)
    {
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_room_id = $request->get('st_room_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingRoom::with('st_room', 'department', 'bureau', 'division')->select('*');

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

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($start_date));
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id', 'desc')->get();

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

        $rs = StVehicle::with('bookingVehicle', 'department', 'bureau', 'division', 'st_vehicle_type')->select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('brand', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingVehicle', function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->WhereHas('bookingVehicle', function ($q) use ($start_date) {
                $q->where('start_date', Date2DB($start_date));
            });
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingVehicle', function ($q) use ($end_date) {
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report2', compact('rs'));
    }

    public function report2_detail(Request $request)
    {
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_vehicle_id = $request->get('st_vehicle_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingVehicle::with('st_vehicle', 'department', 'bureau', 'division')->select('*');

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

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($start_date));
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        return view('report.report2_detail', compact('rs'));
    }

    // booking resource
    public function report3(Request $request)
    {
        // ตรวจสอบ permission
        ChkPerm('report-3-view');

        // DB::enableQueryLog();

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = StResource::with('bookingResource', 'department', 'bureau', 'division')->select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingResource', function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->WhereHas('bookingResource', function ($q) use ($start_date) {
                $q->where('start_date', Date2DB($start_date));
            });
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingResource', function ($q) use ($end_date) {
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report3', compact('rs'));
    }

    public function report3_detail(Request $request)
    {
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_resource_id = $request->get('st_resource_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingResource::with('approver.prefix', 'stResource', 'department', 'bureau', 'division')->select('*');

        if (!empty($st_resource_id)) {
            $rs = $rs->where('st_resource_id', $st_resource_id);
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($start_date));
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        return view('report.report3_detail', compact('rs'));
    }

    // booking boss
    public function report4(Request $request)
    {
        DB::enableQueryLog();

        // ตรวจสอบ permission
        ChkPerm('report-4-view');

        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = StBoss::with('bookingBoss', 'department', 'bureau', 'division')->select('*');

        if (!empty($keyword)) {
            $rs = $rs->where('name', 'LIKE', "%$keyword%");
        }

        if (!empty($st_department_code)) {
            $rs = $rs->where('st_department_code', $st_department_code);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingBoss', function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
            });
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->WhereHas('bookingBoss', function ($q) use ($start_date) {
                $q->where('start_date', Date2DB($start_date));
            });
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->WhereHas('bookingBoss', function ($q) use ($end_date) {
                $q->where('start_date', Date2DB($end_date));
            });
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        // dd(DB::getQueryLog());

        return view('report.report4', compact('rs'));
    }

    public function report4_detail(Request $request)
    {
        $keyword = $request->get('search');
        $st_department_code = $request->get('st_department_code');
        $status = $request->get('status');
        $st_boss_id = $request->get('st_boss_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $rs = BookingBoss::with('approver.prefix', 'stBoss', 'department', 'bureau', 'division')->select('*');

        if (!empty($st_boss_id)) {
            $rs = $rs->where('st_boss_id', $st_boss_id);
        }

        if (!empty($status)) {
            $rs = $rs->where('status', $status);
        }

        if (!empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
        } elseif (!empty($start_date) and empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($start_date));
        } elseif (empty($start_date) and !empty($end_date)) {
            $rs = $rs->where('start_date', Date2DB($end_date));
        }

        $rs = $rs->orderBy('id', 'desc')->get();

        return view('report.report4_detail', compact('rs'));
    }
}
