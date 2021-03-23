@extends('layouts.admin')

@section('content')

<form id="bookingVehicleForm" method="POST" action="{{ url('booking-vehicle/' . $rs->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('include.__booking-vehicle-form', ['formMode' => 'edit', 'formWhere' => 'backend'])
</form>

@endsection
