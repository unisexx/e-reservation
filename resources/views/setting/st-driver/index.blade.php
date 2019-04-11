@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า พนักงานขับ</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-driver') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อพนักงานขับ" name="search" value="{{ request('search') }}">
            <select name="lunch2" class="selectpicker" id="lunch" title="หน่วยงาน" data-live-search="true">
                <option>-- ทุกหน่วยงาน --</option>
                <option>[06102008001] กองยุทธศาสตร์และแผนงาน ฝ่ายบริหารทั่วไป</option>
                <option>[06102011001] ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร ฝ่ายบริหารทั่วไป</option>
            </select>
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

{{-- @if(CanPerm('st-driver-create')) --}}
<div id="btnBox">
    <input type="button" title="เพิ่มพนักงานขับ" value="เพิ่มพนักงานขับ" onclick="document.location='{{ url('/setting/st-driver/create') }}'"
        class="btn btn-warning vtip" />
</div>
{{-- @endif --}}

<div class="pagination-wrapper"> 
    {!! $rs->appends(['search' => Request::get('search')])->render() !!} 
</div>

<table class="tblist">
    <tr>
        <th>ลำดับ</th>
        <th>ชื่อพนักงานขับ</th>
        <th>หน่วยงาน</th>
        <th>ข้อมูลติดต่อ</th>
        <th>จัดการ</th>
    </tr>
    @foreach($rs as $key=>$item)
        <tr @if(($key % 2) == 1) class="odd" @endif>
            <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->name }}</td>
            <td>

                {{-- @if(CanPerm('st-driver-edit')) --}}
                <a href="{{ url('/setting/st-driver/' . $item->id . '/edit') }}" title="Edit StAscc">
                    <img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" />
                </a>
                {{-- @endif --}}

                {{-- @if(CanPerm('st-driver-delete')) --}}
                <form method="POST" action="{{ url('/setting/st-driver' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none;">
                        <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                    </button>
                </form>
                {{-- @endif --}}
            </td>
        </tr>
    @endforeach
</table>

<div class="pagination-wrapper"> 
    {!! $rs->appends(['search' => Request::get('search')])->render() !!} 
</div>

@endsection
