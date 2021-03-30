@extends('layouts.admin')

@section('content')

<h3>สิทธิ์การใช้งาน</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/permission-group') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;"  placeholder="ชื่อสิทธิ์การใช้งาน" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

@if(CanPerm('permission-group-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มสิทธิ์การใช้งาน" value="เพิ่มสิทธิ์การใช้งาน" onclick="document.location='{{ url('/setting/permission-group/create') }}'"
        class="btn btn-warning vtip" />
</div>
@endif


<div class="pagination-wrapper"> 
    {!! $permissiongroup->appends(['search' => Request::get('search')])->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th style="width:50%">ชื่อสิทธิ์การใช้งาน</th>
        <!-- <th style="width:50%">สิทธิ์การใช้งาน</th> -->
        <th>เปิดใช้งาน</th>
        <th>จัดการ</th>
    </tr>
    @foreach($permissiongroup as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($permissiongroup->currentPage() - 1 ) * $permissiongroup->perPage() ) + $loop->iteration }}</td>
            <td>{{ $item->title }}</td>
            <!-- <td></td> -->
            <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
            <td>
                @if(CanPerm('permission-group-edit'))
                <a href="{{ url('/setting/permission-group/' . $item->id . '/edit') }}" title="Edit StAscc">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                @endif

                @if($item->st_user_count == 0)
                    @if(CanPerm('permission-group-delete'))
                    <form method="POST" action="{{ url('/setting/permission-group' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                            <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                        </button>
                    </form>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $permissiongroup->appends(['search' => Request::get('search')])->render() !!} 
</div>
@endsection
