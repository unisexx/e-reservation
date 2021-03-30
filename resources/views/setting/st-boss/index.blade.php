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

<table class="tblist table-striped">
    <thead>
    <tr>
        <th style="text-align: center;">ลากวางเพื่อเรียงลำดับ</th>
        <th>ลำดับ</th>
        <th>อักษรย่อ</th>
        <th>ระดับผู้บริหาร</th>
        <th>ชื่อผู้บริหาร</th>
        {{-- <th>ระดับตำแหน่ง</th> --}}
        <th>ตำแหน่ง</th>
        <th>ข้อมูลติดต่อ</th>
        <th>ผู้ดูแล</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rs as $key=>$item)
        <tr id="id-{{ $item->id }}">
            <td align="center">
                <img src="{{ asset('images/scroll.png') }}" width="24" class="vtip" title="ลากวางเพื่อเรียงลำดับ" />
            </td>
            <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}.</td>
            <td>
                <span class='badge' style='color:#000; background-color:{{ $item->color }}'>{{ @$item->abbr }}</span>
            </td>
            <td>{{ @$item->stPositionLevel->name }}</td>
            <td>{{ $item->name }}</td>
            {{-- <td>{{ @$item->stPositionLevel->name ?? '-' }}</td> --}}
            <td>{{ @$item->stBossPosition->name ?? '-' }} {{ !empty(@$item->position_more) ? '('.@$item->position_more.')' : '' }}</td>
            <td>{{ $item->tel }}</td>
            <td>
                <ul>
                    {{-- @foreach($item->stBossRes as $stBossRes)
                    <li>{{ @$stBossRes->user->prefix->title }} {{ @$stBossRes->user->givename }} {{ @$stBossRes->user->familyname }}</li>
                    @endforeach --}}
                    @foreach($item->availableStBossRes as $stBossRes)
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

                @if($item->booking_boss_count == 0)
                    @if(CanPerm('st-boss-delete'))
                    <form method="POST" action="{{ url('/setting/st-boss' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" title="ลบ" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                            <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"/>
                        </button>
                    </form>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination-wrapper"> 
    {!! $rs->appends(@$_GET)->render() !!} 
</div>

@endsection

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
                tb: 'st_bosses',
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
