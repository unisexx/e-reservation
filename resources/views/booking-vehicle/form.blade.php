<?php
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
?>




<div class="form-group form-inline col-md-12">
    <label>ไปเพื่อ<span class="Txt_red_12"> *</span></label>
    <input name="gofor" type="text" class="form-control {{ $errors->has('gofor') ? 'has-error' : '' }}" style="width:600px;" value="{{ isset($rs->gofor) ? $rs->gofor : old('gofor') }}"/>
</div>

<div class="form-group form-inline col-md-6">
    <label>จำนวนผู้โดยสาร <span class="Txt_red_12"> *</span></label>
    <input name="number" type="number" min="1" class="form-control numOnly {{ $errors->has('number') ? 'has-error' : '' }}" style="width:100px;" value="{{ isset($rs->number) ? $rs->number : old('number') }}"> คน
</div>

<div class="form-group form-inline col-md-12">
    <label>วันที่ยื่นคำขอจอง<span class="Txt_red_12"> *</span></label>
    <input name="request_date" type="text" class="form-control datepicker fdate {{ $errors->has('request_date') ? 'has-error' : '' }}" value="{{ isset($rs->request_date) ? DB2Date($rs->request_date) : old('request_date') }}" style="width:120px;" />
    <input name="request_time" type="text" class="form-control ftime {{ $errors->has('request_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->request_time) ? $rs->request_time : old('request_time') }}" style="width:70px;" readonly />
    น.
</div>

<div class="form-group form-inline col-md-6">
    <label>วันที่จะไป (ขอใช้)<span class="Txt_red_12"> *</span></label>
    <input name="start_date" type="text" class="form-control datepicker fdate {{ $errors->has('start_date') ? 'has-error' : '' }}" value="{{ isset($rs->start_date) ? DB2Date($rs->start_date) : old('start_date') }}" style="width:120px;" />
    <input name="start_time" type="text" class="form-control ftime {{ $errors->has('start_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->start_time) ? $rs->start_time : old('start_time') }}" style="width:70px;" />
    น.
</div>
<div class="form-group form-inline col-md-6">
    <label>วันที่จะกลับ<span class="Txt_red_12"> *</span></label>
    <input name="end_date" type="text" class="form-control datepicker fdate {{ $errors->has('end_date') ? 'has-error' : '' }}" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" style="width:120px;" />
    <input name="end_time" type="text" class="form-control ftime {{ $errors->has('end_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->end_time) ? $rs->end_time : old('end_time') }}" style="width:70px;" />
    น.
</div>

<div class="form-group form-inline col-md-12">
    <label>สถานที่ขึ้นรถ<span class="Txt_red_12"> *</span></label>
    <div style="margin-bottom:5px;">
        <input name="point_place" type="text" class="form-control {{ $errors->has('point_place') ? 'has-error' : '' }}" placeholder="สถานที่ขึ้นรถ" value="{{ isset($rs->point_place) ? $rs->point_place : old('point_place') }}" style="width:400px;"> 
        เวลา<input name="point_time" type="text" class="form-control ftime {{ $errors->has('point_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->point_time) ? $rs->point_time : old('point_time') }}" style="width:70px;" /> น.
    </div>
</div>

<div class="form-group form-inline col-md-12">
    <label>สถานที่ไป<span class="Txt_red_12"> *</span></label>
    <input name="destination" type="text" class="form-control {{ $errors->has('destination') ? 'has-error' : '' }}" placeholder="สถานที่ไป" value="{{ isset($rs->destination) ? $rs->destination : old('destination') }}" style="width:400px;">
</div>

<div class="form-group form-inline col-md-12">
    <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
    <div style="margin-bottom:5px;">
        <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอใช้ยานพาหนะ" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" style="min-width:300px;">

        <select name="st_department_code" id="lunch" class="selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" title="กรม" >
            <option value="">+ กรม +</option>
            @foreach($st_departments as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
        </select>

        <select name="st_bureau_code" id="lunch" class="selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" title="สำนัก" >
            <option value="">+ สำนัก +</option>
            @if(old('st_department_code') || isset($rs->st_department_code))
            @foreach($st_bureaus as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

        <select name="st_division_code" id="lunch" class="selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" title="กลุ่ม" >
            <option value="">+ กลุ่ม +</option>
            @if(old('st_bureau_code') || isset($rs->st_bureau_code))
            @foreach($st_divisions as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

    </div>
    <input name="request_tel" type="text" class="form-control {{ $errors->has('request_tel') ? 'has-error' : '' }}" placeholder="เบอร์โทรศัพท์" value="{{ isset($rs->request_tel) ? $rs->request_tel : old('request_tel') }}" style="min-width:300px;">
    <input name="request_email" type="text" class="form-control {{ $errors->has('request_email') ? 'has-error' : '' }}" placeholder="อีเมล์" value="{{ isset($rs->request_email) ? $rs->request_email : old('request_email') }}" style="min-width:300px;">
</div>

<div class="form-group form-inline col-md-12">
    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
    <textarea name="note" class="form-control " style="min-width:800px; height:80px">{{ isset($rs->note) ? $rs->note : old('note') }}</textarea>
</div>


<div class="form-group form-inline col-md-12">
<fieldset>
    <legend>สำหรับเจ้าหน้าที่ดูแลระบบ</legend>
        <label>สถานะ</label>
        <select name="status" class="form-control" style="width:auto;">
            <option value="รออนุมัติ" {{ @$rs->status == 'รออนุมัติ' ? 'selected' : ''}} style="color:{{ colorStatus('รออนุมัติ') }}">รออนุมัติ</option>
            <option value="อนุมัติ" {{ @$rs->status == 'อนุมัติ' ? 'selected' : ''}} style="color:{{ colorStatus('อนุมัติ') }}">อนุมัติ</option>
            <option value="ไม่อนุมัติ" {{ @$rs->status == 'ไม่อนุมัติ' ? 'selected' : ''}} style="color:{{ colorStatus('ไม่อนุมัติ') }}">ไม่อนุมัติ</option>
            <option value="ยกเลิก" {{ @$rs->status == 'ยกเลิก' ? 'selected' : ''}} style="color:{{ colorStatus('ยกเลิก') }}">ยกเลิก</option>
        </select>
        
        <span id="selectVehicleBlock">
            <input id="tmpStVehicleName" type="text" class="form-control {{ $errors->has('st_vehicle_id') ? 'has-error' : '' }}" style="min-width:400px;" readonly="readonly" value="@if(isset($rs->st_vehicle_id)) {{$rs->st_vehicle->st_vehicle_type->name}} {{$rs->st_vehicle->brand}} {{!empty($rs->st_vehicle->seat)?$rs->st_vehicle->seat:'-'}} ที่นั่ง สี{{$rs->st_vehicle->color}} ทะเบียน {{$rs->st_vehicle->reg_number}} @endif">
            <input type="hidden" name="st_vehicle_id" value="{{ isset($rs->st_vehicle_id) ? $rs->st_vehicle_id : old('st_vehicle_id') }}">
            <a id="openCbox" class='inline' href="#inline_vehicle"><input type="button" title="เลือกยานพาหนะ" value="เลือกยานพาหนะ" class="btn btn-info vtip" /></a>
            <span class="note">* กรณีเลือกอนุมัติให้ admin เลือกยานพาหนะ</span>
        </span>
    </fieldset>
</div>

<div class="form-group form-inline col-md-12">
    <div id="btnBoxAdd">
        <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
        <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/booking-vehicle') }}'" class="btn btn-default" style="width:100px;" />
    </div>
</div>



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
                    <th style="width:20%">พนักงานขับวันนี้</th>
                    <th style="width:10%">สถานะ</th>
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
        // chkStatus();

        // กดเปลี่ยนสถานะ
        // $('body').on('change', 'select[name=status]', function() {
        //     chkStatus();
        // });

        // โชว์รายการยานพาหนะตอนกดปุ่มเลือกห้องประชุม
        $('#openCbox').click(function(){
            $('#searchBtn').trigger('click');
        });

        // ค้นหายานพาหนะ
        $('body').on('click', '#searchBtn', function() {
            $('#getData').html('<i class="fas fa-spinner fa-pulse"></i>');

            $.ajax({
                    url: '{{ url("ajaxGetVehicle") }}',
                    data: {
                        search: $("#searchTxt").val(),
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
            // ปิด colorbox
            $.colorbox.close();
        });

        $("#submitFormBtn").click(function(){
            chkOverlap();
        });
    });

    // ถ้าสถานะอนุมัติ ให้เลือกยานพาหนะ, สถานะอื่น ซ่อน
    function chkStatus(){
        var status = $('select[name=status]').val();
        if(status == 'อนุมัติ'){
            $('#selectVehicleBlock').show();
        }else{
            $('#selectVehicleBlock').hide();
        }
    }

    // เช็กว่ามีการจองเวลาเหลือมกับรายการที่มีอยู่แล้วหรือไม่
    // ตัวแปร วันที่เริ่ม,เวลาที่เริ่ม,วันที่สิ้นสุด,เวลาที่สิ้นสุด,ไอดีของห้องประชุม
    function chkOverlap(){
        if(chkEndDateTime() == false){
            alert('วันเวลาที่จะกลับห้ามน้อยกว่าวันเวลาที่จะไป');
            $('input[name=end_date]').focus();
            return false;
        }
        
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
                console.log(data);
                if( data == 'เหลื่อม' ){
                    var r = confirm("ช่วงเวลาการจองของท่าน ซ้อนกับรายการจองอื่น ท่านต้องการยืนยันการจองนี้หรือไม่");
                    if (r == true) { // คลิกตกลง
                        // txt = "You pressed OK!";
                        $('form').submit();
                    } else { // คลิกยกเลิก
                        // txt = "You pressed Cancel!";
                        $('input[name=start_time]').focus();
                        $('input[name=start_time]').css('border-color','#a94442');
                    }
                }else if(data == 'ไม่เหลื่อม'){
                    $('form').submit();
                }
            });
    }

    // เช็กวันที่กลับน้อยกว่าวันที่ไปหรือไม่
    function chkEndDateTime(){
        startDate = $('input[name=start_date]').val()+' '+$('input[name=start_time]').val();
        endDate = $('input[name=end_date]').val()+' '+$('input[name=end_time]').val();
        // console.log(startDate);
        // console.log(endDate);
        // console.log(toTimestamp(startDate));
        // console.log(toTimestamp(endDate));

        // ถ้า start_date น้อยกว่า  end_date
        if(startDate > endDate){
            return false;
        }
    }

    function toTimestamp(strDate){
        var datum = Date.parse(strDate);
        return datum/1000;
    }
</script>