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
    <input type="text" class="form-control" placeholder="Generate Auto" readonly="readonly" value="{{ isset($rs->id) ? 'RR'.sprintf('%05d', $rs->id) : '' }}"> /

    <input id="tmpStRoomName" type="text" class="form-control {{ $errors->has('st_room_id') ? 'has-error' : '' }}" style="min-width:400px;" readonly="readonly" value="{{ isset($rs->st_room_id) ? $rs->st_room->name : '' }}" required >
    <input type="hidden" name="st_room_id" value="{{ isset($rs->st_room_id) ? $rs->st_room_id : old('st_room_id') }}">
    <a class='inline' href="#inline_room"><input type="button" title="เลือกห้องประชุม" value="เลือกห้องประชุม" class="btn btn-info vtip" /></a>
</div>


<div class="form-group form-inline col-md-12">
    <label>ชื่อเรื่อง / หัวข้อการประชุม<span class="Txt_red_12"> *</span></label>
    <input name="title" type="text" class="form-control {{ $errors->has('title') ? 'has-error' : '' }}" placeholder="ชื่อห้องประชุม" value="{{ isset($rs->title) ? $rs->title : old('title') }}" style="min-width:500px;" required>
</div>

<div class="form-group form-inline col-md-12">
    <label>วัน เวลา ที่ต้องการใช้ห้องประชุม<span class="Txt_red_12"> *</span> / จำนวนผู้เข้าร่วมประชุม<span class="Txt_red_12"> *</span></label>
    <input name="start_date" type="text" class="form-control datepicker fdate {{ $errors->has('start_date') ? 'has-error' : '' }}" value="{{ isset($rs->start_date) ? DB2Date($rs->start_date) : old('start_date') }}" style="width:120px;" required/>
    <input name="start_time" type="text" class="form-control ftime {{ $errors->has('start_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->start_time) ? $rs->start_time : old('start_time') }}" style="width:70px;" required/>
    น.
    -
    <input name="end_date" type="text" class="form-control datepicker fdate {{ $errors->has('end_date') ? 'has-error' : '' }}" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" style="width:120px;" required/>
    <input name="end_time" type="text" class="form-control ftime {{ $errors->has('end_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->end_time) ? $rs->end_time : old('end_time') }}" style="width:70px;" required/>
    น
    /
    <input name="number" type="number" min="1" class="form-control {{ $errors->has('number') ? 'has-error' : '' }}" placeholder="จำนวน" value="{{ isset($rs->number) ? $rs->number : old('number') }}" style="width:100px;" required>
    คน
</div>

<div class="form-group form-inline col-md-12">
    <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
    <div style="margin-bottom:5px;">
        <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอใช้ห้องประชุม" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" style="min-width:300px;" required>

        <select name="st_department_code" id="lunch" class="selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" title="กรม" required>
            <option value="">+ กรม +</option>
            @foreach($st_departments as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
        </select>

        <select name="st_bureau_code" id="lunch" class="selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" title="สำนัก" required>
            <option value="">+ สำนัก +</option>
            @if(old('st_department_code') || isset($rs->st_department_code))
            @foreach($st_bureaus as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

        <select name="st_division_code" id="lunch" class="selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" title="กลุ่ม" required>
            <option value="">+ กลุ่ม +</option>
            @if(old('st_bureau_code') || isset($rs->st_bureau_code))
            @foreach($st_divisions as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

    </div>
    <input name="request_tel" type="text" class="form-control {{ $errors->has('request_tel') ? 'has-error' : '' }}" placeholder="เบอร์โทรศัพท์" value="{{ isset($rs->request_tel) ? $rs->request_tel : old('request_tel') }}" style="min-width:300px;" required>
    <input name="request_email" type="text" class="form-control {{ $errors->has('request_email') ? 'has-error' : '' }}" placeholder="อีเมล์" value="{{ isset($rs->request_email) ? $rs->request_email : old('request_email') }}" style="min-width:300px;" required>
</div>

<div class="form-group form-inline col-md-12">
    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
    <textarea name="note" class="form-control " style="min-width:800px; height:80px">{{ isset($rs->note) ? $rs->note : old('note') }}</textarea>
</div>

<div class="form-group form-inline col-md-12">
    <label>สถานะ</label>
    <select name="status" class="form-control" style="width:auto;">
        <option value="รออนุมัติ" {{ @$rs->status == 'รออนุมัติ' ? 'selected' : ''}}>รออนุมัติ</option>
        <option value="อนุมัติ" {{ @$rs->status == 'อนุมัติ' ? 'selected' : ''}}>อนุมัติ</option>
        <option value="ไม่อนุมัติ" {{ @$rs->status == 'ไม่อนุมัติ' ? 'selected' : ''}}>ไม่อนุมัติ</option>
        <option value="ยกเลิก" {{ @$rs->status == 'ยกเลิก' ? 'selected' : ''}}>ยกเลิก</option>
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