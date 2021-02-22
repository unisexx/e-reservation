@extends('layouts.admin')

@section('content')

<form method="POST" action="{{ url('booking-room-conference/' . $rs->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('include.__booking-room-form', ['formMode' => 'edit', 'formWhere' => 'backend'])
</form>

@endsection
