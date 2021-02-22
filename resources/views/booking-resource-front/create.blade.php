@extends('layouts.front')

@section('content')

<form method="POST" action="{{ url('booking-resource-front') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    @include ('include.__booking-resource-form', ['formMode' => 'create', 'formWhere' => 'frontend'])
</form>

@endsection