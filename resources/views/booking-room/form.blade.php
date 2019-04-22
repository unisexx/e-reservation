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
    <label>รหัสการจอง / เลือกห้องประชุม<span class="Txt_red_12"> *</span></label>
    <input type="text" class="form-control" placeholder="Generate Auto" readonly="readonly"> /

    <input id="tmpStRoomName" type="text" class="form-control" style="min-width:400px;" readonly="readonly">
    <input type="hidden" name="st_room_id" value="">
    <a class='inline' href="#inline_room"><input type="button" title="เลือกห้องประชุม" value="เลือกห้องประชุม" class="btn btn-info vtip" /></a>
</div>


<div class="form-group form-inline col-md-12">
    <label>ชื่อเรื่อง / หัวข้อการประชุม<span class="Txt_red_12"> *</span></label>
    <input type="text" class="form-control " placeholder="ชื่อห้องประชุม" value="" style="min-width:500px;">
</div>

<div class="form-group form-inline col-md-12">
    <label>วัน เวลา ที่ต้องการใช้ห้องประชุม<span class="Txt_red_12"> *</span> / จำนวนผู้เข้าร่วมประชุม<span class="Txt_red_12"> *</span></label>
    <input type="text" class="form-control datepicker fdate" value="" style="width:120px;" />
    <input type="text" class="form-control ftime" placeholder="เวลา" value="" style="width:70px;" />
    น.
    -
    <input type="text" class="form-control datepicker fdate" value="" style="width:120px;" />
    <input type="text" class="form-control ftime" placeholder="เวลา" value="" style="width:70px;" />
    น
    /
    <input type="text" class="form-control " placeholder="จำนวน" value="" style="width:100px;">
    คน
</div>

<div class="form-group form-inline col-md-12">
    <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
    <div style="margin-bottom:5px;">
        <input type="text" class="form-control " placeholder="ชื่อผู้ขอใช้ห้องประชุม" value="" style="min-width:300px;">

        <select name="st_department_code" id="lunch" class="selectpicker" data-live-search="true" title="กรม" required>
            <option value="">+ กรม +</option>
            @foreach($st_departments as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
        </select>

        <select name="st_bureau_code" id="lunch" class="selectpicker" data-live-search="true" title="สำนัก" required>
            <option value="">+ สำนัก +</option>
            @if(old('st_department_code') || isset($rs->st_department_code))
            @foreach($st_bureaus as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

        <select name="st_division_code" id="lunch" class="selectpicker" data-live-search="true" title="กลุ่ม" required>
            <option value="">+ กลุ่ม +</option>
            @if(old('st_bureau_code') || isset($rs->st_bureau_code))
            @foreach($st_divisions as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

    </div>
    <input type="text" class="form-control " placeholder="เบอร์โทรศัพท์" value="" style="min-width:300px;">
    <input type="text" class="form-control " placeholder="อีเมล์" value="" style="min-width:300px;">
</div>

<div class="form-group form-inline col-md-12">
    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
    <textarea class="form-control " style="min-width:800px; height:80px"></textarea>
</div>

<div class="form-group form-inline col-md-12">
    <label>สถานะ</label>
    <select name="select" class="form-control" style="width:auto;">
        <option selected="selected">รออนุมัติ</option>
        <option>อนุมัติ</option>
        <option>ไม่อนุมัติ</option>
        <option>ยกเลิก</option>
    </select>
</div>

<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-vehicle-type') }}'" class="btn btn-default" style="width:100px;" />
</div>




<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
    <div id='inline_room' style='padding:5px; background:#fff;'>
        <h3 style="margin:0; padding:0; color:#636">เลือกห้องประชุม</h3>
        <div id="search">
            <div id="searchBox">
                <form class="form-inline">
                    <input id="searchTxt" type="text" class="form-control" style="width:400px; display:inline;" placeholder="ชื่อห้องประชุม" />
                    <button id="searchRoomBtn" type="button" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
                </form>
            </div>
        </div>

        <table class="tblist">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ภาพห้องประชุม</th>
                    <th style="width:30%">ชื่อห้องประชุม</th>
                    <th style="width:40%">รายละเอียด</th>
                    <th>เลือก</th>
                </tr>
            </thead>
            <tbody id="getRoomData">
                <!-- ajaxGetRoom Data Here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        // ค้นหาห้องประชุม
        $('body').on('click', '#searchRoomBtn', function() {
            $('#getRoomData').html('<i class="fas fa-spinner fa-pulse"></i>');

            $.ajax({
                    url: '{{ url("ajaxGetRoom") }}',
                    data: {
                        search: $("#searchTxt").val(),
                    }
                })
                .done(function(data) {
                    // console.log(data);
                    $('#getRoomData').html(data);
                });
        });

        // กดปุ่มเลือกห้องประชุม
        $('body').on('click', '.selectRoomBtn', function() {
            // alert($(this).data('room-id'));
            $('#tmpStRoomName').val($(this).data('room-name'));
            $('input[name=st_room_id]').val($(this).data('room-id'));
            // ปิด colorbox
            $.colorbox.close();
        });
    });
</script>