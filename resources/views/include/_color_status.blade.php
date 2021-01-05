{{-- @dump(Request::fullUrl()) --}}
@php
    // if(count($_GET)){
    //     $link = '&';
    // }else{
    //     $link = '?';
    // }
@endphp

<h5><b>ความหมายสถานะ</b></h5>
<ul class="list-unstyled list-inline">
    @if(@$from == 'frontend')

        <li>
            <span class="fc-event-dot" style="background-color:{{ colorStatus2('รออนุมัติ') }};"> </span> รออนุมัติ
        </li>
        <li>
            <span class="fc-event-dot" style="background-color:{{ colorStatus2('อนุมัติ') }};"> </span> อนุมัติ
        </li>
        <li>
            <span class="fc-event-dot" style="background-color:{{ colorStatus2('ไม่อนุมัติ') }};"> </span> ไม่อนุมัติ
        </li>
        <li>
            <span class="fc-event-dot" style="background-color:{{ colorStatus2('ยกเลิก') }};"> </span> ยกเลิก
        </li>

    @else
        {{-- @php
            if($is_conference == 1){
                $conference_path = '&is_conference=1';
            }
        @endphp --}}
        <li>
            <a href="{{ url(Request::url().'?status=รออนุมัติ&is_conference='.@$is_conference) }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('รออนุมัติ') }};"> </span> รออนุมัติ ({{$allrow->where('status','รออนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=อนุมัติ&is_conference='.@$is_conference) }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('อนุมัติ') }};"> </span> อนุมัติ ({{$allrow->where('status','อนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=ไม่อนุมัติ&is_conference='.@$is_conference) }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('ไม่อนุมัติ') }};"> </span> ไม่อนุมัติ ({{$allrow->where('status','ไม่อนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=ยกเลิก&is_conference='.@$is_conference) }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('ยกเลิก') }};"> </span> ยกเลิก ({{$allrow->where('status','ยกเลิก')->count()}})
            </a>
        </li>

    @endif
</ul>