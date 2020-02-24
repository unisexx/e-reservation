@extends('layouts.front')

@section('content')

<div id="btnBox">
 <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองทรัพยากรอื่นๆ (เพิ่ม / แก้ไข)</h3>

<form method="POST" action="{{ url('booking-resource-front') }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include ('include.__booking-resource-form', ['formMode' => 'create', 'formWhere' => 'frontend'])

</form>

@endsection