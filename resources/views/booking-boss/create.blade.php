@extends('layouts.admin')

@section('content')

<h3>จองวาระผู้บริหาร</h3>

<form id="bookingBossForm" method="POST" action="{{ url('booking-boss') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}

    @include ('include.__booking-boss-form', ['formMode' => 'create', 'formWhere' => 'backend'])
</form>

@endsection