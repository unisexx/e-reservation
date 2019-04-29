@extends('layouts.admin')

@section('content')

<h3>ประวัติการใช้งาน</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-ascc') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="รหัส / ชื่อแผนงาน ASCC " name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

<div class="pagination-wrapper"> 
    {!! $logs->appends(['search' => Request::get('search')])->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>วันเวลาใช้งาน</th>
        <th>ชื่อ - สกุล ผู้ใช้งาน</th>
        <th>รายละเอียด</th>
    </tr>
    @foreach($logs as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($logs->currentPage() - 1 ) * $logs->perPage() ) + $loop->iteration }}</td>
            <td>{{ DBToDate($item->created_at, true, true) }}</td>
            <td>{{ $item->causer->name }}</td>
            <td>{{ thDescription($item->description) }} {{ modelNameTh($item->subject_type) }} (ID:{{$item->subject_id}})</td>
            <!-- <td>{{ $item->subject_type }}</td>
            <td>
                <?php
                    $properties = $item->properties;
                    foreach($properties['attributes'] as $attribute => $old) {
                        echo $attribute.': '.$old.' => '.$properties['attributes'][$attribute].'<br>';
                    }
                ?>
            </td> -->
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $logs->appends(['search' => Request::get('search')])->render() !!} 
</div>

@endsection
