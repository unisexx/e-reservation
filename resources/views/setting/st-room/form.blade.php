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

if (isset($stroom->st_department_code)) {
    $st_bureaus = App\Model\StBureau::where('code', 'like', $stroom->st_department_code . '%')->orderBy('code', 'asc')->get();
}

if (isset($stroom->st_bureau_code)) {
    $st_divisions = App\Model\StDivision::where('code', 'like', $stroom->st_bureau_code . '%')->orderBy('code', 'asc')->get();
}
?>

<table class="tbadd">
    <tr class="{{ $errors->has('image') ? 'has-error' : '' }}">
        <th>ภาพห้องประชุม<span class="Txt_red_12"> *</span></th>
        <td>
            @if(isset($stroom->image))
            <img src="{{ url('uploads/room/'.$stroom->image) }}" width="90">
            @endif
            <input type="file" name="image" />
        </td>
    </tr>
    <tr class="{{ $errors->has('name') ? 'has-error' : '' }}">
        <th>ชื่อห้องประชุม<span class="Txt_red_12"> *</span></th>
        <td>
            <input name="name" type="text" class="form-control" value="{{ isset($stroom->name) ? $stroom->name : old('name') }}" style="width:500px;" required />
        </td>
    </tr>
    <tr class="{{ $errors->has('people') ? 'has-error' : '' }}">
        <th>จำนวนคนที่รับรองได้<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline"><input name="people" type="number" min="1" class="form-control" value="{{ isset($stroom->people) ? $stroom->people : old('people') }}" style="width:100px;" required /> คน</div>
        </td>
    </tr>
    <tr class="{{ $errors->has('equipment') ? 'has-error' : '' }}">
        <th>อุปกรณ์ที่ติดตั้งในห้อง<span class="Txt_red_12"> *</span></th>
        <td><input name="equipment" type="text" class="form-control" value="{{ isset($stroom->equipment) ? $stroom->equipment : old('equipment') }}" style="width:500px;" required />
        </td>
    </tr>
    <tr class="{{ $errors->has('res_name') || $errors->has('res_tel') || $errors->has('res_department_id') ? 'has-error' : '' }}">
        <th>ผู้รับผิดชอบห้องประชุม<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline" style="margin-bottom:5px;">
                <input name="res_name" type="text" class="form-control" placeholder="ชื่อผู้รับผิดชอบ" value="{{ isset($stroom->res_name) ? $stroom->res_name : old('res_name') }}" style="width:300px;" required />
                <input name="res_tel" type="text" class="form-control" placeholder="เบอร์ติดต่อ" value="{{ isset($stroom->res_tel) ? $stroom->res_tel : old('res_tel') }}" style="width:200px;" required />
            </div>

            <select name="st_department_code" id="lunch" class="selectpicker" data-live-search="true" title="กรม" required>
                <option value="">+ กรม +</option>
                @foreach($st_departments as $item)
                <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$stroom->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
            </select>

            <select name="st_bureau_code" id="lunch" class="selectpicker" data-live-search="true" title="สำนัก" required>
                <option value="">+ สำนัก +</option>
                @if(old('st_department_code') || isset($stroom->st_department_code))
                @foreach($st_bureaus as $item)
                <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$stroom->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
                @endif
            </select>

            <select name="st_division_code" id="lunch" class="selectpicker" data-live-search="true" title="กลุ่ม" required>
                <option value="">+ กลุ่ม +</option>
                @if(old('st_bureau_code') || isset($stroom->st_bureau_code))
                @foreach($st_divisions as $item)
                <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$stroom->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
                @endif
            </select>


        </td>
    </tr>
    <tr>
        <th>ค่าใช้จ่าย/ค่าธรรมเนียมฯ<span class="Txt_red_12"> *</span></th>
        <td>
            <label style="margin-right:20px;"><input name="fee" type="radio" value="มี" {!! (@$stroom->fee == 'มี' || empty($stroom->id)) ? 'checked="checked"' : '' !!}/> มี</label>
            <label><input name="fee" type="radio" value="ไม่มี" {!! @$stroom->fee == 'ไม่มี' ? 'checked="checked"' : '' !!}/> ไม่มี</label>
        </td>
    </tr>
    <tr>
        <th>หมายเหตุ</th>
        <td><textarea name="note" rows="5" class="form-control" id="textarea" style="width:500px;">{{ isset($stroom->note) ? $stroom->note : '' }}</textarea></td>
    </tr>
    <tr>
        <th>เปิด/ปิด</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$stroom->status == 1 || empty($stroom->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-room') }}'" class="btn btn-default" style="width:100px;" />
</div>