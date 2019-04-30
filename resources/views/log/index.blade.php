@extends('layouts.admin')

@section('content')

<h3>ประวัติการใช้งาน</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/log') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" id="exampleInputName2" placeholder="ชื่อ - สกุล ผู้ใช้งาน" name="search" value="{{ request('search') }}">

            <select name="description" class="selectpicker" id="lunch" title="ทุกรายละเอียด" data-live-search="true">
                <option value="">+ รายละเอียด +</option>
                <option value="created" @if(@request('description') == 'created') selected="selected" @endif>เพิ่ม</option>
                <option value="updated" @if(@request('description') == 'updated') selected="selected" @endif>แก้ไข</option>
                <option value="deleted" @if(@request('description') == 'deleted') selected="selected" @endif>ลบ</option>
            </select>


            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

<div class="pagination-wrapper"> 
    {!! $logs->appends(['search' => Request::get('search'),'description' => Request::get('description')])->render() !!} 
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
