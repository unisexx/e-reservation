@extends(empty(request('export')) ? 'layouts.admin' : 'layouts.excel')

@section('content')

<h3>จองยานพาหนะ</h3>

@if(empty(request('export')))

<?php
// ประเภทรถ
$st_vehicle_types = App\Model\StVehicleType::where('status', '1')->orderBy('id', 'asc')->get();
?>

<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-vehicle') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_vehicle_type_id" class="form-control">
                <option value="">ประเภทรถ</option>
                @foreach($st_vehicle_types as $row)
                <option value="{{$row->id}}" @if(request('st_vehicle_type_id')==$row->id) selected @endif>{{$row->name}}</option>
                @endforeach
            </select>

            <input type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง / ไปเพื่อ / รายละเอียดรถ / ทะเบียนรถ / ชื่อคนขับ" name="search" value="{{ request('search') }}">

            <select name="date_type" class="form-control">
                <option value="request_date" @if(request('date_type')=='request_date' ) selected @endif>วันที่ขอใช้</option>
                <option value="start_date" @if(request('date_type')=='start_date' ) selected @endif>วันที่ไป</option>
                <option value="end_date" @if(request('date_type')=='end_date' ) selected @endif>วันที่กลับ</option>
            </select>

            <input name="date_select" type="text" class="form-control fdate datepicker" value="{{ request('date_select') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>

    </div>
</div>

<div id="btnBox">
    <a href="{{ url('/booking-vehicle/show?st_province_code='.@Auth::user()->bureau->st_province_code) }}">
        <img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" />
    </a>
    <?php
    $get = '';
    foreach (@$_GET as $key => $value) {
        $get .= ($get) ? '&' . $key . '=' . $value : $key . '=' . $value;
    }
    ?>
    <a href="{{ url('booking-vehicle?export=excel&'.$get) }}">
        <input type="button" title="export excel" value="export excel" class="btn vtip" />
    </a>
    @if(CanPerm('booking-vehicle-create'))
    <input type="button" title="+ ขอจองยานพาหนะ" value="+ ขอจองยานพาหนะ" onclick="document.location='{{ url('/booking-vehicle/create?st_province_code='.@Auth::user()->bureau->st_province_code) }}'" class="btn btn-success vtip" />
    @endif
</div>

@include('include._color_status', ['type'=>'vehicle'])

<div class="pagination-wrapper">
    {!! $rs->appends(@$_GET)->render() !!}
</div>

@endif
<!-- export -->

<table class="table table-bordered table-striped sortable tblist">
    <thead>
        <tr>
            <th class="nosort" data-sortcolumn="0" data-sortkey="0-0">ลำดับ</th>
            <th class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
            <th class="nosort" data-sortcolumn="2" data-sortkey="2-0">ไปเพื่อ / รายละเอียดรถ / ชื่อผู้ขับ</th>
            <th class="nosort" data-sortcolumn="3" data-sortkey="3-0">วันที่</th>
            <th class="nosort" data-sortcolumn="4" data-sortkey="4-0">จุดขึ้นรถ</th>
            <th class="nosort" data-sortcolumn="4" data-sortkey="5-0">สถานที่ไป</th>
            <th class="nosort" data-sortcolumn="5" data-sortkey="6-0">ผู้ขอใช้ยานพาหนะ</th>
            <th class="nosort" data-sortcolumn="6" data-sortkey="7-0">สถานะ</th>
            @if(empty(request('export')))
            <th class="nosort" data-sortcolumn="7" data-sortkey="8-0">จัดการ</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($rs as $key=>$row)
        @php
            // dd($row);
        @endphp
        <tr @if(($key % 2)==1) class="odd" @endif>
            <td>
                @if(empty(request('export')))
                {{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}
                @else
                {{ $key+1 }}
                @endif
            </td>
            <td nowrap="nowrap">{{ $row->code }}</td>
            <td>
                <div class="topicMeeting">{{ $row->gofor }}</div>
                <div>
                    @if(!empty($row->st_vehicle_id))
                    {{ $row->st_vehicle->st_vehicle_type->name }} {{ $row->st_vehicle->brand }} {{ $row->st_vehicle->seat }} ที่นั่ง {{ $row->st_vehicle->color }} ทะเบียน {{ $row->st_vehicle->reg_number }} <br>ชื่อผู้ขับ {{ @$row->st_driver->name }}
                    @else
                    <b>(- ยังไม่ได้เลือกยานพาหนะ -)</b>
                    @endif
                </div>
            </td>
            <td>
                <div class="boxStartEnd"><span class="request">วันที่ขอใช้</span> {{ DB2Date($row->request_date) }} {{ date("H:i", strtotime($row->request_time)) }} น.</div>
                <div class="boxStartEnd"><span class="start">วันที่ไป</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                <div class="boxStartEnd"><span class="end">วันที่กลับ</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
            </td>
            <td>{{ $row->point_place }} เวลา {{ date("H:i", strtotime($row->point_time)) }} น.</td>
            <td>{{ $row->destination }}</td>
            <td>
                {{ $row->request_name }}
                @if(empty(request('export')))
                <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br> {{ $row->request_tel }} {{ $row->request_email }}">
                @endif
            </td>
            <td>
                <span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span>
                <div>{{ @$row->approver->prefix->title }} {{ @$row->approver->givename }} {{ @$row->approver->familyname }}</div>
                <div>{{ DBToDate($row->approve_date,'true','true') }}</div>
            </td>
            @if(empty(request('export')))
            <td>
                <a href="{{ url('booking-vehicle-front/print/'.$row->id) }}" target="_blank"><img src="{{ asset('images/printer.png') }}" alt="พิมพ์ใบจอง" style="width:24px; margin-right:5px;"></a>

                @if(CanPerm('booking-vehicle-edit'))
                <a href="{{ url('booking-vehicle/' . $row->id . '/edit') }}" title="แก้ไขรายการนี้">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                @endif


                @if(CanPerm('booking-vehicle-delete'))
                <form method="POST" action="{{ url('booking-vehicle' . '/' . $row->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="ลบรายการนี้" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                    </button>
                </form>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@if(empty(request('export')))
<div class="pagination-wrapper">
    {!! $rs->appends(@$_GET)->render() !!}
</div>
@endif

@endsection