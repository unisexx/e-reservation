@extends('layouts.admin')

@section('content')

<h3>จองห้องประชุม/อบรม (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-room') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('include.__booking-room-form', ['formMode' => 'create', 'formWhere' => 'backend'])

</form>

@endsection