@extends('layouts.admin')

@section('content')

<form id="resourceForm" method="POST" action="{{ url('booking-resource') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    @include ('include.__booking-resource-form', ['formMode' => 'create', 'formWhere' => 'backend'])
</form>

@endsection