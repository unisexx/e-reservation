@extends('layouts.print')
@section('content')
{{-- @dump($rs) --}}

@if($type == 'room')
<div class="text-center t22" style="margin-bottom:20px;">ใบขออนุญาตใช้ห้องประชุม</div>
<div>ห้องประชุมที่ต้องการใช้ <u>{{ $rs->st_room->name }}</u></div>
<div>วันเวลาที่ขอใช้ห้องประชุม ตั้งแต่วันที่ <u>{{ DB2Date($rs->start_date) }}</u> เวลา <u>{{ date("H:i", strtotime($rs->start_time)) }}</u> น. - ถึงวันที่ <u>{{ DB2Date($rs->end_date) }}</u> เวลา <u>{{ date("H:i", strtotime($rs->end_time)) }}</u> น.</div>
<div>ชื่อเรื่อง / หัวข้อการประชุม-อบรม <u>{{ $rs->title }}</u></div>
<div>ประธานการประชุม <u>{{ @$rs->president_name }} {{ @$rs->president_position }}</u></div>
<div>จำนวนผู้เข้าร่วมประชุม <u>{{ $rs->number }}</u> คน</div>
<div>ข้อมูลการติดต่อผู้ขอใช้ <u>{{ $rs->request_name }}</u>   ตำแหน่ง <u>{{ $rs->request_position }}</u></div>
<div>หน่วยงานที่ขอใช้	 <u>{{ $rs->division->title }} {{ $rs->bureau->title }} {{ $rs->department->title }}</u></div>
<div>โทรศัพท์ <u>{{ $rs->request_tel }}</u>    อีเมล์ <u>{{ $rs->request_email }}</u></div>
<div>หมายเหตุ <u>{{ isset($rs->note) ? $rs->note : '-' }}</u></div>

<div style="margin-top:50px;">
    <hr>
    <div><b>สำหรับเจ้าหน้าที่</b></div>

    <div style="width:50%; height:50px; float: left;">
        <div class="square" style="float: left; margin-right:10px;"></div> ยืนยันการใช้ห้อง
    </div>
    <div style="width:46%; float: left; padding-left:20px; border-left:1px solid #000;">
        <div class="square" style="float: left; margin-right:10px;"></div> ยกเลิกการใช้ห้อง
        <div>
            แจ้ง ณ วันที่ ............./.............../...................
        </div>
        <div>
            ผู้แจ้งยกเลิก ...................................................
        </div>
    </div>
</div>
@endif




@if($type == 'vehicle')
@php
    // ยานพาหนะตามหน่วยงาน
    $vehicles = App\Model\Stvehicle::select('*')->where('status', 'พร้อมใช้')
                ->where('st_department_code', $rs->req_st_department_code)
                ->where('st_bureau_code', $rs->req_st_bureau_code)
                ->where('st_division_code', $rs->req_st_division_code)
                ->orderBy('id', 'asc')->get();

    // พนักงานขับรถ
    $drivers = App\Model\StDriver::select('*')->where('status', 1)
                ->where('st_department_code', $rs->req_st_department_code)
                ->where('st_bureau_code', $rs->req_st_bureau_code)
                ->where('st_division_code', $rs->req_st_division_code)
                ->orderBy('id', 'asc')->get();
@endphp
<div class="text-center t22" style="margin-bottom:20px;">ใบขออนุญาตใช้รถยนต์</div>
<div class="text-center">วันที่ <u>{{ Carbon\Carbon::parse($rs->request_date)->format('d') }}</u> เดือน <u>{{ thMonth(Carbon\Carbon::parse($rs->request_date)->format('m')) }}</u> พ.ศ. <u>{{ Carbon\Carbon::parse($rs->request_date)->format('Y') + 543 }}</u></div>
<div>เรียน ผู้อำนวยการ<u>{{ $rs->bureauVehicle->title }}</u></div>
<div>ข้าพเจ้า	<u>{{ $rs->request_name }}</u>			ตำแหน่ง <u>{{ $rs->request_position }}</u></div>
<div>หน่วยงานที่ขอใช้	 <u>{{ $rs->division->title }} {{ $rs->bureau->title }} {{ $rs->department->title }}</u></div>
<div>โทรศัพท์ <u>{{ $rs->request_tel }}</u></div>
<div>ขออนุญาตใช้รถ(ไปไหน) <u>{{ isset($rs->destination) ? $rs->destination : '-' }}</u></div>
<div>เพื่อ <u>{{ isset($rs->gofor) ? $rs->gofor : '-' }}</u>	มีคนนั่ง	<u>{{ isset($rs->number) ? $rs->number : '-' }}</u>  คน</div>
<div>สถานที่ขึ้นรถ <u>{{ isset($rs->point_place) ? $rs->point_place : '-' }}</u>		เวลา <u>{{ isset($rs->point_time) ? date("H:i", strtotime($rs->point_time)) : '-' }}</u> น.</div>
<div>ในวันที่	<u>{{ isset($rs->start_date) ? DB2Date($rs->start_date) : '-' }}</u>	เวลา <u>{{ isset($rs->start_time) ? date("H:i", strtotime($rs->start_time)) : '-' }}</u> น.	ถึงวันที่	<u>{{ isset($rs->end_date) ? DB2Date($rs->end_date) : '-' }}</u>	เวลา <u>{{ isset($rs->end_time) ? date("H:i", strtotime($rs->end_time)) : '-' }}</u> น.</div>
<div>หมายเหตุ <u>{{ isset($rs->note) ? $rs->note : '-' }}</u></div>
<div class="text-right" style="margin-right:62px;">………………………………………………………………..ผู้ขออนุญาต</div>
<div class="text-right">………………………………………………………………..ผู้อำนวยการกลุ่ม/ฝ่าย</div>

<div style="margin-top:50px;">
    <hr>
    <div><b>สำหรับเจ้าหน้าที่</b></div>

    <div style="width:50%; height:50px; float: left;">
        <div>ยานพาหนะ</div>
        @foreach ($vehicles as $item)
            <div>
                <div class="square" style="float: left; margin-right:5px; margin-top:7px;"></div> 
                @if(isset($item->id))
                    {{ isset($item->st_vehicle_type->name) ? $item->st_vehicle_type->name : '-' }} 
                    {{ isset($item->brand) ? $item->brand : '-' }}
                    {{ isset($item->seat) ? $item->seat : '-' }} ที่นั่ง
                    สี {{ isset($item->color) ? $item->color : '-' }} 
                    ทะเบียน {{ isset($item->reg_number) ? $item->reg_number : '-' }}
                @else
                    -
                @endif
            </div>
        @endforeach
    </div>
    <div style="width:46%; float: left; padding-left:20px; border-left:1px solid #000;">
        <div>พนักงานขับรถ</div>
        @foreach ($drivers as $item)
            <div>
                <div class="square" style="float: left; margin-right:5px; margin-top:7px;"></div> {{ $item->name }}
            </div>
        @endforeach
    </div>
    <br clear="all">
</div>

<div class="text-center" style="margin-top:50px;">
    <div style="margin-bottom:50px;">อนุญาต</div>
    <div>(ลงชื่อ)............................................................................</div>
    <div>(………………………………………………………………………..)</div>
    <div>ตำแหน่ง ผู้อำนวยการ{{ $rs->bureauVehicle->title }}</div>
    <div>วันที่ ............./.............../...................</div>
</div>

@endif


@endsection

@push('js')
<script>
    window.print();  
</script>
@endpush