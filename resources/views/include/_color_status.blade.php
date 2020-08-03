{{-- @dump(Request::fullUrl()) --}}
@php
    // if(count($_GET)){
    //     $link = '&';
    // }else{
    //     $link = '?';
    // }
@endphp

<h5><b>ความหมายสีสถานะ</b></h5>
<ul class="list-unstyled list-inline">
    <li>
        <a href="{{ url(Request::url().'?status=รออนุมัติ') }}">
            <span class="fc-event-dot" style="background-color:{{ colorStatus('รออนุมัติ') }};"> </span> รออนุมัติ ({{$allrow->where('status','รออนุมัติ')->count()}})
        </a>
    </li>
    <li>
        <a href="{{ url(Request::url().'?status=อนุมัติ') }}">
            <span class="fc-event-dot" style="background-color:{{ colorStatus('อนุมัติ') }};"> </span> อนุมัติ ({{$allrow->where('status','อนุมัติ')->count()}})
        </a>
    </li>
    <li>
        <a href="{{ url(Request::url().'?status=ไม่อนุมัติ') }}">
            <span class="fc-event-dot" style="background-color:{{ colorStatus('ไม่อนุมัติ') }};"> </span> ไม่อนุมัติ ({{$allrow->where('status','ไม่อนุมัติ')->count()}})
        </a>
    </li>
    <li>
        <a href="{{ url(Request::url().'?status=ยกเลิก') }}">
            <span class="fc-event-dot" style="background-color:{{ colorStatus('ยกเลิก') }};"> </span> ยกเลิก ({{$allrow->where('status','ยกเลิก')->count()}})
        </a>
    </li>
</ul>