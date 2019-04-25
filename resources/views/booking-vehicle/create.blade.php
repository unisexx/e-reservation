@extends('layouts.admin')

@section('content')

<h3>จองห้องประชุม (เพิ่ม / แก้ไข)</h3>

@if ($errors->any())
<ul class="alert alert-danger list-unstyled">
    <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
    @foreach ($errors->all() as $error)
    <li>- {{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ url('booking-vehicle') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('booking-vehicle.form', ['formMode' => 'create'])

</form>

@endsection