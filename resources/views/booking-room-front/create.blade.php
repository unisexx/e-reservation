@extends('layouts.front')

@section('content')

<div id="btnBox">
 <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<form id="bookingRoomForm" method="POST" action="{{ url('booking-room-front') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    @include ('include.__booking-room-form', ['formMode' => 'create', 'formWhere' => 'frontend'])
</form>

@endsection