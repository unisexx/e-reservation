<?php
$currDate = date("Y-m-d");
$currTime = date("H:i:s");

if(isset($rs->start_time)){
    $sTimeArr = (explode(":",$rs->start_time));
}

if(isset($rs->end_time)){
    $eTimeArr = (explode(":",$rs->end_time));
}

if(isset($rs->point_time)){
    $pTimeArr = (explode(":",$rs->point_time));
}

$st_province_code = @$rs->st_province_code ?? request('st_province_code');
$province_txt = @$st_province_code == 10 ? 'ส่วนกลาง' : @getProviceName(@$st_province_code);
?>

<section class="pt-5 bg-image overlay-primary fixed overlay" style="background-image: url('{{ asset('images/vehicle-bg.jpg') }}');">

    <div class="container bg-white" >

    <h3>จองยานพาหนะ ({{ @$province_txt }})
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

            @php
                // $route = Route::current();
                // $name = Route::currentRouteName();
                // $action = Route::currentRouteAction();
                // dump($route);
                // dump($name);
                // dump($action);
                // dump(Request::segment(1));
                // dump(Request::segment(2));
                // dump(Request::segment(3));
            @endphp 
            {{-- @if(Route::currentRouteAction() == 'App\Http\Controllers\BookingVehicleController@create') 
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group form-margin">
                            <label>จองยานพาหนะของจังหวัด</label>
                            {{ Form::select(
                                'tmpProvinceCode', 
                                App\Model\StProvince::filterByUserBureauProvince()->where('status', 1)->orderBy('code', 'asc')->pluck('name','code'), 
                                @$st_province_code, 
                                [
                                    'class' => 'form-control selectpicker', 
                                    'data-live-search' => 'true',
                                    'data-size' => '8',
                                    'data-title' => 'เลือกจังหวัด'
                                ])
                            }}
                        </div>
                    </div>
                </div>
                @push('js')
                <script>
                    $(document).ready(function(){
                        $('body').on('change', 'select[name=tmpProvinceCode]', function() {
                            window.location.href = "{{ route('booking-vehicle.create') }}?st_province_code=" + $(this).val();
                        });
                    });
                </script>
                @endpush
            @endif --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-margin">
                        <label class="control-label">วันที่ยื่นคำขอจอง <span class="Txt_red_12">*</span></label>
                        <input required name="request_date" type="text" class="form-control datepicker fdate @error('request_date') has-error @enderror" value="{{ isset($rs->request_date) ? DB2Date($rs->request_date) : '' }} {{ old('request_date') ? old('request_date') : @DB2Date($currDate) }}"/>
                    </div>
                </div>
            </div>

            @php
                /*************************/
                /*** หน่วยงานของยานพาหนะ ***/
                /*************************/
                $req_st_department_code = $rs->req_st_department_code ?? old('req_st_department_code') ?? substr(request('req_st_bureau_code'), 0, 5);
                $req_st_bureau_code = $rs->req_st_bureau_code ?? old('req_st_bureau_code') ?? request('req_st_bureau_code');
                $req_st_division_code = $rs->req_st_division_code ?? old('req_st_division_code');

                $req_st_departments = App\Model\StVehicle::select('st_department_code')
                                            ->where('st_province_code', @$st_province_code)
                                            ->where('status','พร้อมใช้')
                                            ->with('department')
                                            ->distinct()
                                            ->orderBy('st_department_code', 'asc')
                                            ->get();

                $req_st_bureaus = App\Model\StVehicle::select('st_bureau_code')->where('st_department_code', 'like', @$req_st_department_code . '%')->where('status','พร้อมใช้')->with('bureau')->distinct()->orderBy('st_bureau_code', 'asc')->get();

                $req_st_divisions = App\Model\StVehicle::select('st_division_code')->where('st_bureau_code', 'like', @$req_st_bureau_code . '%')->where('status','พร้อมใช้')->with('division')->distinct()->orderBy('st_division_code', 'asc')->get();
            @endphp     
            <div class="row dep-chain-group">
                <div class="col-md-4 mt-10">
                    <label class="control-label">ขอใช้ยานพาหนะของหน่วยงาน<span class="Txt_red_12">*</span></label>
                    <select name="req_st_department_code" class="chain-department-vehicle selectpicker w-100 @error('req_st_department_code') has-error @enderror" data-live-search="true" data-size="10" title="กรม">
                        <option value="">+ กรม +</option>
                        @foreach($req_st_departments as $item)
                        <option value="{{ $item->st_department_code }}" 
                            @if($item->st_department_code == @$req_st_department_code) selected="selected" @endif
                        >
                            {{ $item->department->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <label class="control-label">&nbsp;</label>
                    <select name="req_st_bureau_code" class="chain-bureau-vehicle selectpicker w-100 @error('req_st_bureau_code') has-error @enderror" data-live-search="true" data-size="10" title="สำนัก">
                        <option value="">+ สำนัก +</option>
                        @if(@$req_st_department_code)
                        @foreach($req_st_bureaus as $item)
                        <option value="{{ $item->st_bureau_code }}" 
                            @if($item->st_bureau_code == @$req_st_bureau_code) selected="selected" @endif 
                        >
                            {{ $item->bureau->title }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <label class="control-label">&nbsp;</label>
                    <select name="req_st_division_code" class="chain-division-vehicle selectpicker w-100 @error('req_st_division_code') has-error @enderror" data-live-search="true" data-size="10" title="กลุ่ม">
                        <option value="">+ กลุ่ม +</option>
                        @if(@$req_st_bureau_code)
                        @foreach($req_st_divisions as $item)
                        <option value="{{ $item->st_division_code }}" 
                            @if($item->st_division_code == @$req_st_division_code) selected="selected" @endif
                        >
                            {{ $item->division->title }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="row mt-15">
                <div class="col-md-12">
                    <div class="form-group form-margin">
                        <label class="control-label">ไปเพื่อ<span class="Txt_red_12">*</span></label>
                        <input name="gofor" type="text" class="form-control @error('gofor') has-error @enderror" value="{{ $rs->gofor ?? old('gofor') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">จำนวนผู้โดยสาร<span class="Txt_red_12">*</span></label>
                </div>
                <div class="col-md-1">
                    <input name="number" type="number" min="1" class="form-control numOnly @error('number') has-error @enderror" value="{{ $rs->number ?? old('number') }}">
                </div>
                <div class="col-md-1">คน</div>
            </div>

            <div class="row input-daterange mt-20 chkTime">
                <div class="col-md-12"> <label>วัน เวลา ที่ต้องการใช้<span class="Txt_red_12"> *</span></label><br>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-5">
                    <div class="col-xs-12 col-sm-4 col-md-5 p-0">
                        <div class="form-group form-margin">
                            @php
                                @$start_date = $rs->start_date ?? $_GET['start_date'];
                            @endphp
                            <input id="sDate" name="start_date" type="text" class="form-control range-date @error('start_date') has-error @enderror" value="{{ old('start_date') ?? @DB2Date(@$start_date) }}"/>
                        </div>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="sHour" name="sHour" class="selectpicker" data-size="10" data-live-search="true" >
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$sTimeArr[0] ?? old('sHour')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 w-10 colon">:</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="sMinute" name="sMinute" class="selectpicker" data-size="10" data-live-search="true" >
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
                            <input id="eDate" name="end_date" type="text" class="form-control range-date @error('end_date') has-error @enderror" value="{{ isset($rs->end_date) ? DB2Date($rs->end_date) : old('end_date') }}" style="width:120px;" >
                        </div>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                    <div class="col-xs-2 col-sm-2 col-md-2  pull-left">
                        <select id="eHour" name="eHour" class="selectpicker" data-size="10" data-live-search="true" >
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$eTimeArr[0] ?? old('eHour')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pull-left pt-1 p-0 col-xs-1 w-10 colon">:</div>
                    <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                        <select id="eMinute" name="eMinute" class="selectpicker" data-size="10" data-live-search="true" >
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

            <div class="row">
                <div class="col-md-7">
                    <div class="form-group form-margin">
                        <label class="control-label">สถานที่ขึ้นรถ <span class="Txt_red_12">
                                *</span></label>
                        <input name="point_place" type="text" class="form-control @error('point_place') has-error @enderror" placeholder="สถานที่ขึ้นรถ" value="{{ isset($rs->point_place) ? $rs->point_place : old('point_place') }}">
                    </div>
                </div>
                <div class="col-md-4 time2">
                    <label class="control-label">&nbsp;</label>
                    <div class="form-group form-margin">
                        <div class="pull-left pt-1 p-0 col-xs-1 col-sm-1">เวลา</div>
                        <div class="col-xs-2 col-sm-2 col-md-2  pull-left">
                            <select id="pHour" name="pHour" class="selectpicker" data-size="10" data-live-search="true" >
                            @foreach(getHour() as $item)
                            <option value="{{ $item }}" {{ $item == (@$pTimeArr[0] ?? old('pHour')) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="pull-left pt-1 p-0 col-xs-1 w-10 colon2">:</div>
                        <div class="col-xs-2 col-sm-2 col-md-2 pull-left">
                            <select id="pMinute" name="pMinute" class="selectpicker" data-size="10" data-live-search="true" >
                                @foreach(getMinute() as $item)
                                <option value="{{ $item }}" {{ $item == (@$pTimeArr[1] ?? old('pMinute')) ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pl-2 pt-1 p-0 col-xs-1 minute2">น.</div>
                    </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-margin">
                        <label class="control-label">สถานที่ไป <span class="Txt_red_12">*</span></label>
                        <input name="destination" type="text" class="form-control @error('destination') has-error @enderror" placeholder="สถานที่ไป" value="{{ $rs->destination ?? old('destination') }}">
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-margin">
                        <label class="control-label">ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12">
                                *</span></label>
                        <input name="request_name" type="text" class="form-control @error('request_name') has-error @enderror" placeholder="ชื่อผู้ขอใช้ยานพาหนะ" value="{{ $rs->request_name ?? old('request_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="control-label">&nbsp;</label>
                    <div class="form-group form-margin">
                        <input name="request_position" type="text" class="form-control @error('request_position') has-error @enderror" placeholder="ตำแหน่งผู้ขอใช้ยานพาหนะ" value="{{ $rs->request_position ?? old('request_position') }}">
                    </div>
                </div>
            </div>

            @php
                /*************************/
                /*** หน่วยงานผู้จอง ***/
                /*************************/
                $st_department_code = $rs->st_department_code ?? old('st_department_code');
                $st_bureau_code = $rs->st_bureau_code ?? old('st_bureau_code');
                $st_division_code = $rs->st_division_code ?? old('st_division_code');

                $st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();
                $st_bureaus = App\Model\StBureau::where('code', 'like', @$st_department_code . '%')->orderBy('code', 'asc')->get();
                $st_divisions = App\Model\StDivision::where('code', 'like', @$st_bureau_code . '%')->orderBy('code', 'asc')->get();
            @endphp
            <div class="row dep-chain-group">
                <div class="col-md-4 mt-10">
                    <select name="st_department_code" class="chain-department selectpicker w-100 @error('st_department_code') has-error @enderror" data-live-search="true" title="กรม" data-size="10">
                        <option value="">+ กรม +</option>
                        @foreach($st_departments as $item)
                        <option value="{{ $item->code }}" 
                            @if($item->code == @$st_department_code) selected="selected" @endif 
                        >
                            {{ $item->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_bureau_code" class="chain-bureau selectpicker w-100 @error('st_bureau_code') has-error @enderror" data-live-search="true" title="สำนัก" data-size="10">
                        <option value="">+ สำนัก +</option>
                        @if(@$st_department_code)
                        @foreach($st_bureaus as $item)
                        <option value="{{ $item->code }}" 
                        @if($item->code == @$st_bureau_code) selected="selected" @endif 
                        >
                            {{ $item->title }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 mt-10">
                    <select name="st_division_code" class="chain-division selectpicker w-100 @error('st_division_code') has-error @enderror" data-live-search="true" title="กลุ่ม" data-size="10">
                        <option value="">+ กลุ่ม +</option>
                        @if(@$st_bureau_code)
                        @foreach($st_divisions as $item)
                        <option value="{{ $item->code }}" 
                            @if($item->code == @$st_division_code) selected="selected" @endif 
                        >
                            {{ $item->title }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-20">
                    <input name="request_tel" type="text" class="form-control @error('request_tel') has-error @enderror" placeholder="เบอร์โทรศัพท์" value="{{ $rs->request_tel ?? old('request_tel') }}">
                </div>
                <div class="col-md-6 mt-20">
                    <input name="request_email" type="text" class="form-control @error('request_email') has-error @enderror" placeholder="อีเมล์" value="{{ $rs->request_email ?? old('request_email') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-30">
                <div class="form-group form-margin">
                    <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
                    <textarea name="note" class="form-control">{{ $rs->note ?? old('note') }}</textarea>
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

            <div class="row">
                <div id="selectDriver" class="col-md-4 mt-20">
                    <label>พนักงานขับรถ</label>
                    <select name="st_driver_id" class="form-control" >
                        <option value="">+ พนักงานขับรถ +</option>
                    </select>
                </div>
            </div>

            <div id="selectVehicleBlock" class="row mt-20">
                <div class="col-md-12"> <label>ยานพาหนะ<span class="Txt_red_12"> *</span></label><br></div>
                <div class="col-md-4">
                    <input id="tmpStVehicleName" name="tmpStVehicleName" type="text" class="form-control" readonly="readonly" value="@if(isset($rs->st_vehicle_id)) {{$rs->st_vehicle->st_vehicle_type->name}} {{$rs->st_vehicle->brand}} {{!empty($rs->st_vehicle->seat)?$rs->st_vehicle->seat:'-'}} ที่นั่ง สี{{$rs->st_vehicle->color}} ทะเบียน {{$rs->st_vehicle->reg_number}} @else {{ old('tmpStVehicleName') }} @endif">
                    {{-- <a id="openCbox" class='inline' href="#inline_vehicle"><input type="button" title="เลือกยานพาหนะ" value="เลือกยานพาหนะ" class="btn btn-info vtip" /></a> --}}
                    <input type="hidden" name="st_vehicle_id" value="{{ $rs->st_vehicle_id ?? old('st_vehicle_id') }}">
                </div>

                <div class="col-md-4">
                    <a id="openCbox" class='inline' href="#inline_vehicle"><input type="button" title="เลือกยานพาหนะ" value="เลือกยานพาหนะ" class="btn btn-info vtip" /></a>
                </div>
            </div>
            @endif

            <div class="row mt-30 mb-7">
                <div class="col-md-4 col-md-offset-2">
                    <input type="hidden" name="st_province_code" value="{{ @$st_province_code }}">
                    <input id="submitFormBtn" name="input" type="button" title="บันทึกข้อมูล" value="บันทึกข้อมูล" class="btn btn-primary btn-lg w-100 mt-15">
                    <button type="submit" style="display:none;"></button>
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

    });

    $(document).ready(function() {
        var $formWhere = "{{ $formWhere }}";
        // console.log($formWhere);

        $("#submitFormBtn").click(function(){
            if($formWhere == 'frontend'){
                chkOverlap();
            }else{
                $('form#bookingVehicleForm').find('[type="submit"]').trigger('click');
            }
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
                    st_province_code: $('input[name=st_province_code]').val(),
                    id: "{{ @$rs->id }}",
                }
            })
            .done(function(data) {
                if( data == 'ไม่เหลื่อม' ){
                    $('form#bookingVehicleForm').find('[type="submit"]').trigger('click');
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