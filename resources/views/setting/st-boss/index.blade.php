@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า ผู้บริหาร</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-boss') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อผู้บริหาร" name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

@if(CanPerm('st-boss-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มผู้บริหาร" value="เพิ่มผู้บริหาร" onclick="document.location='{{ url('/setting/st-boss/create') }}'"
        class="btn btn-warning vtip" />
</div>
@endif

<div class="pagination-wrapper"> 
    {!! $rs->appends(@$_GET)->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>ระดับผู้บริหาร</th>
        <th>ชื่อผู้บริหาร</th>
        {{-- <th>ระดับตำแหน่ง</th> --}}
        <th>ตำแหน่ง</th>
        <th>ข้อมูลติดต่อ</th>
        <th>ผู้ดูแล</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($rs as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
            <td>{{ @$item->stPositionLevel->name }}</td>
            <td>{{ $item->name }}</td>
            {{-- <td>{{ @$item->stPositionLevel->name ?? '-' }}</td> --}}
            <td>{{ @$item->stBossPosition->name ?? '-' }} {{ !empty(@$item->position_more) ? '('.@$item->position_more.')' : '' }}</td>
            <td>{{ $item->tel }}</td>
            <td>
                <ul>
                    @foreach($item->stBossRes as $stBossRes)
                    <li>{{ @$stBossRes->user->prefix->title }} {{ @$stBossRes->user->givename }} {{ @$stBossRes->user->familyname }}</li>
                    @endforeach
                </ul>
            </td>
            <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
            <td>

                @if(CanPerm('st-boss-edit'))
                <a href="{{ url('/setting/st-boss/' . $item->id . '/edit') }}" title="แก้ไข">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                @endif

                @if(CanPerm('st-boss-delete'))
                <form method="POST" action="{{ url('/setting/st-boss' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="ลบ" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                    </button>
                </form>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $rs->appends(@$_GET)->render() !!} 
</div>

@endsection
