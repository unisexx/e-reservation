@extends('layouts.front')

@section('content')

<div id="btnBox">
 <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองวาระผู้บริหาร</h3>

<form id="bookingBossForm" method="POST" action="{{ url('booking-boss-front') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}

    @include ('include.__booking-boss-form', ['formMode' => 'create', 'formWhere' => 'frontend'])
</form>

@endsection