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
        <th>ชื่อสกุล<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" value="{{ isset($rs->name) ? $rs->name : old('name') }}" type="text" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" placeholder="ชื่อ-สกุล" style="width:500px;" required /></div>
        </td>
    </tr>
    <tr>
        <th>หน่วยงาน<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline dep-chain-group">

            @if(CanPerm('access-self'))

                <select name="st_department_code" class="form-control" title="กรม" required readonly style="width:auto; display:inline;">
                    <option value="{{ @Auth::user()->st_department_code }}" selected>{{ @Auth::user()->department->title }}</option>
                </select>

                <select name="st_bureau_code" class="form-control" title="สำนัก" required readonly style="width:auto; display:inline;">
                    <option value="{{ @Auth::user()->st_bureau_code }}" selected>{{ @Auth::user()->bureau->title }}</option>
                </select>

                <select name="st_division_code" class="form-control" title="กลุ่ม" required readonly style="width:auto; display:inline;">
                    <option value="{{ @Auth::user()->st_division_code }}" selected>{{ @Auth::user()->division->title }}</option>
                </select>

            @elseif(CanPerm('access-all'))

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

            @endif

            </div>
        </td>
    </tr>
    <tr>
        <th>เบอร์ติดต่อ <span class="Txt_red_12">*</span></th>
        <td>
            <div class="form-inline">
                <input name="tel" value="{{ isset($rs->tel) ? $rs->tel : old('tel') }}" type="text" class="form-control {{ $errors->has('tel') ? 'has-error' : '' }}" placeholder="เบอร์ติดต่อ" style="width:300px;" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>เปิด/ปิด</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$rs->status == 1 ||
            empty($rs->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>

<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-driver') }}'" class="btn btn-default" style="width:100px;" />
</div>