@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า ยานพาหนะ</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-vehicle') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อยานพาหนะ" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

{{-- @if(CanPerm('st-vehicle-create')) --}}
<div id="btnBox">
    <input type="button" title="เพิ่มห้องประชุม" value="เพิ่มห้องประชุม" onclick="document.location='{{ url('/setting/st-vehicle/create') }}'"
        class="btn btn-warning vtip" />
</div>
{{-- @endif --}}

<div class="pagination-wrapper"> 
    {!! $stvehicle->appends(['search' => Request::get('search')])->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>ภาพยานพาหนะ</th>
        <th>ประเภท / ยี่ห้อ / ที่นั่ง / สี / เลขทะเบียน</th>
        <th>พนักงานขับวันนี้</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($stvehicle as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($stvehicle->currentPage() - 1 ) * $stvehicle->perPage() ) + $loop->iteration }}</td>
            <td>@if($item->image) <img src="{{ url('uploads/room/'.$item->image) }}" width="90"> @endif</td>
            <td>{{ $item->name }}</td>
            <td>
                <div>จำนวนคนที่รับรองได้ : {{ !empty($item->people) ? $item->people : "-" }} คน</div>
                <div>อุปกรณ์ที่ติดตั้งในห้อง : {{ !empty($item->equipment) ? $item->equipment : "-" }}</div>
                <div>ผู้รับผิดชอบห้องประชุม : {{ !empty($item->res_name) ? $item->res_name : "-" }} {{ !empty($item->res_department_id) ? $item->res_department_id : "-" }}</div>
                <div>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : {{ !empty($item->fee) ? $item->fee : "-" }}</div>
            </td>
            <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
            <td>

                {{-- @if(CanPerm('st-vehicle-edit')) --}}
                <a href="{{ url('/setting/st-vehicle/' . $item->id . '/edit') }}" title="Edit StAscc">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                {{-- @endif --}}

                {{-- @if(CanPerm('st-vehicle-delete')) --}}
                <form method="POST" action="{{ url('/setting/st-vehicle' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                    </button>
                </form>
                {{-- @endif --}}
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $stvehicle->appends(['search' => Request::get('search')])->render() !!} 
</div>

@endsection
