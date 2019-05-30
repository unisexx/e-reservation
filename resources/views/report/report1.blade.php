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

<h3>รายงานการใช้ห้องประชุม</h3>

<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('report1') }}" accept-charset="UTF-8" class="form-inline" role="search">

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

            <input type="text" class="form-control" style="width:370px;" placeholder="ชื่อห้องประชุม" name="search" value="{{ request('search') }}">

            วันที่ประชุม
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
        <th>ชื่อห้องประชุม</th>
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
        <td>{{ $row->name }}</td>
        <td>
            <?php 
                $start_date = request('start_date');
                $end_date = request('end_date');
                
                if(!empty($start_date) and !empty($end_date)){
                    $row = $row->bookingRoom->where('start_date', '>=', Date2DB($start_date))->where('start_date', '<=', Date2DB($end_date));
                }elseif(!empty($start_date) and empty($end_date)){
                    $row = $row->bookingRoom->where('start_date', Date2DB($start_date));
                }elseif(empty($start_date) and !empty($end_date)){
                    $row = $row->bookingRoom->where('start_date', Date2DB($end_date));
                }else{
                    $row = $row->bookingRoom;
                }
            ?>
            <div>รออนุมัติ [{{ $row->where('status','รออนุมัติ')->count() }}]</div>
            <div>อนุมัติ [{{ $row->where('status','อนุมัติ')->count() }}]</div>
            <div>ไม่อนุมัติ [{{ $row->where('status','ไม่อนุมัติ')->count() }}]</div>
            <div>ยกเลิก [{{ $row->where('status','ยกเลิก')->count() }}]</div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection