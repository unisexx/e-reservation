<h5><b>สถานะของ Conference</b></h5>
<ul class="list-unstyled list-inline">
    @if(@$from == 'frontend' && @$type == "room")

        <li>
            <img src="{{ asset('images/vdo-conference-gray.png') }}" width="32" height="32"> รออนุมัติ
        </li>
        <li>
            <img src="{{ asset('images/vdo-conference2.png') }}" width="32" height="32"> อนุมัติ
        </li>
        <li>
            <img src="{{ asset('images/vdo-conference-not.png') }}" width="32" height="32"> ไม่อนุมัติ
        </li>

    @else
        @php
            if($type == 'room'){
                $booking_room = App\Model\BookingRoom::filterByPermissionView()->where('use_conference', '<>', 1)->get();
            }elseif($type == 'conference'){
                $booking_room = App\Model\BookingRoom::filterByPermissionView()->where('use_conference', 1)->get();
            }
        @endphp
        <li>
            <a href="{{ url(Request::url().'?status_conference=รออนุมัติ') }}">
                <img src="{{ asset('images/vdo-conference-gray.png') }}" width="32" height="32"> รออนุมัติ ({{$booking_room->where('status_conference','รออนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status_conference=อนุมัติ') }}">
                <img src="{{ asset('images/vdo-conference2.png') }}" width="32" height="32"> อนุมัติ ({{$booking_room->where('status_conference','อนุมัติ')->count()}})
            </a>
        </li>
        <li>
            <a href="{{ url(Request::url().'?status_conference=ไม่อนุมัติ') }}">
                <img src="{{ asset('images/vdo-conference-not.png') }}" width="32" height="32"> ไม่อนุมัติ ({{$booking_room->where('status_conference','ไม่อนุมัติ')->count()}})
            </a>
        </li>
    @endif
</ul>