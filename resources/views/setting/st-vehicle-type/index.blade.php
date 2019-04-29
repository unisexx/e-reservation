@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า ประเภทรถ</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-vehicle-type') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อประเภทรถ" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

@if(CanPerm('st-vehicle-type-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มประเภทรถ" value="เพิ่มประเภทรถ" onclick="document.location='{{ url('/setting/st-vehicle-type/create') }}'"
        class="btn btn-warning vtip" />
</div>
@endif

<div class="pagination-wrapper"> 
    {!! $stvehicletype->appends(['search' => Request::get('search')])->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>ชื่อประเภทรถ</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($stvehicletype as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($stvehicletype->currentPage() - 1 ) * $stvehicletype->perPage() ) + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
            <td>

                @if(CanPerm('st-vehicle-type-edit'))
                <a href="{{ url('/setting/st-vehicle-type/' . $item->id . '/edit') }}" title="Edit StAscc">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                @endif

                @if(CanPerm('st-vehicle-type-delete'))
                <form method="POST" action="{{ url('/setting/st-vehicle-type' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                    </button>
                </form>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $stvehicletype->appends(['search' => Request::get('search')])->render() !!} 
</div>

@endsection
