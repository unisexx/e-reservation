@extends(empty(request('export')) ? 'layouts.admin' : 'layouts.excel')

@section('content')
<h3>จองวาระผู้บริหาร</h3>

@if(empty(request('export')))
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-boss') }}" accept-charset="UTF-8" class="form-inline" role="search" autocomplete="off">

            <input type="text" class="form-control" style="width:370px;"
                placeholder="รหัสการจอง / ชื่อผู้บริหาร / ข้อมูลการจอง" name="keyword" value="{{ request('keyword') }}">

            <select name="date_type" class="form-control">
                <option value="start_date" @if(request('date_type')=='start_date' ) selected @endif>วันที่เริ่ม</option>
                <option value="end_date" @if(request('date_type')=='end_date' ) selected @endif>วันที่สิ้นสุด</option>
            </select>

            <input name="date_select" type="text" class="form-control fdate datepicker"
                value="{{ request('date_select') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16"
                    height="16" />ค้นหา</button>
        </form>
    </div>
</div>

<div id="btnBox">
    <a href="{{ url('/booking-boss/show') }}">
        <img src="{{ url('images/view_calendar.png') }}" class="vtip" title="มุมมองปฎิทิน" />
    </a>
    <?php
        $get = '';
        foreach (@$_GET as $key => $value) {
            $get .= ($get) ? '&' . $key . '=' . $value : $key . '=' . $value;
        }
        ?>
    <a href="{{ url('booking-boss?export=excel&'.$get) }}">
        <input type="button" title="export excel" value="export excel" class="btn vtip" />
    </a>
    {{-- @if(CanPerm('booking-boss-create')) --}}
    <input type="button" title="+ จองวาระผู้บริหาร" value="+ จองวาระผู้บริหาร"
        onclick="document.location='{{ url('/booking-boss/create') }}'" class="btn btn-success vtip" />
    {{-- @endif --}}
</div>

@include('include._color_status', ['type'=>'boss'])

<div class="pagination-wrapper">
    {!! $rs->appends(@$_GET)->render() !!}
</div>
@endif
<!-- export -->


<table class="table table-bordered table-striped sortable tblist">
    <thead>
        <tr>
            <th style="width:5%">ลำดับ</th>
            <th style="width:8%">รหัสการจอง</th>
            <th style="width:15%">ชื่อผู้บริหาร</th>
            <th style="width:25%">ข้อมูลการจอง</th>
            <th style="width:15%">วัน เวลา นัดหมาย</th>
            <th style="width:15%">รายละเอียดผู้จอง</th>
            <th style="width:5%">สถานะ</th>
            <th style="width:5%">จัดการ</th>
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
            <td><span class='badge' style='color:#000; background-color:{{ @$row->stBoss->color }}'>{{ @$row->stBoss->abbr }}</span> {{ @$row->stBoss->name }} ({{ @$row->getBossStatusTxt() }})</td>
            <td>
                <div class="topicMeeting">{{ @$row->title }}</div>
                <div>{{ @$row->place }}</div>
                <div>{{ @$row->owner }}</div>
                <div>{{ @$row->tel }}</div>
            </td>
            <td>
                <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
            </td>
            <td>
                {{ $row->request_name }}
                @if(empty(request('export')))
                <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
                {{ $row->request_tel }} {{ $row->request_email }}" />
                @endif
            </td>
            <td>
                <span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span>
                <div>{{ @$row->approver->prefix->title }} {{ @$row->approver->givename }} {{ @$row->approver->familyname }}</div>
                <div>{{ DBToDate($row->approve_date,'true','true') }}</div>
            </td>
            <td>
                {{-- <a href="{{ url('booking-boss/print/'.$row->id) }}" target="_blank"><img src="{{ asset('images/printer.png') }}" alt="พิมพ์ใบจอง" style="width:24px; margin-right:5px;"></a> --}}

                {{-- @if(CanPerm('booking-boss-edit') || CanPerm('booking-room-view-conference')) --}}
                <a href="{{ url('booking-boss/' . $row->id . '/edit') }}" title="แก้ไขรายการนี้">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                {{-- @endif --}}


                {{-- @if(CanPerm('booking-room-delete')) --}}
                <form method="POST" action="{{ url('booking-boss' . '/' . $row->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="ลบรายการนี้" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                    </button>
                </form>
                {{-- @endif --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@if(empty(request('export')))
<div class="pagination-wrapper">
    {!! $rs->appends(@$_GET)->render() !!}
</div>
@endif
<!-- export -->

@endsection
