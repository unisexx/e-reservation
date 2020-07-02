@extends('layouts.admin')

@section('content')

<h3>จองยานพาหนะ (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-vehicle') }}" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}

    @include ('include.__booking-vehicle-form', ['formMode' => 'create', 'formWhere' => 'backend'])

</form>

@endsection