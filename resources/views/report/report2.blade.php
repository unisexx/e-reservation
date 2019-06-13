@extends(empty(request('export')) ? 'layouts.admin' : 'layouts.excel')

@section('content')

<?php
    $st_departments = App\Model\StDepartment::orderBy('code','asc')->get();

    if(request('st_department_code')){
        $st_bureaus = App\Model\StBureau::where('code','like',request('st_department_code').'%')->orderBy('code','asc')->get();
    }

    if(request('st_bureau_code')){
        $st_divisions = App\Model\StDivision::where('code','like',request('st_bureau_code').'%')->orderBy('code','asc')->get();
    }
?>

<h3>รายงานการใช้ยานพาหนะ</h3>

<?php
    $get = '';
    foreach (@$_GET as $key => $value) {
        $get .= ($get) ? '&'.$key.'='.$value : $key.'='.$value;
    }
?>

<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('report2') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_department_code" id="lunch" class="selectpicker" data-live-search="true" title="กรม">
                <option value="">+ กรม +</option>
                @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @request('st_department_code')) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
            </select>

            <!-- <select name="st_bureau_code" id="lunch" class="selectpicker" data-live-search="true" title="สำนัก">
                <option value="">+ สำนัก +</option>
                @if(request('st_department_code'))
                @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @request('st_bureau_code')) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
                @endif
            </select>

            <select name="st_division_code" id="lunch" class="selectpicker" data-live-search="true" title="กลุ่ม">
                <option value="">+ กลุ่ม +</option>
                @if(request('st_bureau_code'))
                @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
                @endif
            </select> -->

            <input type="text" class="form-control" style="width:370px;" placeholder="ยี่ห้อ" name="search" value="{{ request('search') }}">

            วันที่ไป
            <input name="start_date" type="text" class="form-control fdate datepicker" value="{{ request('start_date') }}" style="width:100px;" /> - 
            <input name="end_date" type="text" class="form-control fdate datepicker" value="{{ request('end_date') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ลำดับ</th>
        <th>ชื่อกรม</th>
        <th>ประเภท / ยี่ห้อ / ที่นั่ง / สี / เลขทะเบียน	</th>
        <th>สถานะ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rs as $key=>$row)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>
            {{ $row->department->title }} 
            <!-- >
            {{ $row->bureau->title }} >
            {{ $row->division->title }} -->
        </td>
        <td>
            <a href="{{ url('report2_detail?st_vehicle_id='.$row->id.'&'.$get) }}">
                {{$row->st_vehicle_type->name}} {{$row->brand}} {{!empty($row->seat)?$row->seat:'-'}} ที่นั่ง สี{{$row->color}} ทะเบียน {{$row->reg_number}}
            </a>
        </td>
        <td>
            <?php 
                $st_vehicle_id = $row->id;

                $start_date = request('start_date');
                $end_date = request('end_date');
                
                if(!empty($start_date) and !empty($end_date)){
                    $row = $row->bookingVehicle->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
                }elseif(!empty($start_date) and empty($end_date)){
                    $row = $row->bookingVehicle->where('start_date', Date2DB($start_date));
                }elseif(empty($start_date) and !empty($end_date)){
                    $row = $row->bookingVehicle->where('start_date', Date2DB($end_date));
                }else{
                    $row = $row->bookingVehicle;
                }
            ?>
            <div>
                รออนุมัติ 
                <a href="{{ url('report2_detail?st_vehicle_id='.$st_vehicle_id.'&status=รออนุมัติ&'.$get) }}">
                    [{{ $row->where('status','รออนุมัติ')->count() }}]
                </a>
            </div>
            <div>
                อนุมัติ 
                <a href="{{ url('report2_detail?st_vehicle_id='.$st_vehicle_id.'&status=อนุมัติ&'.$get) }}">
                    [{{ $row->where('status','อนุมัติ')->count() }}]
                </a>
            </div>
            <div>
                ไม่อนุมัติ 
                <a href="{{ url('report2_detail?st_vehicle_id='.$st_vehicle_id.'&status=ไม่อนุมัติ&'.$get) }}">
                    [{{ $row->where('status','ไม่อนุมัติ')->count() }}]
                </a>
            </div>
            <div>
                ยกเลิก 
                <a href="{{ url('report2_detail?st_vehicle_id='.$st_vehicle_id.'&status=ยกเลิก&'.$get) }}">
                    [{{ $row->where('status','ยกเลิก')->count() }}]
                </a>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection