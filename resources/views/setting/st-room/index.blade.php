@extends('layouts.admin')

@section('content')

<h3>ตั้งค่า ห้องประชุม</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('/setting/st-room') }}" accept-charset="UTF-8" class="form-inline" role="search">
            <input type="text" class="form-control" style="width:350px;" placeholder="ชื่อห้องประชุม" name="search" value="{{ request('search') }}">
            {{ Form::select(
                'st_province_code', 
                App\Model\StProvince::where('status', 1)->orderBy('code', 'asc')->pluck('name','code'), request('st_province_code'), 
                [
                    'class' => 'form-control selectpicker', 
                    'data-live-search' => 'true',
                    'data-size' => '8',
                    'data-width' => 'auto',
                    'data-title' => 'เลือกจังหวัด',
                ])
            }}
            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

@if(CanPerm('st-room-create'))
<div id="btnBox">
    <input type="button" title="เพิ่มห้องประชุม" value="เพิ่มห้องประชุม" onclick="document.location='{{ url('/setting/st-room/create') }}'" class="btn btn-warning vtip" />
</div>
@endif

<div class="pagination-wrapper">
    {!! $stroom->appends(['search' => Request::get('search')])->render() !!}
</div>

<table class="tblist table-striped">
    <thead>
    <tr>
        <th style="text-align: center;">ลากวางเพื่อเรียงลำดับ</th>
        <th>ลำดับ</th>
        <th style="width:20%">ภาพห้องประชุม</th>
        <th>จังหวัด</th>
        <th style="width:20%">ชื่อห้องประชุม</th>
        <th style="width:30%">รายละเอียด</th>
        <th>สถานะ</th>
        @if(CanPerm('is-superadmin'))
            <th style="text-align: center;">set default<br>(ค่าเริ่มต้นการแสดงผล)</th>
        @endif
        <th>จัดการ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stroom as $key=>$item)
    <tr id="id-{{ $item->id }}">
        <td align="center">
            <img src="{{ asset('images/scroll.png') }}" width="24" class="vtip" title="ลากวางเพื่อเรียงลำดับ" />
        </td>
        <td>{{ (($stroom->currentPage() - 1 ) * $stroom->perPage() ) + $loop->iteration }}.</td>
        <td class="imgGroup">
            @if($item->image)
                @php 
                    $images = (explode("|",$item->image));
                @endphp
                @foreach($images as $key=>$image)
                <a class="colorbox" data-rel="group_{{$item->id}}" href="{{ url('uploads/room/'.$image) }}" title="{{ $item->name }}">
                    <img src="{{ url('uploads/room/'.$image) }}" width="90" @if($key > 0) style="display:none;" @endif>
                </a>
                @endforeach
            @endif
        </td>
        <td>{{ $item->stProvince->name }}</td>
        <td>{{ $item->name }}</td>
        <td>
            <div>จำนวนคนที่รองรับได้ : {{ !empty($item->people) ? $item->people : "-" }} คน</div>
            <div>อุปกรณ์ที่ติดตั้งในห้อง : {{ !empty($item->equipment) ? $item->equipment : "-" }}</div>
            <div>
                ผู้รับผิดชอบห้องประชุม : {{ !empty($item->res_name) ? $item->res_name : "-" }}
                {{ !empty($item->st_department_code) ? $item->department->title : "-" }}
                {{ !empty($item->st_bureau_code) ? $item->bureau->title : "-" }}
                {{ !empty($item->st_division_code) ? $item->division->title : "-" }}
            </div>
            <div>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : {{ !empty($item->fee) ? $item->fee : "-" }}</div>
        </td>
        <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
        @if(CanPerm('is-superadmin'))
        <td align="center">
            <input class="isDefault" name="is_default" type="radio" value="{{ $item->id }}" {!! (@$item->is_default == 1) ? 'checked="checked"' : '' !!} />
        </td>
        @endif
        <td>
            @if(CanPerm('st-room-edit'))
            <a href="{{ url('/setting/st-room/' . $item->id . '/edit') }}" title="Edit StAscc">
                <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
            </a>
            @endif

            @if(CanPerm('st-room-delete'))
            <form method="POST" action="{{ url('/setting/st-room' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                    <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                </button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
    {!! $stroom->appends(['search' => Request::get('search')])->render() !!}
</div>


<script>
$(document).ready(function(){
    $('.colorbox').colorbox({
        rel:function() {        
            return $(this).data('rel');
        },
        width:"75%", 
        height:"75%",
    });
});
</script>
@endsection

@push('css')
<style>
    input[type='radio'] { transform: scale(1.5); }
</style>
@endpush

@push('js')
<script>
$(document).ready(function(){
    $('body').on('click', '.isDefault', function() {
        var roomId = $('input[name=is_default]:checked').val();
        $.get("{{ url('ajaxSetDefaultRoom') }}",
        {
            id: roomId,
        },
        function(data){
            console.log('set default complete');
        });
    });
});
</script>
@endpush

@push('css')
<style>
table.tblist {
    border-spacing: collapse;
    border-spacing: 0;
}
td {
    width: 50px;
    height: 25px;
    border: 1px solid black;
}
.yellow
{
    background:rgb(211, 211, 211) !important;
}
</style>
@endpush

@push('js')
<script>
$(function() {
    $("tbody").sortable({
        helper: fixWidthHelper,
        start: function( event, ui ) { 
            $(ui.item).addClass("yellow");
        },
            stop:function( event, ui ) { 
            $(ui.item).removeClass("yellow");
        },
        update: function( ) {
            // console.log('drop');

            // เรียงลำดับเลขแถวใหม่
            var c = 0;
            $('.tblist > tbody > tr').each(function(ind, el) {
                orderNumber = ++c;
                $(el).find("td:eq(1)").html(orderNumber + ".");
                $(el).find(".roomOrder").val(orderNumber);
            });

            var oData = $(this).sortable('serialize');
            // console.log( oData );

            // อัพเดท order ลงฐานข้อมูล
            $.get("{{ url('ajaxSaveOrder') }}",
            {
                data: oData,
                tb: 'st_rooms',
            },function(data){
                console.log('save order complete');
            });
        }
    }).disableSelection();
});

function fixWidthHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}
</script>
@endpush