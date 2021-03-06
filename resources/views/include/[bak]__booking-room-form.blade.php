<style>
body {
background-image: url("{{ url('images/room-bg.jpg') }}");
background-position: center center;
background-repeat: no-repeat;
background-attachment: fixed;
background-size: cover;
background-color:#464646;
}

/* For mobile devices */
@media only screen and (max-width: 767px) {
body {
        background-image: url("{{ url('images/room-bg.jpg') }}");
    }
}
</style>

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

if(isset($rs->start_time)){
    $sTimeArr = (explode(":",$rs->start_time));
}

if(isset($rs->end_time)){
    $eTimeArr = (explode(":",$rs->end_time));
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

    @if($formWhere == 'backend')
    <div class="form-group form-inline col-md-12">
        <label>รหัสการจอง</label>
        <input type="text" class="form-control" placeholder="Generate Auto" readonly="readonly" value="{{ isset($rs->code) ? $rs->code : '' }}">
    </div>
    @endif

    <div class="form-group form-inline col-md-12">
        <label>เลือกห้องประชุม<span class="Txt_red_12"> *</span></label>
        <input id="tmpStRoomName" name="tmpStRoomName" type="text" class="form-control {{ $errors->has('tmpStRoomName') ? 'has-error' : '' }}" readonly="readonly" value="{{ isset($rs->st_room_id) ? $rs->st_room->name : old('tmpStRoomName') }}" style="width:80%;" required>

        <input type="hidden" name="st_room_over_people" value="{{ $rs->st_room_over_people ?? old('st_room_over_people')}}">
        <input type="hidden" name="st_room_id" value="{{ $rs->st_room_id ?? old('st_room_id') }}">
        <input type="hidden" name="st_room_people" value="{{ $rs->st_room->people ?? old('st_room_people') }}">
        <input type="hidden" name="st_room_is_internet" value="{{ $rs->st_room->is_internet ?? old('st_room_is_internet') }}">

        @if($formWhere == 'frontend')
            <a id="openCbox" class='inline' href="#inline_room"><input type="button" title="เลือกห้องประชุม" value="เลือกห้องประชุม" class="btn btn-info vtip" /></a>
        @endif
    </div>

    <div id="roomDetailHere" @if($formWhere == 'frontend') style="padding: 0 15px;" @endif></div>


    <div class="form-group form-inline col-md-12">
        <label>ชื่อเรื่อง / หัวข้อการประชุม-อบรม<span class="Txt_red_12"> *</span></label>
        <input name="title" type="text" class="form-control {{ $errors->has('title') ? 'has-error' : '' }}" placeholder="ชื่อเรื่อง" value="{{ isset($rs->title) ? $rs->title : old('title') }}" style="width:80%;" required>
    </div>

    <div class="form-group form-inline col-md-12">
        <label>ประธานการประชุม</label>
        <input name="president_name" type="text" class="form-control {{ $errors->has('president_name') ? 'has-error' : '' }}" placeholder="ชื่อประธาน" value="{{ isset($rs->president_name) ? $rs->president_name : old('president_name') }}" required>
        <input name="president_position" type="text" class="form-control {{ $errors->has('president_position') ? 'has-error' : '' }}" placeholder="ตำแหน่งประธาน" value="{{ isset($rs->president_position) ? $rs->president_position : old('president_position') }}" required>
    </div>

    <div class="form-group form-inline col-md-12 input-daterange chkTime">
        <label>วัน เวลา ที่ต้องการใช้ห้องประชุม<span class="Txt_red_12"> *</span></label>
        @php
            @$start_date = $rs->start_date ?? $_GET['start_date'];
        @endphp
        <input id="sDate" name="start_date" type="text" class="form-control range-date {{ $errors->has('start_date') ? 'has-error' : '' }}" value="{{ old('start_date') ?? @DB2Date(@$start_date) }}" style="width:120px;" required/>
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

    <div class="form-group form-inline col-md-12 input-daterange">
        <label>จำนวนผู้เข้าร่วมประชุม<span class="Txt_red_12"> *</span></label>
        <input name="number" type="number" min="1" class="form-control {{ $errors->has('number') ? 'has-error' : '' }}" placeholder="จำนวน" value="{{ isset($rs->number) ? $rs->number : old('number') }}" style="width:100px;" required>
        คน
        <span id="overTxt" style="color:red; margin-left:10px;"></span>
    </div>

    <div id="is_internet_section" class="form-group form-inline col-md-12" style="{{ @$rs->st_room->is_internet == 1 || old('st_room_is_internet') == 1 ? 'display:block;' : 'display:none;' }}">
        <label>ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต</label>
        <input name="internet_number" type="number" min="0" class="form-control {{ $errors->has('internet_number') ? 'has-error' : '' }}" placeholder="จำนวน" value="{{ @$rs->internet_number ?? old('internet_number') }}" style="width:100px;" required>
        คน
    </div>

    <div id="is_conference_section" class="form-group form-inline col-md-12" style="{{ @$rs->st_room->is_conference == 1 || old('st_room_is_conference') == 1 ? 'display:block;' : 'display:none;' }}">
        <label>ขอใช้งานระบบ Conference</label>
        <select class="form-control" name="use_conference">
            <option value="0" {{ @$rs->use_conference == 0 ? "selected" : ""}}>ไม่ใช้งาน</option>
            <option value="1" {{ @$rs->use_conference == 1 ? "selected" : ""}}>ใช้งาน</option>
        </select>
    </div>

    <div class="form-group form-inline col-md-12">
        <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
        <div class="dep-chain-group" style="margin-bottom:5px;">
            <input name="request_name" type="text" class="form-control {{ $errors->has('request_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้ขอใช้ห้องประชุม" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" required>

            <input name="request_position" type="text" class="form-control {{ $errors->has('request_position') ? 'has-error' : '' }}" placeholder="ตำแหน่งผู้ขอใช้ห้องประชุม" value="{{ isset($rs->request_position) ? $rs->request_position : old('request_position') }}" required>

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
        <label>หมายเหตุ / ความต้องการเพิ่มเติมอื่นๆ (ระบุรายละเอียด)</label>
        <textarea name="note" class="form-control " style="height:80px; width:80%;">{{ isset($rs->note) ? $rs->note : old('note') }}</textarea>
    </div>






    {{-- แอดมิน หลังบ้านเห็นเท่านั้น --}}
    @if($formWhere == 'backend')

        {{-- ตรวจสอบการอนุมัติ ห้องเดียวกัน เวลาเดียวกัน ไม่สามารถอนุมัติซ้อนกันได้ --}}
        @php
            $st_room_id = @$rs->st_room_id;
            $start_date = @$rs->start_date;
            $end_date = @$rs->end_date;
            $start_time = @$rs->start_time;
            $end_time = @$rs->end_time;
            $id = @$rs->id;

            $chkOverlap = App\Model\BookingRoom::select('*')->where('status', 'อนุมัติ')->where('st_room_id', $st_room_id)
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


                {{-- Approve Conference สำหรับเจ้าหน้าที่ที่สิทธิ์การใช้งานติ๊ก (ดูเฉพาะที่มีการจอง conference) --}}
                @if(@$rs->st_room->is_conference == 1)
                <div class="col-md-2">
                    <label>สถานะ Conference</label>
                    <select name="status_conference" class="form-control" style="width:100%;" {{ !CanPerm('booking-room-conference-view')?'disabled':'' }}>
                        <option value="รออนุมัติ" {{ @$rs->status_conference == 'รออนุมัติ' ? 'selected' : ''}}>รออนุมัติ</option>
                        <option value="อนุมัติ" {{ @$rs->status_conference == 'อนุมัติ' ? 'selected' : ''}}>อนุมัติ</option>
                        <option value="ไม่อนุมัติ" {{ @$rs->status_conference == 'ไม่อนุมัติ' ? 'selected' : ''}}>ไม่อนุมัติ</option>
                    </select>
                </div>
                {!! !CanPerm('booking-room-conference-view')?'<input type="hidden" name="status_conference" value="'.@$rs->status_conference.'">':'' !!}

                    {{-- ถ้าเจ้าหน้าที่มีสิทธิ์เฉพาะ approve conference อย่างเดียว (ให้ปิดฟอร์ม เปิดแค่ select สถานะ conference) --}}
                    @if(CanPerm('booking-room-conference-view') && !CanPerm('booking-room-edit'))
                        <script>
                        $(document).ready(function(){
                            $('form input, form select, form textarea').not("select[name=status_conference], #btnBoxAdd input").attr('disabled', 'disabled');
                        });
                        </script>
                    @endif
                @endif


                <div class="col-md-12">
                    @if($chkOverlap->count() >= 1)
                    <p class="text-danger" style="margin-top:20px;"><b><u>หมายเหตุ</u></b> พบรายการจองในช่วงเวลาที่ซ้ำ ที่มีสถานะเป็นอนุมัติแล้ว ไม่สามารถทำการอนุมัติซ้อนกันได้อีก</p>
                    <ul>
                        @foreach($chkOverlap as $overlap)
                        <li><a href="{{ url('booking-room/'.$overlap->id.'/edit') }}" target="_blank">{{ $overlap->code }} {{ $overlap->title }}</a></li>
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

    <div id="btnBoxAdd">
        <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
        <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="window.history.go(-1); return false;" class="btn btn-default" style="width:100px;" />
    </div>

</div>
{{-- END CONTAINER --}}




<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
    <div id='inline_room' style='padding:5px; background:#fff;'>
        <h3 style="margin:0; padding:0; color:#636">เลือกห้องประชุม</h3>
        <div id="search">
            <div id="searchBox">
                <form class="form-inline">
                    <input id="searchTxt" type="text" class="form-control" style="width:400px; display:inline;" placeholder="ชื่อห้องประชุม" />

                    <select id="searchDepartment" class="selectpicker" data-live-search="true" title="กรม">
                        <option value="">+ กรม +</option>
                        @foreach($st_departments as $item)
                            <option value="{{ $item->code }}">{{ $item->title }}</option>
                        @endforeach
                    </select>

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
        var $formWhere = "{{ $formWhere }}";

        // โชว์รายการห้องประชุมตอนกดปุ่มเลือกห้องประชุม
        $('#openCbox').click(function(){
            $('#searchRoomBtn').trigger('click');
        });

        // ค้นหาห้องประชุม
        $('body').on('click', '#searchRoomBtn', function() {
            $('#getRoomData').html('<i class="fas fa-spinner fa-pulse"></input>');

            $.ajax({
                url: '{{ url("ajaxGetRoom") }}',
                data: {
                    search: $("#searchTxt").val(),
                    depertment_code: $("#searchDepartment").val(),
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
            $('input[name=st_room_id]').val($(this).data('room-id'));
            $('input[name=st_room_people], input[name=number]').val($(this).data('room-people'));
            $('input[name=st_room_over_people]').val($(this).data('room-over-people'));
            $('input[name=st_room_is_internet]').val($(this).data('room-is-internet'));

            var overPeople = ($(this).data('room-over-people') == 1) ? 'ได้' :'ไม่ได้';
            $('#tmpStRoomName').val($(this).data('room-name'));
            $('#overTxt').html('รองรับได้'+$(this).data('room-people')+' คน (บันทึกเกิน'+overPeople+')');

            // is_internet ถ้าเป็น 1 ให้้เสดง 0 ไม่แสดง
            if($(this).data('room-is-internet') == 1){
                $('#is_internet_section').show();
            }else{
                $('#is_internet_section').hide();
            }

            // is_conference ถ้าเป็น 1 ให้้เสดง 0 ไม่แสดง
            if($(this).data('room-is-conference') == 1){
                $('#is_conference_section').show();
            }else{
                $('#is_conference_section').hide();
            }

            getRoomDetail($(this).data('room-id'));

            // ปิด colorbox
            $.colorbox.close();
        });

        $("#submitFormBtn").click(function(){
            if($formWhere == 'frontend'){
                chkOverlap();
            }else{
                $('form input, form select, form textarea').not("select[name=status_conference], #btnBoxAdd input").removeAttr('disabled');
                $('#submitFormBtn').attr('disabled','disabled');
                $('form').submit();
            }
        });
    });

    // เช็กเฉพาะหน้าบ้านเท่านั้น
    function chkOverlap(){
        $.ajax({
                url: '{{ url("ajaxRoomChkOverlap") }}',
                data: {
                    start_date: $('input[name=start_date]').val(),
                    start_time: $('input[name=start_time]').val(),
                    end_date: $('input[name=end_date]').val(),
                    end_time: $('input[name=end_time]').val(),
                    st_room_id: $('input[name=st_room_id]').val(),
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
        <h3 style="margin:0 0 25px 0; padding:0; color:rgb(255, 0, 0)">พบรายการจองในช่วงเวลาที่ซ้ำ</h3>

        <table class="tblist">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสการจอง</th>
                    <th>หัวข้อการประชุม</th>
                    <th>วัน เวลา ที่ต้องการใช้ห้อง</th>
                    <th>ผู้ขอใช้ห้องประชุม</th>
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

@php
if(@$_GET['st_room_id']){
    $stRoom = App\Model\StRoom::find(@$_GET['st_room_id']);
}
@endphp
<script>
$(document).ready(function(){
    var stRoomId = "{{ @$stRoom->id }}";
    if(stRoomId != ''){
        var stRoomPeople = "{{ @$stRoom->people }}";
        var stRoomOverPeople = "{{ @$stRoom->over_people }}";
        var stRoomIsInternet = "{{ @$stRoom->is_internet }}";
        var stRoomName = "{{ @$stRoom->name }}";
        var stRoomIsConference = "{{ @$stRoom->is_conference }}";

        $('input[name=st_room_id]').val(stRoomId);
        $('input[name=st_room_people], input[name=number]').val(stRoomPeople);
        $('input[name=st_room_over_people]').val(stRoomOverPeople);
        $('input[name=st_room_is_internet]').val(stRoomIsInternet);

        var overPeopleTxt = (stRoomOverPeople == 1) ? 'ได้' :'ไม่ได้';
        $('#tmpStRoomName').val(stRoomName);
        $('#overTxt').html('รองรับได้'+stRoomPeople+' คน (บันทึกเกิน'+overPeopleTxt+')');

        // is_internet ถ้าเป็น 1 ให้้เสดง 0 ไม่แสดง
        if(stRoomIsInternet == 1){
            $('#is_internet_section').show();
        }else{
            $('#is_internet_section').hide();
        }

        // is_conference ถ้าเป็น 1 ให้้เสดง 0 ไม่แสดง
        if(stRoomIsConference == 1){
            $('#is_conference_section').show();
        }else{
            $('#is_conference_section').hide();
        }

        getRoomDetail(stRoomId);
    }
});
</script>


<script>
$(document).ready(function(){
    var rsStRoomId = "{{ @$rs->st_room_id }}";
    if(rsStRoomId != ''){
        getRoomDetail(rsStRoomId);
    }
});
</script>

<script>
function getRoomDetail(roomId){
    $.ajax({
        url: '{{ url("ajaxGetRoomDetail") }}',
        data: {
            st_room_id: roomId,
        }
    })
    .done(function(data) {
        $('#roomDetailHere').html(data);
    });
}
</script>


<script>
// $(document).ready(function(){
//     $('form input, form select, form textarea').not("select[name=status_conference], #btnBoxAdd input").attr('disabled', 'disabled');
// });
</script>