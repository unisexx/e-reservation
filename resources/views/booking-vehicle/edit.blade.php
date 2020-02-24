@extends('layouts.admin')

@section('content')

<h3>จองยานพาหนะ (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-vehicle/' . $rs->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @include ('include.__booking-vehicle-form', ['formMode' => 'edit', 'formWhere' => 'backend'])

</form>

@endsection
