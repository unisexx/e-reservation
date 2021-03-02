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
        @php
            if($type == 'room'){
                $count = App\Model\BookingRoom::get();
            }elseif($type == 'conference'){
                $count = App\Model\BookingRoom::where('use_conference', 1)->get();
            }elseif($type == 'vehicle'){
                $count = App\Model\BookingVehicle::get();
            }elseif($type == 'resource'){
                $count = App\Model\BookingResource::get();
            }elseif($type == 'boss'){
                $count = App\Model\BookingBoss::where(function($q){
                    // ถ้ามีสิทธิ์ดูแลผู้บริหาร จะสามารถเห็นรายการจองเฉพาะผู้บริหารที่ตัวเองดูแลเท่านั้น
                    if (CanPerm('boss-manager')) {
                        $q->whereHas('stBoss', function ($r) {
                            $r->whereHas('stBossRes', function ($s) {
                                $s->where('user_id', @Auth::user()->id);
                            });
                        });
                    }
                })->get();
            }
        @endphp
        <li>
            <a href="{{ url(Request::url().'?status=รออนุมัติ') }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('รออนุมัติ') }};"> </span> รออนุมัติ ({{$count->where('status','รออนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=อนุมัติ') }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('อนุมัติ') }};"> </span> อนุมัติ ({{$count->where('status','อนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=ไม่อนุมัติ') }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('ไม่อนุมัติ') }};"> </span> ไม่อนุมัติ ({{$count->where('status','ไม่อนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status=ยกเลิก') }}">
                <span class="fc-event-dot" style="background-color:{{ colorStatus2('ยกเลิก') }};"> </span> ยกเลิก ({{$count->where('status','ยกเลิก')->count()}})
            </a>
        </li>
    @endif
</ul>

@if(@$from == 'frontend' && (@$type == 'room' || @$type == 'conference' ))
<h5><b>สถานะของ Conference</b></h5>
<ul class="list-unstyled list-inline">
    <li>
        <img src="{{ asset('images/vdo-conference-gray.png') }}" width="32" height="32"> รออนุมัติ
    </li>
    <li>
        <img src="{{ asset('images/vdo-conference2.png') }}" width="32" height="32"> อนุมัติ
    </li>
    <li>
        <img src="{{ asset('images/vdo-conference-not.png') }}" width="32" height="32"> ไม่อนุมัติ
    </li>
</ul>
@endif