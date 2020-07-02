@extends('layouts.admin')

@section('content')

<h3>จองทรัพยากรอื่นๆ (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-resource/' . $rs->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @include ('include.__booking-resource-form', ['formMode' => 'edit', 'formWhere' => 'backend'])

</form>

@endsection
