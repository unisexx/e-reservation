@extends('layouts.admin')

@section('content')
<?php
    // สิทธิ์การใช้งาน
    $permission_groups = App\Model\PermissionGroup::where('status',1)->orderBy('id','asc')->get();

    // หน่วยงาน
    $st_ministries = App\Model\StMinistry::orderBy('code', 'asc')->get();
    $st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();

    if (request('st_department_code')) {
        $st_bureaus = App\Model\StBureau::where('code', 'like', request('st_department_code') . '%')->orderBy('code', 'asc')->get();
    }

    if (request('st_bureau_code')) {
        $st_divisions = App\Model\StDivision::where('code', 'like', request('st_bureau_code') . '%')->orderBy('code', 'asc')->get();
    }
?>

<h3>ผู้ใช้งาน</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/user') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อ - สกุล, เลขบัตรประชาชน" name="search" value="{{ request('search') }}">

            <div class="form-inline dep-chain-group" style="display:inline;">

                <select name="st_department_code" id="lunch"
                    class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}"
                    data-live-search="true" data-size="10" title="กรม">
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == request('st_department_code')) selected="selected"
                        @endif @if($item->code == @$user->st_department_code) selected="selected"
                        @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code" id="lunch"
                    class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true"
                    data-size="10" title="สำนัก">
                    <option value="">+ สำนัก +</option>
                    @if(request('st_department_code') || isset($user->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == request('st_bureau_code')) selected="selected"
                        @endif @if($item->code == @$user->st_bureau_code) selected="selected" @endif>{{ $item->title }}
                    </option>
                    @endforeach
                    @endif
                </select>

            </div>

            <span class="form-inline">
                <select name="permission_group_id"
                    class="form-control"
                    style="width:auto;">
                    <option value="">เลือกสิทธิ์การใช้งาน</option>
                    @foreach($permission_groups as $item)
                    <option value="{{ $item->id }}" @if($item->id == @request('permission_group_id')) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>
            </span>

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
        <td>{{ $item->prefix->title }} {{ $item->givename }} {{ $item->familyname }}</td>
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