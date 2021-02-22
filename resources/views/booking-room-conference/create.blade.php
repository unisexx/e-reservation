@extends('layouts.admin')

@section('content')

<form method="POST" action="{{ url('booking-room') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    @include ('include.__booking-room-form', ['formMode' => 'create', 'formWhere' => 'backend'])
</form>

@endsection