@extends('layouts.admin')

@section('content')
<?php
// ประเภทรถ
$st_vehicle_types = App\Model\StVehicleType::where('status', '1')->orderBy('id', 'asc')->get();
?>

<h3>ตั้งค่า ยานพาหนะ</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-vehicle') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_vehicle_type_id" class="form-control">
                <option value="">-- ทุกประเภท --</option>
                @foreach($st_vehicle_types as $row)
                <option value="{{$row->id}}" {{ $row->id == request('st_vehicle_type_id') ? 'selected' : '' }}>{{$row->name}}</option>
                @endforeach
            </select>

            <input type="text" class="form-control" style="width:350px;" placeholder="ยี่ห้อ" name="search" value="{{ request('search') }}">

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>


    </div>
</div>

@if(CanPerm('st-vehicle-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มยานพาหนะ" value="เพิ่มยานพาหนะ" onclick="document.location='{{ url('/setting/st-vehicle/create') }}'" class="btn btn-warning vtip" />
</div>
@endif

<div class="pagination-wrapper">
    {!! $rs->appends(['search' => Request::get('search')])->render() !!}
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>ภาพยานพาหนะ</th>
        <th>จังหวัด</th>
        <th>ประเภท / ยี่ห้อ / ที่นั่ง / สี / เลขทะเบียน</th>
        <th>หน่วยงานที่รับผิดชอบ</th>
        {{-- <th>พนักงานขับวันนี้</th> --}}
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($rs as $key=>$row)
    <tr @if(($key % 2)==1) class="odd" @endif>
        <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
        <td>@if($row->image) <img src="{{ url('uploads/vehicle/'.$row->image) }}" width="90"> @endif</td>
        <td>{{ @$row->stProvince->name }}</td>
        <td>{{$row->st_vehicle_type->name}} {{$row->brand}} {{!empty($row->seat)?$row->seat:'-'}} ที่นั่ง สี{{$row->color}} ทะเบียน {{$row->reg_number}}</td>
        <td>
            {{ $row->department->title }} >
            {{ $row->bureau->title }} >
            {{ $row->division->title }}
        </td>
        {{-- <td>{{$row->st_driver->name}} {{$row->st_driver->tel}}</td> --}}
        <td>{{$row->status}}</td>
        <td>
            @if(CanPerm('st-vehicle-edit'))
            <a href="{{ url('/setting/st-vehicle/' . $row->id . '/edit') }}" title="Edit StAscc">
                <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
            </a>
            @endif

            @if($row->booking_vehicle_count == 0)
                @if(CanPerm('st-vehicle-delete'))
                <form method="POST" action="{{ url('/setting/st-vehicle' . '/' . $row->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                    </button>
                </form>
                @endif
            @endif
        </td>
    </tr>
    @endforeach
</table>

<div class="pagination-wrapper">
    {!! $rs->appends(['search' => Request::get('search')])->render() !!}
</div>

@endsection