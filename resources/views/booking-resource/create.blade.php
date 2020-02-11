@extends('layouts.admin')

@section('content')

<h3>จองทรัพยากรอื่นๆ (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-resource') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('include.__booking-resource-form', ['formMode' => 'create', 'formWhere' => 'backend'])

</form>

@endsection