@extends('layout.template')

@section('content')
<h3>จองยานพาหนะ</h3>

<div id="btnBox">
 <a href="{{ url('/booking_room') }}">	<img src="{{ url('images/view_list.png') }}" class="vtip" title="ดูมุมมองรายการ" /></a>
</div>


<img src="{{ url('images/calendar2.jpg') }}" />

@endsection