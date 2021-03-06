<style>
body {
background-image: url("{{ url('images/vehicle-bg.jpg') }}");
background-position: center center;
background-repeat: no-repeat;
background-attachment: fixed;
background-size: cover;
background-color:#464646;
}

/* For mobile devices */
@media only screen and (max-width: 767px) {
body {
        background-image: url("{{ url('images/vehicle-bg.jpg') }}");
    }
}
</style>

<?php
$currDate = date("Y-m-d");
$currTime = date("H:i:s");

$st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();

if (old('st_department_code')) {
    $st_bureaus = App\Model\StBureau::where('code', 'like', old('st_department_code') . '%')->orderBy('code', 'asc')->get();
}

if (old('st_bureau_code')) {
    $st_divisions = App\Model\StDivision::where('code', 'like', old('st_bureau_code') . '%')->orderBy('code', 'asc')->get();
}

if (isset($rs->st_department_code)) {
    $st_bureaus = App\Model\StBureau::where('code', 'like', $rs->st_department_code . '%')->orderBy('code', 'asc')->get();
}

if (isset($rs->st_bureau_code)) {
    $st_divisions = App\Model\StDivision::where('code', 'like', $rs->st_bureau_code . '%')->orderBy('code', 'asc')->get();
}

if (isset($rs->start_time)) {
    $sTimeArr = (explode(":", $rs->start_time));
}

if (isset($rs->end_time)) {
    $eTimeArr = (explode(":", $rs->end_time));
}

if (isset($rs->point_time)) {
    $pTimeArr = (explode(":", $rs->point_time));
}

// หน่วยงานของยานพาหนะ
$req_st_departments = App\Model\StVehicle::select('st_department_code')->where('status', 'พร้อมใช้')->with('department')->distinct()->orderBy('st_department_code', 'asc')->get();

if (old('req_st_department_code')) {
    $req_st_bureaus = App\Model\StVehicle::select('st_bureau_code')->where('st_department_code', 'like', old('req_st_department_code') . '%')->where('status', 'พร้อมใช้')->with('bureau')->distinct()->orderBy('st_bureau_code', 'asc')->get();
}

if (old('req_st_bureau_code')) {
    $req_st_divisions = App\Model\StVehicle::select('st_division_code')->where('st_bureau_code', 'like', old('req_st_bureau_code') . '%')->where('status', 'พร้อมใช้')->with('division')->distinct()->orderBy('st_division_code', 'asc')->get();
}

if (isset($rs->req_st_department_code)) {
    $req_st_bureaus = App\Model\StVehicle::select('st_bureau_code')->where('st_department_code', 'like', $rs->req_st_department_code . '%')->where('status', 'พร้อมใช้')->with('bureau')->distinct()->orderBy('st_bureau_code', 'asc')->get();
}

if (isset($rs->req_st_bureau_code)) {
    $req_st_divisions = App\Model\StVehicle::select('st_division_code')->where('st_bureau_code', 'like', $rs->req_st_bureau_code . '%')->where('status', 'พร้อมใช้')->with('division')->distinct()->orderBy('st_division_code', 'asc')->get();
}
?>

<div class="container bg-body-content">

    @if ($errors->any())
    <ul class="alert alert-danger list-unstyled">
        <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
        @foreach ($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
    </ul>
    @endif


    <div class="form-group form-inline col-md-12">
        <label>วันที่ยื่นคำขอจอง<span class="Txt_red_12"> *</span></label>
        <input name="request_date" type="text" class="form-control datepicker fdate {{ $errors->has('request_date') ? 'has-error' : '' }}" value="{{ isset($rs->request_date) ? DB2Date($rs->request_date) : '' }} {{ old('request_date') ? old('request_date') : @DB2Date($currDate) }}" style="width:120px;" />
        {{-- <input name="request_time" type="text" class="form-control ftime {{ $errors->has('request_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->request_time) ? $rs->request_time : '' }} {{ old('request_time') ? old('request_time') : $currTime }}" style="width:70px;" />
        น. --}}
    </div>


    <div class="form-group form-inline col-md-12 dep-chain-group">
        <label>ขอใช้ยานพาหนะของหน่วยงาน<span class="Txt_red_12"> *</span></label>
        <select name="req_st_department_code" id="lunch" class="chain-department-vehicle selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" data-size="10" title="กรม">
            <option value="">+ กรม +</option>
            @foreach($req_st_departments as $item)
            <option value="{{ $item->st_department_code }}" @if($item->st_department_code == @old('req_st_department_code')) selected="selected" @endif @if($item->st_department_code == @$rs->req_st_department_code) selected="selected" @endif>{{ $item->department->title }}</option>
            @endforeach
        </select>

        <select name="req_st_bureau_code" id="lunch" class="chain-bureau-vehicle selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" data-size="10" title="สำนัก">
            <option value="">+ สำนัก +</option>
            @if(old('req_st_department_code') || isset($rs->req_st_department_code))
            @foreach($req_st_bureaus as $item)
            <option value="{{ $item->st_bureau_code }}" @if($item->st_bureau_code == @old('req_st_bureau_code')) selected="selected" @endif @if($item->st_bureau_code == @$rs->req_st_bureau_code) selected="selected" @endif>{{ $item->bureau->title }}</option>
            @endforeach
            @endif
        </select>

        <select name="req_st_division_code" id="lunch" class="chain-division-vehicle selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" data-size="10" title="กลุ่ม">
            <option value="">+ กลุ่ม +</option>
            @if(old('req_st_bureau_code') || isset($rs->req_st_bureau_code))
            @foreach($req_st_divisions as $item)
            <option value="{{ $item->st_division_code }}" @if($item->st_division_code == @old('req_st_division_code')) selected="selected" @endif @if($item->st_division_code == @$rs->req_st_division_code) selected="selected" @endif>{{ $item->division->title }}</option>
            @endforeach
            @endif
        </select>
    </div>

    <div class="form-group form-inline col-md-12">
        <label>ไปเพื่อ<span class="Txt_red_12"> *</span></label>
        <input name="gofor" type="text" class="form-control {{ $errors->has('gofor') ? 'has-error' : '' }}" style="width:600px;" value="{{ isset($rs->gofor) ? $rs->gofor : old('gofor') }}" />
    </div>

    <div class="form-group form-inline col-md-6">
        <label>จำนวนผู้โดยสาร <span class="Txt_red_12"> *</span></label>
        <input name="number" type="number" min="1" class="form-control numOnly {{ $errors->has('number') ? 'has-error' : '' }}" style="width:100px;" value="{{ isset($rs->number) ? $rs->number : old('number') }}"> คน
    </div>

    <div class="form-group form-inline col-md-12 input-daterange chkTime">
        <label>วัน เวลา ที่ต้องการใช้<span class="Txt_red_12"> *</span></label>
        <input id="sDate" name="start_date" type="text" class="form-control range-date {{ $errors->has('start_date') ? 'has-error' : '' }}" value="{{ isset($rs->start_date) ? DB2Date($rs->start_date) : old('start_date') }}" style="width:120px;" required/>
        <select id="sHour" name="sHour" class="selectpicker" data-size="10" data-live-search="true" required>
            @foreach(getHour() as $item)
            <option value="{{ $item }}" {{ $item == (@$sTimeArr[0] ?? old('sHour')) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        :
        <select id="sMinute" name="sMinute" class="selectpicker" data-size="10" data-live-search="true" required>
            @foreach(getMinute() as $item)
            <option value="{{ $item }}" {{ $item == (@$sTimeArr[1] ?? old('sMinute')) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        น.
        <span style="margin:0 15px;">ถึง</span>
        <input id="eDate" name="end_date" type="text" class="form-control range-date {{ $errors->has('end_date') ? 'has-error' : '' }}" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" style="width:120px;" required/>
        <select id="eHour" name="eHour" class="selectpicker" data-size="10" data-live-search="true" required>
            @foreach(getHour() as $item)
            <option value="{{ $item }}" {{ $item == (@$eTimeArr[0] ?? old('eHour')) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        :
        <select id="eMinute" name="eMinute" class="selectpicker" data-size="10" data-live-search="true" required>
            @foreach(getMinute() as $item)
            <option value="{{ $item }}" {{ $item == (@$eTimeArr[1] ?? old('eMinute')) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        น.

        <input type="hidden" name="start_time" value="{{ isset($rs->start_time) ? $rs->start_time : old('start_time') }}">
        <input type="hidden" name="end_time" value="{{ isset($rs->end_time) ? $rs->end_time : old('end_time') }}">
    </div>

    <div class="form-group form-inline col-md-12">
        <label>สถานที่ขึ้นรถ<span class="Txt_red_12"> *</span></label>
        <div style="margin-bottom:5px;">
            <input name="point_place" type="text" class="form-control {{ $errors->has('point_place') ? 'has-error' : '' }}" placeholder="สถานที่ขึ้นรถ" value="{{ isset($rs->point_place) ? $rs->point_place : old('point_place') }}" style="width:400px;">
            เวลา

            <select id="pHour" name="pHour" class="selectpicker" data-size="10" data-live-search="true" required>
            @foreach(getHour() as $item)
            <option value="{{ $item }}" {{ $item == (@$pTimeArr[0] ?? old('pHour')) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
            </select>
            :
            <select id="pMinute" name="pMinute" class="selectpicker" data-size="10" data-live-search="true" required>
                @foreach(getMinute() as $item)
                <option value="{{ $item }}" {{ $item == (@$pTimeArr[1] ?? old('pMinute')) ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            </select>
            น.

            <input name="point_time" type="hidden" value="{{ isset($rs->point_time) ? $rs->point_time : old('point_time') }}"/>
            <script>
                $(document).ready(function(){
                    $('[name=point_time]').val( $("#pHour").val()+":"+$("#pMinute").val() );

                    $('body').on('change', '#pHour,#pMinute', function(){
                        $('[name=point_time]').val( $("#pHour").val()+":"+$("#pMinute").val() );
                    });
                });
            </script>
        </div>
    </div>

    <div class="form-group form-inline col-md-12">
        <label>สถานที่ไป<span class="Txt_red_12"> *</span></label>
        <input name="destination" type="text" class="form-control {{ $errors->has('destination') ? 'has-error' : '' }}" placeholder="สถานที่ไป" value="{{ isset($rs->destination) ? $rs->destination : old('destination') }}" style="width:400px;">
    </div>

    <div class="form-group form-inline col-md-12">
        <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
        <div class="dep-chain-group" style="margin-bottom:5px;">
            <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอใช้ยานพาหนะ" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" style="min-width:300px;">

            <input name="request_position" type="text" class="form-control {{ $errors->has('request_position') ? 'has-error' : '' }}" placeholder="ตำแหน่งผู้ขอใช้ยานพาหนะ" value="{{ isset($rs->request_position) ? $rs->request_position : old('request_position') }}" style="min-width:300px;">

            <div style="margin-top:5px;">
                <select name="st_department_code" id="lunch" class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" title="กรม" data-size="10">
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code" id="lunch" class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" title="สำนัก" data-size="10">
                    <option value="">+ สำนัก +</option>
                    @if(old('st_department_code') || isset($rs->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code" id="lunch" class="chain-division selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" title="กลุ่ม" data-size="10">
                    <option value="">+ กลุ่ม +</option>
                    @if(old('st_bureau_code') || isset($rs->st_bureau_code))
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

        </div>
        <input name="request_tel" type="text" class="form-control {{ $errors->has('request_tel') ? 'has-error' : '' }}" placeholder="เบอร์โทรศัพท์" value="{{ isset($rs->request_tel) ? $rs->request_tel : old('request_tel') }}" style="min-width:300px;">
        <input name="request_email" type="text" class="form-control {{ $errors->has('request_email') ? 'has-error' : '' }}" placeholder="อีเมล์" value="{{ isset($rs->request_email) ? $rs->request_email : old('request_email') }}" style="min-width:300px;">
    </div>

    <div class="form-group form-inline col-md-12">
        <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
        <textarea name="note" class="form-control " style="min-width:800px; height:80px">{{ isset($rs->note) ? $rs->note : old('note') }}</textarea>
    </div>

    @if($formWhere == 'backend')
    <fieldset class="col-md-12">
        <legend>สำหรับเจ้าหน้าที่ดูแลระบบ</legend>
        <label>สถานะ</label>
        <div class="form-group form-inline col-md-12">
            <select name="status" class="form-control" style="width:auto;">
                <option value="รออนุมัติ" {{ @$rs->status == 'รออนุมัติ' ? 'selected' : ''}}>รออนุมัติ</option>
                <option value="อนุมัติ" {{ @$rs->status == 'อนุมัติ' ? 'selected' : ''}}>อนุมัติ</option>
                <option value="ไม่อนุมัติ" {{ @$rs->status == 'ไม่อนุมัติ' ? 'selected' : ''}}>ไม่อนุมัติ</option>
                <option value="ยกเลิก" {{ @$rs->status == 'ยกเลิก' ? 'selected' : ''}}>ยกเลิก</option>
            </select>
            <span class="note">* กรณีเลือกอนุมัติให้ admin เลือกพนักงานขับรถ และยานพาหนะ</span>
        </div>

        <div id="selectDriver" class="form-group form-inline col-md-12">
            <label>พนักงานขับรถ</label>
            <span class="form-inline">
                <select name="st_driver_id" class="form-control {{ $errors->has('st_driver_id') ? 'has-error' : '' }}" required>
                    <option value="">+ พนักงานขับรถ +</option>
                </select>

                <span id="selectVehicleBlock">
                    <input id="tmpStVehicleName" name="tmpStVehicleName" type="text" class="form-control {{ $errors->has('st_vehicle_id') ? 'has-error' : '' }}" style="min-width:400px;" readonly="readonly" value="@if(isset($rs->st_vehicle_id)) {{$rs->st_vehicle->st_vehicle_type->name}} {{$rs->st_vehicle->brand}} {{!empty($rs->st_vehicle->seat)?$rs->st_vehicle->seat:'-'}} ที่นั่ง สี{{$rs->st_vehicle->color}} ทะเบียน {{$rs->st_vehicle->reg_number}} @else {{ old('tmpStVehicleName') }} @endif">
                    <input type="hidden" name="st_vehicle_id" value="{{ isset($rs->st_vehicle_id) ? $rs->st_vehicle_id : old('st_vehicle_id') }}">
                    <a id="openCbox" class='inline' href="#inline_vehicle"><input type="button" title="เลือกยานพาหนะ" value="เลือกยานพาหนะ" class="btn btn-info vtip" /></a>
                </span>
            </span>
        </div>
    </fieldset>
    @endif



    @if($formWhere == 'frontend')
    <div class="form-group form-inline col-md-12">
        <label>กรุณาใส่ผลบวกที่ถูกต้อง<span class="Txt_red_12"> *</span></label>
        <span class="form-inline">
            {!! captcha_img() !!}
            <input class="form-control" type="text" name="captcha" style="width:100px;">
        </span>
    </div>
    @endif

    <div class="form-group form-inline col-md-12">
        <div id="btnBoxAdd">
            <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
            <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="window.history.go(-1); return false;" class="btn btn-default" style="width:100px;" />
        </div>
    </div>

</div>
{{-- END CONTAINER --}}




<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
    <div id='inline_vehicle' style='padding:5px; background:#fff;'>
        <h3 style="margin:0; padding:0; color:#636">เลือกยานพาหนะ</h3>
        <div id="search">
            <div id="searchBox">
                <form class="form-inline">
                    <input id="searchTxt" type="text" class="form-control" style="width:400px; display:inline;" placeholder="ชื่อพนักงานขับรถ / รายละเอียดรถ" />
                    <button id="searchBtn" type="button" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
                </form>
            </div>
        </div>

        <table class="tblist">
            <thead>
                <tr>
                    <th style="width:10%">ลำดับ</th>
                    <th style="width:10%">ภาพยานพาหนะ</th>
                    <th style="width:30%">ประเภท / ยี่ห้อ / ที่นั่ง / สี / เลขทะเบียน</th>
                    {{-- <th style="width:20%">พนักงานขับวันนี้</th> --}}
                    <th style="width:10%">สถานะ</th>
                    <th>หมายเหตุ</th>
                    <th>เลือก</th>
                </tr>
            </thead>
            <tbody id="getData">
                <!-- ajaxGetVehicle Data Here -->
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function() {
        // เช็กสถานะ
        chkStatus();

        // กดเปลี่ยนสถานะ
        $('body').on('change', 'select[name=status]', function() {
            chkStatus();
        });

        // โชว์รายการยานพาหนะตอนกดปุ่มเลือกห้องประชุม
        $('#openCbox').click(function() {
            $('#searchBtn').trigger('click');
        });

        // ค้นหายานพาหนะ
        $('body').on('click', '#searchBtn', function() {
            $('#getData').html('<i class="fas fa-spinner fa-pulse"></i>');

            $.ajax({
                    url: '{{ url("ajaxGetVehicle") }}',
                    data: {
                        search: $("#searchTxt").val(),
                        req_st_department_code: $('select[name=req_st_department_code]').val(),
                        req_st_bureau_code: $('select[name=req_st_bureau_code]').val(),
                        req_st_division_code: $('select[name=req_st_division_code]').val(),
                        booking_vehicle_id: "{{ @$rs->id }}",
                    }
                })
                .done(function(data) {
                    // console.log(data);
                    $('#getData').html(data);
                });
        });

        // กดปุ่มเลือกยานพาหนะ
        $('body').on('click', '.selectVehicleBtn', function() {
            // alert($(this).data('vehicle-id'));
            $('#tmpStVehicleName').val($(this).data('vehicle-name'));
            $('input[name=st_vehicle_id]').val($(this).data('vehicle-id'));
            // $('select[name=st_driver_id]').val($(this).data('st-driver-id'));
            // ปิด colorbox
            $.colorbox.close();
        });

        $("#submitFormBtn").click(function() {
            chkOverlap();
        });
    });

    // ถ้าสถานะอนุมัติ ให้เลือกยานพาหนะ, สถานะอื่น ซ่อน
    function chkStatus() {
        var status = $('select[name=status]').val();
        if (status == 'อนุมัติ') {
            $('#selectVehicleBlock').show();
            $('#selectDriver').show();
        } else {
            $('#selectVehicleBlock').hide();
            $('#selectDriver').hide();
        }
    }

    // เช็กว่ามีการจองเวลาเหลือมกับรายการที่มีอยู่แล้วหรือไม่
    // ตัวแปร วันที่เริ่ม,เวลาที่เริ่ม,วันที่สิ้นสุด,เวลาที่สิ้นสุด,ไอดีของห้องประชุม
    function chkOverlap() {
        $.ajax({
                url: '{{ url("ajaxVehicleChkOverlap") }}',
                data: {
                    start_date: $('input[name=start_date]').val(),
                    start_time: $('input[name=start_time]').val(),
                    end_date: $('input[name=end_date]').val(),
                    end_time: $('input[name=end_time]').val(),
                    st_vehicle_id: $('input[name=st_vehicle_id]').val(),
                    id: "{{ @$rs->id }}",
                }
            })
            .done(function(data) {
                if( data == 'ไม่เหลื่อม' ){
                    $('form').submit();
                }else{
                    $('#getDupData').html(data);
                    $.colorbox({inline:true, width:"95%", height:"95%", open:true, href:"#inline_dup" });
                }
            });
    }
</script>

<script>
$('.input-daterange').datepicker({
    inputs: $('.range-date'),
    format: 'dd/mm/yyyy',
    autoclose: true,
    language: 'th-th',
    clearBtn: true,
});
$('.range-date').each(function(k, v) {
    $(this).addClass('form-control').css({
        'display': 'inline-block',
        'width': '120px'
    }); //.attr('readonly',true);
    $(this).attr('placeholder', (!$(this).attr('placeholder') ? 'วัน/เดือน/ปี' : $(this).attr('placeholder')));
    $(this).after(' <img src="{{url('images/calendar.png')}}" alt="" width="24" height="24" /> ');
});
</script>


<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
    <div id='inline_dup' style='padding:5px; background:#fff;'>
        <h3 style="margin:0 0 25px 0; padding:0; color:#636">พบรายการจองในช่วงเวลาที่ซ้ำ</h3>

        <table class="tblist">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสการจอง</th>
                    <th>ไปเพื่อ / รายละเอียดรถ / ชื่อผู้ขับ</th>
                    <th>วันที่</th>
                    <th>จุดขึ้นรถ</th>
                    <th>สถานที่ไป</th>
                    <th>ผู้ขอใช้ยานพาหนะ</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody id="getDupData">
                <!-- chkOverlap Data Here -->
            </tbody>
        </table>

        <div id="btnBoxAdd">
            <input id="confirmSubmitBtn" name="input" type="button" title="ยืนยันการจอง" value="ยืนยันการจอง" class="btn btn-primary" style="width:100px;" />
            <input id="cboxCloseBtn" name="input" type="button" title="ยกเลิก" value="ยกเลิก" class="btn btn-secondary" style="width:100px;" />
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('body').on('click', '#confirmSubmitBtn', function() {
        $('form').submit();
    });
    $('body').on('click', '#cboxCloseBtn', function() {
        $.colorbox.close();
    });
});
</script>

<script>
$(document).ready(function(){
    // ถ้ามีการเปลี่ยนแปลงข้อมูล ขอใช้ยานพาหนะของหน่วยงาน ให้เคลียร์ค่า เลือกยานพาหนะ เป็นค่าว่าง
    $('body').on('change', 'select[name=req_st_department_code], select[name=req_st_bureau_code], select[name=req_st_division_code]', function(){
        $('input[name=tmpStVehicleName], input[name=st_vehicle_id]').val("");
    });
});
</script>

<script>
$(document).ready(function(){
    getDriver();
    $('body').on('change', 'select[name=req_st_department_code], select[name=req_st_bureau_code], select[name=req_st_division_code]', function() {
        getDriver();
    });
});

function getDriver(){
    if( $('select[name=st_department_code]').val() != ''){
        $('select[name=st_driver_id]').empty();
        var selectedDriver = "{{ @$rs->st_driver_id }}";
        $.ajax({
            url: '{{ url("ajaxGetDriver") }}',
            data: {
                st_department_code: $('select[name=req_st_department_code]').val(),
                st_bureau_code: $('select[name=req_st_bureau_code]').val(),
                st_division_code: $('select[name=req_st_division_code]').val()
            }
        })
        .done(function(data) {
            $.map(data, function(i) {
                $('select[name=st_driver_id]').append('<option value="' + i.id + '">' + i.name + '</option>');
            });

            // console.log(selectedDriver);
            if(selectedDriver.length > 0){
                $("select[name=st_driver_id]").val(selectedDriver);
            }
        });
    }
}
</script>