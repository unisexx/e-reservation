@extends('layouts.admin')

@section('content')

<h3>ผู้ใช้งาน</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/user') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อ - สกุล" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

@if(CanPerm('user-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มผู้ใช้งาน" value="เพิ่มผู้ใช้งาน" onclick="document.location='{{ url('/setting/user/create') }}'" class="btn btn-warning vtip" />
</div>
@endif

<div class="pagination-wrapper">
    {!! $user->appends(['search' => Request::get('search')])->render() !!}
</div>

<table class="tblist">
    <tr>
        <th align="left">ลำดับ</th>
        <th align="left">ชื่อ-สกุลผู้ใช้งาน</th>
        <th align="left">หน่วยงาน</th>
        <th align="left">สิทธิ์การใช้งาน</th>
        <th align="left">อีเมล์</th>
        <th align="left">วันที่ลงทะเบียน</th>
        <th align="left">เปิดใช้งาน</th>
        <th align="left">จัดการ</th>
    </tr>
    @foreach($user as $key=>$item)
    <tr @if(($key % 2)==1) class="odd" @endif>
        <td>{{ (($user->currentPage() - 1 ) * $user->perPage() ) + $loop->iteration }}</td>
        <td>{{ $item->prefix }} {{ $item->givename }} {{ $item->familyname }}</td>
        <td>
            {{ @$item->department->title }} >
            {{ @$item->bureau->title }} >
            {{ @$item->division->title }}
        </td>
        <td>{{ @$item->permission_group->title }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ DB2Date($item->created_at) }}</td>
        <td>
            @if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif
        </td>
        <td>
            @if(CanPerm('user-edit'))
            <a href="{{ url('/setting/user/' . $item->id . '/edit') }}" title="Edit User">
                <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
            </a>
            @endif

            @if(CanPerm('user-delete'))
            <form method="POST" action="{{ url('/setting/user' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                    <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                </button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>

<div class="pagination-wrapper">
    {!! $user->appends(['search' => Request::get('search')])->render() !!}
</div>

@endsection