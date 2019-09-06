<?php
// $st_resources = App\Model\StResource::where('status','1')->orderBy('id', 'asc')->get();

$q = App\Model\StResource::select('*')->where('status', '1');
/**
 * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
 */
if (CanPerm('access-self')) {
    $q = $q->where('st_division_code',Auth::user()->st_division_code);
}
$st_resources = $q->orderBy('id','desc')->get();


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
    <label>ทรัพยากร<span class="Txt_red_12"> *</span></label>
    <select name="st_resource_id" class="form-control" style="width:auto;">
        @foreach($st_resources as $row)
        <option value="{{ $row->id }}" @if($row->id == @$rs->st_resource_id) selected @endif @if($row->id == @old('st_resource_id')) selected="selected" @endif >{{ $row->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group form-inline col-md-12">
    <label>ชื่อเรื่อง<span class="Txt_red_12"> *</span></label>
    <input name="title" type="text" class="form-control {{ $errors->has('title') ? 'has-error' : '' }}" placeholder="ชื่อเรื่อง" value="{{ isset($rs->title) ? $rs->title : old('title') }}" style="min-width:500px;" required>
</div>

<div class="form-group form-inline col-md-12 input-daterange">
    <label>วัน เวลา ที่ต้องการใช้<span class="Txt_red_12"> *</span></label>
    <input name="start_date" type="text" class="form-control fdate {{ $errors->has('start_date') ? 'has-error' : '' }}" value="{{ old('start_date') ? old('start_date') : @DB2Date($_GET['start_date']) }}" style="width:120px;" required/>
    <input name="start_time" type="text" class="form-control ftime {{ $errors->has('start_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->start_time) ? $rs->start_time : old('start_time') }}" style="width:70px;" required/>
    น.
    -
    <input name="end_date" type="text" class="form-control fdate {{ $errors->has('end_date') ? 'has-error' : '' }}" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" style="width:120px;" required/>
    <input name="end_time" type="text" class="form-control ftime {{ $errors->has('end_time') ? 'has-error' : '' }}" placeholder="เวลา" value="{{ isset($rs->end_time) ? $rs->end_time : old('end_time') }}" style="width:70px;" required/>
    น.
</div>

<div class="form-group form-inline col-md-12">
    <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
    <div style="margin-bottom:5px;">
        <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอใช้" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" style="min-width:300px;" required>

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
<fieldset>
    <legend>สำหรับเจ้าหน้าที่ดูแลระบบ</legend>
        <label>สถานะ</label>
        <select name="status" class="form-control" style="width:auto;">
            <option value="รออนุมัติ" {{ @$rs->status == 'รออนุมัติ' ? 'selected' : ''}}>รออนุมัติ</option>
            <option value="อนุมัติ" {{ @$rs->status == 'อนุมัติ' ? 'selected' : ''}}>อนุมัติ</option>
            <option value="ไม่อนุมัติ" {{ @$rs->status == 'ไม่อนุมัติ' ? 'selected' : ''}}>ไม่อนุมัติ</option>
            <option value="ยกเลิก" {{ @$rs->status == 'ยกเลิก' ? 'selected' : ''}}>ยกเลิก</option>
        </select>
    </fieldset>
</div>

<div id="btnBoxAdd">
    <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/booking-room') }}'" class="btn btn-default" style="width:100px;" />
</div>

<script>
    $(document).ready(function() {

        $("#submitFormBtn").click(function(){
            chkOverlap();
        });
    });

    // เช็กว่ามีการจองเวลาเหลือมกับรายการที่มีอยู่แล้วหรือไม่
    // ตัวแปร วันที่เริ่ม,เวลาที่เริ่ม,วันที่สิ้นสุด,เวลาที่สิ้นสุด,ไอดีของห้องประชุม
    function chkOverlap(){
        $.ajax({
                url: '{{ url("ajaxResourceChkOverlap") }}',
                data: {
                    start_date: $('input[name=start_date]').val(),
                    start_time: $('input[name=start_time]').val(),
                    end_date: $('input[name=end_date]').val(),
                    end_time: $('input[name=end_time]').val(),
                    st_resource_id: $('select[name=st_resource_id]').val(),
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
    inputs: $('.fdate'),
    format: 'dd/mm/yyyy',
    autoclose: true,
    language: 'th-th',
    clearBtn: true,
});
$('.fdate').each(function(k, v) {
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
                    <th>ทรัพยากร</th>
                    <th>หัวข้อ</th>
                    <th>วัน เวลา ที่ต้องการใช้</th>
                    <th>ผู้ขอใช้</th>
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