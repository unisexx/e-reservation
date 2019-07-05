@extends(empty(request('export')) ? 'layouts.admin' : 'layouts.excel')

@section('content')

<h3>จองทรัพยกรอื่นๆ</h3>

@if(empty(request('export')))

<?php
// ทรัพยากร
$st_resource = App\Model\StResource::where('status', '1')->orderBy('id', 'asc')->get();
?>

<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-resource') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_resource_id" class="form-control">
                <option value="">ทรัพยากร</option>
                @foreach($st_resource as $row)
                <option value="{{$row->id}}" @if(request('st_resource_id')==$row->id) selected @endif>{{$row->name}}</option>
                @endforeach
            </select>

            <input type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง / หัวข้อ / ผู้ขอใช้" name="search" value="{{ request('search') }}">

            <select name="date_type" class="form-control">
                <option value="start_date" @if(request('date_type')=='start_date' ) selected @endif>วันที่เริ่ม</option>
                <option value="end_date" @if(request('date_type')=='end_date' ) selected @endif>วันที่สิ้นสุด</option>
            </select>

            <input name="date_select" type="text" class="form-control fdate datepicker" value="{{ request('date_select') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>


<div id="btnBox">
    <a href="{{ url('/booking-resource/show') }}">
        <img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" />
    </a>
    <?php
    $get = '';
    foreach (@$_GET as $key => $value) {
        $get .= ($get) ? '&' . $key . '=' . $value : $key . '=' . $value;
    }
    ?>
    <a href="{{ url('booking-resource?export=excel&'.$get) }}">
        <input type="button" title="export excel" value="export excel" class="btn vtip" />
    </a>
    @if(CanPerm('booking-resource-create'))
    <input type="button" title="จองทรัพยกรอื่นๆ" value="จองทรัพยกรอื่นๆ" onclick="document.location='{{ url('/booking-resource/create') }}'" class="btn btn-success vtip" />
    @endif
</div>

<div class="pagination-wrapper">
    {!! $rs->appends(@$_GET)->render() !!}
</div>

@endif
<!-- export -->

<table class="table table-bordered table-striped sortable tblist">
    <thead>
        <tr>
            <th style="width:5%" class="nosort" data-sortcolumn="0" data-sortkey="0-0">ลำดับ</th>
            <th style="width:7%" class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
            <th style="width:5%" class="nosort" data-sortcolumn="1" data-sortkey="2-0">ทรัพยากร</th>
            <th style="width:20%" class="nosort" data-sortcolumn="2" data-sortkey="3-0">หัวข้อ</th>
            <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="4-0">วัน เวลา ที่ต้องการใช้</th>
            <th style="width:13%" class="nosort" data-sortcolumn="4" data-sortkey="5-0">ผู้ขอใช้</th>
            <th style="width:5%" class="nosort" data-sortcolumn="5" data-sortkey="6-0">สถานะ</th>
            @if(empty(request('export')))
            <th style="width:5%" class="nosort" data-sortcolumn="6" data-sortkey="7-0">จัดการ</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($rs as $key=>$row)
        <tr @if(($key % 2)==1) class="odd" @endif>
            <td>
                @if(empty(request('export')))
                {{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}
                @else
                {{ $key+1 }}
                @endif
            </td>
            <td nowrap="nowrap">{{ $row->code }}</td>
            <td nowrap="nowrap">{{ $row->stResource->name }}</td>
            <td>
                <div class="topicMeeting">{{ $row->title }}</div>
            </td>
            <td>
                <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
            </td>
            <td>{{ $row->request_name }}
                @if(empty(request('export')))
                <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
                {{ $row->request_tel }} {{ $row->request_email }}" />
                @endif
            </td>
            <td><span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span></td>
            @if(empty(request('export')))
            <td>
                @if(CanPerm('booking-resource-edit'))
                <a href="{{ url('booking-resource/' . $row->id . '/edit') }}" title="แก้ไขรายการนี้">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                @endif


                @if(CanPerm('booking-resource-delete'))
                <form method="POST" action="{{ url('booking-resource' . '/' . $row->id) }}" accept-charset="UTF-8" style="display:inline">
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

<h5><b>ความหมายสีสถานะ</b></h5>
<ul class="list-unstyled">
    <li><span class="fc-event-dot" style="background-color:{{ colorStatus('รออนุมัติ') }};"> </span> รออนุมัติ</li>
    <li><span class="fc-event-dot" style="background-color:{{ colorStatus('อนุมัติ') }};"> </span> อนุมัติ</li>
    <li><span class="fc-event-dot" style="background-color:{{ colorStatus('ไม่อนุมัติ') }};"> </span> ไม่อนุมัติ</li>
    <li><span class="fc-event-dot" style="background-color:{{ colorStatus('ยกเลิก') }};"> </span> ยกเลิก</li>
</ul>
@endif
<!-- export -->

@endsection