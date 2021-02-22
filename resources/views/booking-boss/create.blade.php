@extends('layouts.admin')

@section('content')

<form id="bookingBossForm" method="POST" action="{{ url('booking-boss') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    @include ('include.__booking-boss-form', ['formMode' => 'create', 'formWhere' => 'backend'])
</form>

@endsection