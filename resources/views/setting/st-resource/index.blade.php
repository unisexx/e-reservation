@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า ทรัพยากร</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-resource') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อทรัพยากร" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

{{-- @if(CanPerm('st-resource-create')) --}}
<div id="btnBox">
    <input type="button" title="เพิ่มทรัพยากร" value="เพิ่มทรัพยากร" onclick="document.location='{{ url('/setting/st-resource/create') }}'"
        class="btn btn-warning vtip" />
</div>
{{-- @endif --}}

<div class="pagination-wrapper"> 
    {!! $rs->appends(@$_GET)->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>รหัส</th>
        <th>ชื่อทรัพยากร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($rs as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->name }}</td>
            <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
            <td>

                {{-- @if(CanPerm('st-resource-edit')) --}}
                <a href="{{ url('/setting/st-resource/' . $item->id . '/edit') }}" title="แก้ไข">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                {{-- @endif --}}

                @if($item->booking_resource_count == 0)
                    {{-- @if(CanPerm('st-resource-delete')) --}}
                    <form method="POST" action="{{ url('/setting/st-resource' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" title="ลบ" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                            <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                        </button>
                    </form>
                    {{-- @endif --}}
                @endif
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $rs->appends(@$_GET)->render() !!} 
</div>

@endsection
