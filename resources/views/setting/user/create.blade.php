@extends('layouts.admin')

@section('content')

<h3>ผู้ใช้งาน (เพิ่ม / แก้ไข)</h3>

@if ($errors->any())
<ul class="alert alert-danger list-unstyled">
    <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
    @foreach ($errors->all() as $error)
    <li>- {{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ url('/setting/user') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('setting.user.form', ['formMode' => 'create'])

</form>

@endsection
