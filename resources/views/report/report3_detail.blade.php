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

<h3>รายงานการจองทรัพยากร</h3>

<?php
    $get = '';
    foreach (@$_GET as $key => $value) {
        $get .= ($get) ? '&'.$key.'='.$value : $key.'='.$value;
    }
?>

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
    </tr>
    </thead>
    <tbody>
    @foreach($rs as $key=>$row)
        <tr @if(($key % 2)==1) class="odd" @endif>
            <td>{{ $key+1 }}</td>
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
            <td>
                <span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span>
                <div>{{ @$row->approver->prefix->title }} {{ @$row->approver->givename }} {{ @$row->approver->familyname }}</div>
                <div>{{ DBToDate($row->approve_date,'true','true') }}</div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div id="btnBoxAdd">
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ URL::previous() }}'" class="btn btn-default" style="width:100px;" />
</div>

@endsection