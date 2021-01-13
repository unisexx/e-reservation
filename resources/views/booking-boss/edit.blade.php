@extends('layouts.admin')

@section('content')

<h3>จองวาระผู้บริหาร</h3>

<form id="bookingBossForm" method="POST" action="{{ url('booking-boss/' . $rs->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('include.__booking-boss-form', ['formMode' => 'edit', 'formWhere' => 'backend'])
</form>

@endsection
