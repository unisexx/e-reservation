@if ($errors->any())
    <ul class="alert alert-danger list-unstyled">
        <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
        @foreach ($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
    </ul>
@endif


@php
    $st_boss = App\Model\StBoss::where('status', 1)->get();

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

    if(isset($rs->start_time)){
        $sTimeArr = (explode(":",$rs->start_time));
    }

    if(isset($rs->end_time)){
        $eTimeArr = (explode(":",$rs->end_time));
    }
@endphp

<div class="form-group form-inline col-md-12">
    <label>เลือกผู้บริหาร<span class="Txt_red_12"> *</span></label>
    <select name="st_boss_id" class="form-control">
        @foreach ($st_boss as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group form-inline col-md-4">
    <label>ชื่อเรื่อง / หัวข้อการประชุม<span class="Txt_red_12"> *</span></label>
    <input name="title" type="text" class="form-control {{ $errors->has('title') ? 'has-error' : '' }}"  placeholder="ชื่อเรื่อง / หัวข้อการประชุม" value="{{ $rs->title ?? old('title') }}" style="min-width:500px;">
</div>

<div class="form-group form-inline col-md-6">
    <label>สถานะ</label>
    <select name="boss_status" class="form-control" style="width:auto;">
        <option value="1" @if(@$rs->boss_status == '1') selected @endif>เป็นประธาน</option>
        <option value="2" @if(@$rs->boss_status == '2') selected @endif>เป็นรองประธาน</option>
        <option value="3" @if(@$rs->boss_status == '3') selected @endif>เป็นกรรมการ</option>
        <option value="4" @if(@$rs->boss_status == '4') selected @endif>เป็นเกียรติ</option>
    </select></div>

<div class="form-group form-inline col-md-4">
    <label>ชื่อห้องประชุม<span class="Txt_red_12"> *</span></label>
    <input name="room_name" type="text" class="form-control {{ $errors->has('room_name') ? 'has-error' : '' }}"  placeholder="ชื่อห้องประชุม" value="{{ $rs->room_name ?? old('room_name') }}"
        style="min-width:400px;">
</div>

<div class="form-group form-inline col-md-6">
    <label>สถานที่<span class="Txt_red_12"> *</span></label>
    <input name="place" type="text" class="form-control {{ $errors->has('place') ? 'has-error' : '' }}"  placeholder="สถานที่" value="{{ $rs->place ?? old('place') }}" style="width: 100%">
</div>

<div class="form-group form-inline col-md-4">
    <label>ชื่อเจ้าของงาน<span class="Txt_red_12"> *</span></label>
    <input name="owner" type="text" class="form-control {{ $errors->has('title') ? 'has-error' : '' }}"  placeholder="ชื่อเจ้าของงาน" value="{{ $rs->owner ?? old('owner') }}"
        style="min-width:400px;">
</div>

<div class="form-group form-inline col-md-4">
    <label>เบอร์</label>
    <input name="tel" type="text" class="form-control "  placeholder="เบอร์" value="{{ @$rs->tel ?? old('tel') }}" style="min-width:300px;">
</div>

<div class="form-group form-inline col-md-12 input-daterange chkTime">
        <label>วัน เวลา ที่ต้องการจองวาระ<span class="Txt_red_12"> *</span></label>
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
        <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
        <div class="dep-chain-group" style="margin-bottom:5px;">
            <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอจองวาระผู้บริหาร" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" required>

            <input name="request_position" type="text" class="form-control {{ $errors->has('request_position') ? 'has-error' : '' }}" placeholder="ตำแหน่งผู้ขอจองวาระผู้บริหาร" value="{{ isset($rs->request_position) ? $rs->request_position : old('request_position') }}" required>

            <div style="margin-top:5px;">
                <select name="st_department_code" id="lunch" class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" title="กรม" required>
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code" id="lunch" class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" title="สำนัก" required>
                    <option value="">+ สำนัก +</option>
                    @if(old('st_department_code') || isset($rs->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code" id="lunch" class="chain-division selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" title="กลุ่ม" required>
                    <option value="">+ กลุ่ม +</option>
                    @if(old('st_bureau_code') || isset($rs->st_bureau_code))
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

        </div>
        <input name="request_tel" type="text" class="form-control {{ $errors->has('request_tel') ? 'has-error' : '' }}" placeholder="เบอร์โทรศัพท์" value="{{ isset($rs->request_tel) ? $rs->request_tel : old('request_tel') }}" required>
        <input name="request_email" type="text" class="form-control {{ $errors->has('request_email') ? 'has-error' : '' }}" placeholder="อีเมล์" value="{{ isset($rs->request_email) ? $rs->request_email : old('request_email') }}" required style="width:270px;">
    </div>

<div class="form-group form-inline col-md-12">
    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
    <textarea name="note" class="form-control " style="height:80px; width:80%;">{{ $rs->note ?? old('note') }}</textarea>
</div>


{{-- แอดมิน หลังบ้านเห็นเท่านั้น --}}
    @if($formWhere == 'backend')

        {{-- ตรวจสอบการอนุมัติ ห้องเดียวกัน เวลาเดียวกัน ไม่สามารถอนุมัติซ้อนกันได้ --}}
        @php
            $st_boss_id = @$rs->st_boss_id;
            $start_date = @$rs->start_date;
            $end_date = @$rs->end_date;
            $start_time = @$rs->start_time;
            $end_time = @$rs->end_time;
            $id = @$rs->id;

            $chkOverlap = App\Model\BookingBoss::select('*')->where('status', 'อนุมัติ')->where('st_boss_id', $st_boss_id)
                ->where(function ($q) use ($start_date, $end_date) {
                    $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date, $start_date, $end_date, $end_date]);
                })
                ->where(function ($q) use ($start_time, $end_time) {
                    $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time, $start_time, $end_time, $end_time]);
                });

            if (!empty($id)) { // เช็กในกรณีแก้ไข ไม่ให้นับ row ของตัวเอง จะได้หาค่าที่เหลือมกับของคนอื่น
                $chkOverlap = $chkOverlap->where('id', '<>', $id);
            }

            $chkOverlap = $chkOverlap->get();

        @endphp
        <div class="form-group form-inline col-md-12">
            <fieldset>
            <legend>สำหรับเจ้าหน้าที่ดูแลระบบ</legend>
                <div class="col-md-2">
                    <label>สถานะ</label>
                    <select name="status" class="form-control" style="width:100%;" {{ !CanPerm('booking-room-edit')?'disabled':'' }} >
                        <option value="รออนุมัติ" {{ @$rs->status == 'รออนุมัติ' ? 'selected' : ''}}>รออนุมัติ</option>
                        @if($chkOverlap->count() < 1)
                            <option value="อนุมัติ" {{ @$rs->status == 'อนุมัติ' ? 'selected' : ''}}>อนุมัติ</option>
                        @endif
                        <option value="ไม่อนุมัติ" {{ @$rs->status == 'ไม่อนุมัติ' ? 'selected' : ''}}>ไม่อนุมัติ</option>
                        <option value="ยกเลิก" {{ @$rs->status == 'ยกเลิก' ? 'selected' : ''}}>ยกเลิก</option>
                    </select>
                    {!! !CanPerm('booking-room-edit')?'<input type="hidden" name="status" value="'.@$rs->status.'">':'' !!}
                </div>
                <div class="col-md-12">
                    @if($chkOverlap->count() >= 1)
                    <p class="text-danger" style="margin-top:20px;"><b><u>หมายเหตุ</u></b> พบรายการจองในช่วงเวลาที่ซ้ำ ที่มีสถานะเป็นอนุมัติแล้ว ไม่สามารถทำการอนุมัติซ้อนกันได้อีก</p>
                    <ul>
                        @foreach($chkOverlap as $overlap)
                        <li><a href="{{ url('booking-boss/'.$overlap->id.'/edit') }}" target="_blank">{{ $overlap->code }} {{ $overlap->title }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </fieldset>
        </div>
    @endif
    {{-- แอดมิน หลังบ้านเห็นเท่านั้น --}}


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


<script>
    $(document).ready(function() {
        var $formWhere = "{{ $formWhere }}";

        $("#submitFormBtn").click(function(){
            if($formWhere == 'frontend'){
                chkOverlap();
            }else{
                $('form#bookingBossForm').submit();
            }
        });
    });

    // เช็กว่ามีการจองเวลาเหลือมกับรายการที่มีอยู่แล้วหรือไม่
    // ตัวแปร วันที่เริ่ม,เวลาที่เริ่ม,วันที่สิ้นสุด,เวลาที่สิ้นสุด,ไอดีของห้องประชุม
    function chkOverlap(){
        $.ajax({
                url: '{{ url("ajaxBossChkOverlap") }}',
                data: {
                    start_date: $('input[name=start_date]').val(),
                    start_time: $('input[name=start_time]').val(),
                    end_date: $('input[name=end_date]').val(),
                    end_time: $('input[name=end_time]').val(),
                    st_boss_id: $('select[name=st_boss_id]').val(),
                    id: "{{ @$rs->id }}",
                }
            })
            .done(function(data) {
                if( data == 'ไม่เหลื่อม' ){
                    $('form#bookingBossForm').submit();
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
                    <th>ผู้บริหาร</th>
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
        $('form#bookingBossForm').submit();
    });
    $('body').on('click', '#cboxCloseBtn', function() {
        $.colorbox.close();
    });
});
</script>