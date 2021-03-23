@extends('layouts.front')

@section('content')
@php
    $action = Route::currentRouteAction();
    // dump($action);
    if($action == 'App\Http\Controllers\BookingRoomFrontController@province'){
        $bookinTxt = 'เพื่อจองห้องประชุม';
    }elseif ($action == 'App\Http\Controllers\BookingVehicleFrontController@province') {
        $bookinTxt = 'เพื่อจองยานพาหนะ';
    }
@endphp
<div id="app-layout" style="background-color:#f7f7fd;">
    <!--====== NAV HEADER PART START ======-->
    {{-- <nav class="navbar navbar-default bg-primary-light" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-image" href="#"><img src="logo-eReservation.png" alt="logo" class="pt-1 pr-1"></a>
            </div>
            <div class="navbar-collapse collapse">

            </div>
            <!--/.nav-collapse -->
        </div>
    </nav> --}}
    <section class="pt-5 bg-image overlay-primary fixed overlay bg-white" style="background-image: url({{ asset('svg/thailand-map2.svg') }}); background-position: center 50px;
    background-size: 55% 55%; max-height:800px; min-height:600px; background-repeat: no-repeat; margin-bottom: 50px;">

        <div class="container" >
            <div class="row">
                <div class="col-md-6 text-center col-centered">
                    <h3>กรุณาเลือกจังหวัด ({{ @$bookinTxt }})</h3>
                </div>
            </div>

            <div class="row mt-20">
                <div class="col-md-6 col-centered">
                    {{ Form::select("st_boss_position_id", \App\Model\StProvince::where('id','<>',1)->where('status', 1)->orderBy('code','asc')->pluck('name', 'code'), '', ['class'=>'form-control goUrl', 'style'=>'display:inline;', 'placeholder'=>'--- เลือกจังหวัด ---']) }}
                </div>
            </div>
            <!--container -->
        </div>
    </section>

    <div style="position: relative;">
        <div class="row"
            style="background-image: url({{ asset('svg/oval-purple.svg') }}); background-position: center 50px; background-size:cover; height:120px; background-repeat: no-repeat; top:-120px; position: absolute; width:100%; margin:0 auto;">
        </div>
    </div>

    <div class="container" style="border-top: 1px solid rgba(151, 151, 151, 0.13);">
        <div class="row mt-20">
            <div class="col-md-7">
                <ul style="list-style: none; padding:0;">
                    <li>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สำนักงานปลัดกระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์</li>
                    <li><i class="fa fa-envelope" style="font-size:14px;"></i><a
                            href="mailto:ictcsupport@m-society.go.th"> ictcsupport@m-society.go.th</a> <i class="fa fa-phone"
                            style="padding-left:20px; padding-right:5px;  font-size:18px;"></i> 0-2202-9001</li>
                </ul>
            </div>
            <div class="col-md-5 text-right" style="font-size: 12px;">
                Copyright © 2019 Version 1.0 กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์ <br> Terms &amp; Conditons | Privacy
                Policy
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
body {
    background-color: #f7f7fd !important;
}
</style>
@endpush

@push('js')
<script>
    $(function(){
        // bind change event to select
        $('select.goUrl').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = 'show?st_province_code='+url; // redirect
            }
            return false;
        });
    });
</script>
@endpush