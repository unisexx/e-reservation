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

<section class="pt-5 bg-image overlay-primary fixed overlay" style="background-image: url('{{ asset('images/room-bg.jpg') }}');">

    <div class="container bg-white" >

    <h3>@if(Request::segment(1) == 'booking-room-conference')
        จองห้อง Conference (เพิ่ม / แก้ไข)
        @else
        จองห้องประชุม/อบรม (เพิ่ม / แก้ไข)
        @endif
        {{-- แสดงเฉพาะด้านหน้า --}}
        @if($formWhere == 'frontend')
        <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="36" style="float: right;"></a>
        @endif
    </h3>

    @if ($errors->any())
    <ul class="alert alert-danger list-unstyled">
        <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
        @foreach ($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <div class="p-1 mt-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group form-margin">
                        <label>รหัสการจอง</label>
                        <input type="text" class="form-control" placeholder="Generate Auto" readonly="readonly" value="{{ isset($rs->code) ? $rs->code : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group form-margin">
                        <label class="control-label">เลือกห้องประชุม<span class="Txt_red_12">*</span></label>
                        <input id="tmpStRoomName" name="tmpStRoomName" type="text" class="form-control" readonly="readonly" value="{{ isset($rs->st_room_id) ? $rs->st_room->name : old('tmpStRoomName') }}" required>

                        <input type="hidden" name="st_room_over_people" value="{{ $rs->st_room_over_people ?? old('st_room_over_people')}}">
                        <input type="hidden" name="st_room_id" value="{{ $rs->st_room_id ?? old('st_room_id') }}">
                        <input type="hidden" name="st_room_people" value="{{ $rs->st_room->people ?? old('st_room_people') }}">
                        <input type="hidden" name="st_room_is_internet" value="{{ $rs->st_room->is_internet ?? old('st_room_is_internet') }}">

                        @if($formWhere == 'frontend')
                            <a id="openCbox" class='inline' href="#inline_room"><input type="button" title="เลือกห้องประชุม" value="เลือกห้องประชุม" class="btn btn-info vtip" /></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="roomDetailHere"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group form-margin">
                        <label class="control-label">ชื่อเรื่อง / หัวข้อการประชุม-อบรม<span class="Txt_red_12">
                                *</span></label>
                        <input name="title" type="text" class="form-control" placeholder="ชื่อเรื่อง" value="{{ isset($rs->title) ? $rs->title : old('title') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-margin">
                        <label class="control-label">ประธานการประชุม</label>
                        <input name="president_name" type="text" class="form-control" placeholder="ชื่อประธาน" value="{{ isset($rs->president_name) ? $rs->president_name : old('president_name') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-margin">
                        <label class="control-label">&nbsp;</label>
                        <input name="president_position" type="text" class="form-control" placeholder="ตำแหน่งประธาน" value="{{ isset($rs->president_position) ? $rs->president_position : old('president_position') }}" required>
                    </div>
                </div>
            </div>

            <div class="row input-daterange chkTime">
                <div class="col-md-12"> <label>วัน เวลา ที่ต้องการใช้ห้องประชุม<span class="Txt_red_12"> *</span></label><br>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-5">
                    <div class="col-xs-12 col-sm-4 col-md-5 p-0">
                        <div class="form-group form-margin">
                            @php
                                @$start_date = $rs->start_date ?? $_GET['start_date'];
                            @endphp
                            <input id="sDate" name="start_date" type="text" class="form-control range-date" value="{{ old('start_date') ?? @DB2Date(@$start_date) }}" required/>
                        </div>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="sHour" name="sHour" class="selectpicker" data-size="10" data-live-search="true" required>
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$sTimeArr[0] ?? old('sHour')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 w-10 colon">:</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="sMinute" name="sMinute" class="selectpicker" data-size="10" data-live-search="true" required>
                            @foreach(getMinute() as $item)
                            <option value="{{ $item }}" {{ $item == (@$sTimeArr[1] ?? old('sMinute')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-right pt-1 p-0 col-xs-1 minute">น.</div>
                </div>

                <div class="pull-left pt-1 pr-1 pb-1 col-xs-12 col-md-1"><strong>ถึง</strong></div>

                <div class="col-xs-12 col-sm-8 col-md-5">
                    <div class="col-xs-12 col-sm-4 col-md-5 p-0">
                        <div class="form-group form-margin">
                            <input id="eDate" name="end_date" type="text" class="form-control range-date {{ $errors->has('end_date') ? 'has-error' : '' }}" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" required/>
                        </div>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                    <div class="col-xs-2 col-sm-2 col-md-2  pull-left">
                        <select id="eHour" name="eHour" class="selectpicker" data-size="10" data-live-search="true" required>
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$eTimeArr[0] ?? old('eHour')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 w-10 colon">:</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="eMinute" name="eMinute" class="selectpicker" data-size="10" data-live-search="true" required>
                            @foreach(getMinute() as $item)
                            <option value="{{ $item }}" {{ $item == (@$eTimeArr[1] ?? old('eMinute')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-right pt-1 p-0 col-xs-1 minute">น.</div>
                </div>

                <input type="hidden" name="start_time" value="{{ isset($rs->start_time) ? $rs->start_time : old('start_time') }}">
                <input type="hidden" name="end_time" value="{{ isset($rs->end_time) ? $rs->end_time : old('end_time') }}">
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <label class="control-label">จำนวนผู้เข้าร่วมประชุม <span class="Txt_red_12">*</span></label>
                </div>
                <div class="col-md-1">
                    <input name="number" type="number" min="1" class="form-control" placeholder="จำนวน" value="{{ isset($rs->number) ? $rs->number : old('number') }}" required>
                </div>
                <div class="col-md-1">คน</div>
                <span id="overTxt" style="color:red; margin-left:10px;"></span>
            </div>

            <div id="is_internet_section" class="row form-group" style="{{ @$rs->st_room->is_internet == 1 || old('st_room_is_internet') == 1 ? 'display:block;' : 'display:none;' }}">
                <div class="col-md-12">
                    <label class="control-label">ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต</label>
                </div>
                <div class="col-md-1">
                    <input name="internet_number" type="number" min="0" class="form-control" placeholder="จำนวน" value="{{ @$rs->internet_number ?? old('internet_number') }}" required>
                </div>
                <div class="col-md-1">คน</div>
            </div>

            <div id="is_conference_section" class="row form-group" style="{{ @$rs->st_room->is_conference == 1 || old('st_room_is_conference') == 1 ? 'display:block;' : 'display:none;' }}">
                <div class="col-md-12">
                    <label class="control-label">ขอใช้งานระบบ Conference</label>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="use_conference">
                        <option value="0" {{ @$rs->use_conference == 0 ? "selected" : ""}}>ไม่ใช้งาน</option>
                        <option value="1" {{ @$rs->use_conference == 1 ? "selected" : ""}}>ใช้งาน</option>
                    </select>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-margin">
                        <label class="control-label">ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12">
                                *</span></label>
                        <input name="request_name" type="text" class="form-control" placeholder="ชื่อผู้ขอใช้ห้องประชุม" value="{{ isset($rs->request_name) ? $rs->request_name : old('request_name') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="control-label">&nbsp;</label>
                    <div class="form-group form-margin">
                        <input name="request_position" type="text" class="form-control" placeholder="ตำแหน่งผู้ขอใช้ห้องประชุม" value="{{ isset($rs->request_position) ? $rs->request_position : old('request_position') }}" required>
                    </div>
                </div>
            </div>

            <div class="row dep-chain-group">
                <div class="col-md-4 mt-10">
                    <select name="st_department_code" class="chain-department selectpicker w-100" data-live-search="true" title="กรม" required>
                        <option value="">+ กรม +</option>
                        @foreach($st_departments as $item)
                        <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_bureau_code" class="chain-bureau selectpicker w-100" data-live-search="true" title="สำนัก" required>
                        <option value="">+ สำนัก +</option>
                        @if(old('st_department_code') || isset($rs->st_department_code))
                        @foreach($st_bureaus as $item)
                        <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_division_code" class="chain-division selectpicker w-100" data-live-search="true" title="กลุ่ม" required>
                        <option value="">+ กลุ่ม +</option>
                        @if(old('st_bureau_code') || isset($rs->st_bureau_code))
                        @foreach($st_divisions as $item)
                        <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-20">
                    <input name="request_tel" type="text" class="form-control" placeholder="เบอร์โทรศัพท์" value="{{ isset($rs->request_tel) ? $rs->request_tel : old('request_tel') }}" required>
                </div>
                <div class="col-md-6 mt-20">
                    <input name="request_email" type="text" class="form-control" placeholder="อีเมล์" value="{{ isset($rs->request_email) ? $rs->request_email : old('request_email') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-30">
                <div class="form-group form-margin">
                    <label>หมายเหตุ / ความต้องการเพิ่มเติมอื่นๆ (ระบุรายละเอียด)</label>
                    <textarea name="note" class="form-control" rows="5">{{ isset($rs->note) ? $rs->note : old('note') }}</textarea>
                </div>
            </div>
            </div>

            {{-- แสดงเฉพาะด้านหน้า --}}
            @if($formWhere == 'frontend')
            <div class="row">
                <div class="col-md-3">
                    <label>กรุณาใส่ผลบวกที่ถูกต้อง <span class="Txt_red_12"> *</span></label>
                    <span class="form-inline">
                        {!! captcha_img() !!}
                        <input class="form-control" type="text" name="captcha" style="width:100px;">
                    </span>
                </div>
            </div>
            @endif

            {{-- แสดงเฉพาะด้านหลัง --}}
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

                <div class="mt-30"></div>
                <h3>สำหรับเจ้าหน้าที่ดูแลระบบ</h3>

                {{-- อนุมัติการจองห้อง --}}
                @if(Request::segment(1) == 'booking-room')
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>สถานะการจองห้อง</label>
                        @php
                            $statusArray = ['รออนุมัติ'=>'รออนุมัติ','อนุมัติ'=>'อนุมัติ','ไม่อนุมัติ'=>'ไม่อนุมัติ','ยกเลิก'=>'ยกเลิก']
                        @endphp
                        {{ Form::select("status", $statusArray, @$rs->status, ['class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-size'=>'8']) }}
            
                        {{-- {!! !CanPerm('booking-room-edit')?'<input type="hidden" name="status" value="'.@$rs->status.'">':'' !!} --}}
                    </div>
                </div>
                @endif

                {{-- อนุมัติการจอง conference --}}
                @if((@$rs->st_room->is_conference == 1) && (Request::segment(1) == 'booking-room-conference'))
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>สถานะการจองห้อง</label>
                        <div>{{ @$rs->status }}</div>
                        <input type="hidden" name="status" value="{{ @$rs->status }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        <label>สถานะ Conference</label>
                        @php
                            $statusConfArray = ['รออนุมัติ'=>'รออนุมัติ','อนุมัติ'=>'อนุมัติ','ไม่อนุมัติ'=>'ไม่อนุมัติ']
                        @endphp
                        {{ Form::select("status_conference", $statusConfArray, @$rs->status_conference, ['class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-size'=>'8']) }}
                    </div>
                </div>
                
                <script>
                $(document).ready(function(){
                    $('form input, form select, form textarea').not("select[name=status_conference], #btnBoxAdd input, #MainFrmSubmit input").attr('disabled', 'disabled');
                });
                </script>
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
            @endif


            <div id="MainFrmSubmit" class="row mt-30 mb-7">
                <div class="col-md-4 col-md-offset-2">
                    <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary btn-lg w-100 mt-15">
                </div>
                <div class="col-md-4">
                    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="window.history.go(-1); return false;" class="btn btn-default btn-lg w-100 mt-15" >
                </div>
            </div>

    </div>
    <!--container -->
</div>
</section>





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
                    st_province_id: {{ request('st_province_id') }},
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