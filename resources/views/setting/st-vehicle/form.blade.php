<?php
// ประเภทรถ
$st_vehicle_types = App\Model\StVehicleType::where('status', '1')->orderBy('id', 'asc')->get();

// หน่วยงานที่รับผิดชอบ
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
    <tr class="{{ $errors->has('image') ? 'has-error' : '' }}">
        <th>ภาพยานพาหนะ <span class="Txt_red_12"> *</span></th>
        <td>
            @if(isset($rs->image))
            <img src="{{ url('uploads/vehicle/'.$rs->image) }}" width="90">
            @endif
            <input type="file" name="image" />
        </td>
    </tr>
    <tr>
        <th>ประเภท<span class="Txt_red_12"> *</span> / ยี่ห้อ<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <select name="st_vehicle_type_id" class="form-control {{ $errors->has('st_vehicle_type_id') ? 'has-error' : '' }}" required>
                    @foreach($st_vehicle_types as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>

                <input name="brand" type="text" class="form-control {{ $errors->has('brand') ? 'has-error' : '' }}" placeholder="ยี่ห้อ" style="width:300px;" value="{{ isset($rs->brand) ? $rs->brand : old('brand') }}" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>ที่นั่ง<span class="Txt_red_12"> *</span> / สี <span class="Txt_red_12"> *</span> / เลขทะเบียน<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="seat" type="text" class="form-control {{ $errors->has('seat') ? 'has-error' : '' }}" placeholder="ที่นั่ง" style="width:100px;" value="{{ isset($rs->seat) ? $rs->seat : old('seat') }}" required />
                <input name="color" type="text" class="form-control {{ $errors->has('color') ? 'has-error' : '' }}" placeholder="สี" style="width:200px;" value="{{ isset($rs->color) ? $rs->color : old('color') }}" required />
                <input name="reg_number" type="text" class="form-control {{ $errors->has('reg_number') ? 'has-error' : '' }}" placeholder="เลขทะเบียน" style="width:200px;" value="{{ isset($rs->reg_number) ? $rs->reg_number : old('reg_number') }}" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>หน่วยงานที่รับผิดชอบ<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline dep-chain-group">
            
            <div class="form-inline" style="margin-bottom:5px;">
                <input name="res_name" type="text" class="form-control {{ $errors->has('res_name') ? 'has-error' : '' }}" placeholder="ชื่อผู้รับผิดชอบ" value="{{ isset($rs->res_name) ? $rs->res_name : old('res_name') }}" style="width:300px;" required />
                <input name="res_tel" type="text" class="form-control {{ $errors->has('res_tel') ? 'has-error' : '' }}" placeholder="เบอร์ติดต่อ" value="{{ isset($rs->res_tel) ? $rs->res_tel : old('res_tel') }}" style="width:200px;" required />
            </div>

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

                <select name="st_department_code"  class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" title="กรม" required>
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$rs->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code"  class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true" title="สำนัก" required>
                    <option value="">+ สำนัก +</option>
                    @if(old('st_department_code') || isset($rs->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$rs->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code"  class="chain-division selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}" data-live-search="true" title="กลุ่ม" required>
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
    {{-- <tr>
        <th>พนักงานขับวันนี้<span class="Txt_red_12"> *</span></th>
        <td>
            <span class="form-inline">
                <select name="st_driver_id" class="form-control {{ $errors->has('st_driver_id') ? 'has-error' : '' }}" required>
                <option value="">+ พนักงานขับรถ +</option>
                </select>
            </span>
        </td>
    </tr> --}}
    <tr>
        <th>สถานะ</th>
        <td>
            <span class="form-inline">
                <select name="status" class="form-control">
                    <option value="พร้อมใช้" @if(@$rs->status == 'พร้อมใช้') selected='selected' @endif>พร้อมใช้</option>
                    <option value="ซ่อมบำรุง" @if(@$rs->status == 'ซ่อมบำรุง') selected='selected' @endif>ซ่อมบำรุง</option>
                    <option value="งดให้บริการ" @if(@$rs->status == 'งดให้บริการ') selected='selected' @endif>งดให้บริการ</option>
                </select>
            </span>
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-vehicle') }}'" class="btn btn-default" style="width:100px;" />
</div>

<script>
$(document).ready(function(){
    getDriver();
    $('body').on('change', 'select[name=st_department_code]', function() {
        getDriver();
    });
    $('body').on('change', 'select[name=st_bureau_code]', function() {
        getDriver();
    });
    $('body').on('change', 'select[name=st_division_code]', function() {
        getDriver();
    });
});

function getDriver(){
    if( $('select[name=st_department_code]').val() != ''){
        $('select[name=st_driver_id]').empty();
        $.ajax({
            url: '{{ url("ajaxGetDriver") }}',
            data: {
                st_department_code: $('select[name=st_department_code]').val(),
                st_bureau_code: $('select[name=st_bureau_code]').val(),
                st_division_code: $('select[name=st_division_code]').val()
            }
        })
        .done(function(data) {
            $.map(data, function(i) {
                $('select[name=st_driver_id]').append('<option value="' + i.id + '">' + i.name + '</option>');
            });
        });
    }
}
</script>