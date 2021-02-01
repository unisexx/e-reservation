<?php
// กระทรวง
$st_ministries = App\Model\StMinistry::orderBy('code', 'asc')->get();
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
<table class="tbadd">
    <tr>
        <th>ระดับตำแหน่ง<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                {{ Form::select("st_position_level_id", \App\Model\StPositionLevel::where('status', 1)->pluck('name', 'id'), @$rs->st_position_level_id, ['class'=>'form-control', 'style'=>'width:auto; display:inline;']) }}
            </div>
        </td>
    </tr>
    <tr>
        <th>ชื่อ-สกุล<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" type="text" class="form-control" placeholder="ชื่อ-สกุล" style="width:500px;" value="{{ $rs->name ?? old('name') }}" required/></div>
        </td>
    </tr>
    <tr>
        <th>ตำแหน่ง<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline" style="margin-bottom:5px;">
                {{ Form::select("st_boss_position_id", \App\Model\StBossPosition::where('status', 1)->pluck('name', 'id'), @$rs->st_boss_position_id, ['class'=>'form-control', 'style'=>'width:auto; display:inline;']) }}
                {{ Form::text("position_more", @$rs->position_more, ['class'=>'form-control', 'placeholder'=>'รายละเอียดตำแหน่งเพิ่มเติม', 'style'=>'width:300px']) }}
            </div>
        </td>
    </tr>
    <tr>
        <th>เบอร์ติดต่อ <span class="Txt_red_12">*</span></th>
        <td>
            <div class="form-inline">
                <input name="tel" type="text" class="form-control" placeholder="เบอร์ติดต่อ" style="width:300px;" value="{{ $rs->tel ?? old('tel') }}" required/>
            </div>
        </td>
    </tr>
    <tr>
        <th>ผู้ดูแลผู้บริหาร<span class="Txt_red_12"> *</span></th>
        <td class="dep-chain-group">
            <div class="form-inline" style="margin-bottom:5px;">
                {{ Form::text("res_name", @$rs->res_name, ['class'=>'form-control', 'placeholder'=>'ชื่อผู้ดูแล', 'style'=>'width:300px', 'required'=>'required']) }}
                {{ Form::text("res_tel", @$rs->res_tel, ['class'=>'form-control', 'placeholder'=>'เบอร์ติดต่อ', 'style'=>'width:200px', 'required'=>'required']) }}
            </div>
            

            @if(CanPerm('access-self'))

                {{ Form::select("st_department_code", \App\Model\StDepartment::where('code', @Auth::user()->st_department_code)->pluck('title', 'id'), @$rs->st_department_code, ['class'=>'form-control', 'style'=>'width:auto; display:inline;']) }}

                {{ Form::select("st_bureau_code", \App\Model\StBureau::where('code', @Auth::user()->st_bureau_code)->pluck('title', 'id'), @$rs->st_bureau_code, ['class'=>'form-control', 'style'=>'width:auto; display:inline;']) }}

                {{ Form::select("st_division_code", \App\Model\StDivision::where('code', @Auth::user()->st_division_code)->pluck('title', 'id'), @$rs->st_division_code, ['class'=>'form-control', 'style'=>'width:auto; display:inline;']) }}

            @elseif(CanPerm('access-all'))

                <select name="st_department_code" id="lunch" class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" data-size="8" title="กรม" required>
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code" id="lunch" class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" data-size="8" title="สำนัก" required>
                    <option value="">+ สำนัก +</option>
                    @if(old('st_department_code') || isset($rs->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code" id="lunch" class="chain-division selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" data-size="8" title="กลุ่ม" required>
                    <option value="">+ กลุ่ม +</option>
                    @if(old('st_bureau_code') || isset($rs->st_bureau_code))
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$rs->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

            @endif
        </td>
    </tr>
    <tr>
        <th>เปิดการใช้งาน</th>
        <td>
            <input name="status" type="hidden" value="0" checked="checked" />
            <input name="status" type="checkbox" id="status" value="1" {!! (@$rs->status == 1 || empty($rs->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-boss') }}'" class="btn btn-default" style="width:100px;" />
</div>
