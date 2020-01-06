@extends('layouts.front')

@section('content')

<div id="btnBox">
 <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองยานพาหนะ (เพิ่ม / แก้ไข)</h3>

@if ($errors->any())
<ul class="alert alert-danger list-unstyled">
    <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
    @foreach ($errors->all() as $error)
    <li>- {{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ url('booking-vehicle-front') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('include.__booking-vehicle-form', ['formMode' => 'create', 'formWhere' => 'frontend'])

</form>

@endsection