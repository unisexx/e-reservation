
<?php
// $st_resources = App\Model\StResource::where('status','1')->orderBy('id', 'asc')->get();

$q = App\Model\StResource::select('*')->where('status', '1');
/**
 * เห็นเฉพาะของตัวเอง ในกรณีที่สิทธิ์การใช้งานตั้งค่าไว้, default คือเห็นทั้งหมด
 */
if (@CanPerm('access-self')) {
    $q = $q->where('st_bureau_code',Auth::user()->st_bureau_code);
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

if(isset($rs->start_time)){
    $sTimeArr = (explode(":",$rs->start_time));
}

if(isset($rs->end_time)){
    $eTimeArr = (explode(":",$rs->end_time));
}
?>

<section class="pt-5 bg-image overlay-primary fixed overlay" style="background-image: url('{{ asset('images/resource.jpg') }}');">

    <div class="container bg-white">

    <h3>จองทรัพยากรอื่นๆ (เพิ่ม / แก้ไข) 
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
                <div class="col-md-4">
                    <label>ทรัพยากร <span class="Txt_red_12">*</span></label>
                    <select name="st_resource_id" class="form-control">
                        @foreach($st_resources as $row)
                            <option value="{{ $row->id }}" @if($row->id == @$rs->st_resource_id) selected @endif @if($row->id == @old('st_resource_id')) selected="selected" @endif >{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-15">
                <div class="col-md-12">
                    <div class="form-group form-margin">
                        <label class="control-label">ชื่อเรื่อง<span class="Txt_red_12">*</span></label>
                        <input name="title" type="text" class="form-control " placeholder="ชื่อเรื่อง"
                            value="{{ $rs->title ?? old('title') }}">
                    </div>
                </div>
            </div>

            <div class="row input-daterange mt-20 chkTime">
                <div class="col-md-12"> <label>วัน เวลา ที่ต้องการใช้<span class="Txt_red_12"> *</span></label><br>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-5 input-daterange">
                    <div class="col-xs-12 col-sm-4 col-md-5 p-0">
                        <div class="form-group form-margin">
                            <input id="sDate" name="start_date" type="text" class="form-control range-date" value="{{ old('start_date') ?? @DB2Date($rs->start_date) }}"
                                required="" placeholder="วัน/เดือน/ปี">
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
                            <input id="eDate" name="end_date" type="text" class="form-control range-date" value="{{ old('end_date') ?? @DB2Date($rs->end_date) }}"
                                required="" placeholder="วัน/เดือน/ปี">
                        </div>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                    <div class="col-xs-2 col-sm-2 col-md-2  pull-left">
                        <select id="eHour" name="sHour" class="selectpicker" data-size="10" data-live-search="true" required>
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$sTimeArr[0] ?? old('sHour')) ? 'selected' : '' }}>{{ $item }}</option>
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

                    <input type="hidden" name="start_time" value="00:00">
                    <input type="hidden" name="end_time" value="00:00">
                </div>

            </div>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-margin">
                        <label class="control-label">ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12">
                                *</span></label>
                        <input name="request_name" type="text" class="form-control " placeholder="ชื่อผู้ขอใช้"
                            value="{{ $rs->request_name ?? old('request_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="control-label">&nbsp;</label>
                    <div class="form-group form-margin">
                        <input name="request_position" type="text" class="form-control "
                            placeholder="ตำแหน่งผู้ขอใช้" value="{{ $rs->request_position ?? old('request_position') }}" required="">
                    </div>
                </div>
            </div>

            <div class="row dep-chain-group">
                <div class="col-md-4 mt-10">
                    <select name="st_department_code" class="chain-department selectpicker w-100" data-live-search="true" data-size="8" title="กรม" required>
                        <option value="">+ กรม +</option>
                        @foreach($st_departments as $item)
                        <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_bureau_code" id="lunch" class="chain-bureau selectpicker w-100" data-live-search="true" data-size="8" title="สำนัก" required>
                        <option value="">+ สำนัก +</option>
                        @if(old('st_department_code') || isset($rs->st_department_code))
                        @foreach($st_bureaus as $item)
                        <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_division_code" id="lunch" class="chain-division selectpicker w-100" data-live-search="true" data-size="8" title="กลุ่ม" required>
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
                    <input name="request_tel" type="text" class="form-control " placeholder="เบอร์โทรศัพท์" value="{{ $rs->request_tel ?? old('request_tel') }}" required="">
                </div>
                <div class="col-md-6 mt-20">
                    <input name="request_email" type="text" class="form-control " placeholder="อีเมล์" value="{{ $rs->request_email ?? old('request_email') }}" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-30">
                <div class="form-group form-margin">
                    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
                    <textarea name="note" class="form-control" rows="5">{{ $rs->note ?? old('note') }}</textarea>
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
            <div class="mt-30"></div>
            <h3>สำหรับเจ้าหน้าที่ดูแลระบบ</h3>

            <div class="row">
                <div class="col-md-3">
                    <label>สถานะ</label>
                    @php
                        $statusArray = ['รออนุมัติ'=>'รออนุมัติ','อนุมัติ'=>'อนุมัติ','ไม่อนุมัติ'=>'ไม่อนุมัติ','ยกเลิก'=>'ยกเลิก']
                    @endphp
                    {{ Form::select("status", $statusArray, @$rs->status, ['class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-size'=>'8']) }}
                </div>
            </div>
            @endif
            <div class="row mt-30 mb-7">
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

@push('js')
<script>
    $(document).ready(function() {
        var $formWhere = "{{ $formWhere }}";

        $("#submitFormBtn").click(function(){
            if($formWhere == 'frontend'){
                chkOverlap();
            }else{
                $('#resourceForm').submit();
            }
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
        $('#resourceForm').submit();
    });
    $('body').on('click', '#cboxCloseBtn', function() {
        $.colorbox.close();
    });
});
</script>
@endpush