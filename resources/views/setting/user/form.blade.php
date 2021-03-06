<?php
    // สิทธิ์การใช้งาน
    $permission_groups = App\Model\PermissionGroup::where('status',1)->orderBy('id','asc')->get();

    // คำนำหน้าชื่อ
    $st_prefixs = App\Model\StPrefix::where('status', 1)->orderBy('id','asc')->get();

    // หน่วยงาน
    $st_ministries = App\Model\StMinistry::orderBy('code', 'asc')->get();
    $st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();

    if (old('st_department_code')) {
        $st_bureaus = App\Model\StBureau::where('code', 'like', old('st_department_code') . '%')->orderBy('code', 'asc')->get();
    }

    if (old('st_bureau_code')) {
        $st_divisions = App\Model\StDivision::where('code', 'like', old('st_bureau_code') . '%')->orderBy('code', 'asc')->get();
    }

    if (isset($user->st_department_code)) {
        $st_bureaus = App\Model\StBureau::where('code', 'like', $user->st_department_code . '%')->orderBy('code', 'asc')->get();
    }

    if (isset($user->st_bureau_code)) {
        $st_divisions = App\Model\StDivision::where('code', 'like', $user->st_bureau_code . '%')->orderBy('code', 'asc')->get();
    }
?>

<table class="tbadd">
    <tr>
        <th>คำนำหน้าชื่อ<span class="Txt_red_12"> *</span></th>
        <td>
            <select name="st_prefix_code" id="lunch" class="selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}" data-live-search="true" data-size="10" title="คำนำหน้าชื่อ" required>
                <option value="">+ คำนำหน้าชื่อ +</option>
                @foreach($st_prefixs as $item)
                <option value="{{ $item->code }}" @if($item->code == @old('st_prefix_code')) selected="selected" @endif @if($item->code == @$user->st_prefix_code) selected="selected" @endif>{{ $item->title }}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <th>ชื่อตัว<span class="Txt_red_12"> *</span></th>
        <td><input name="givename" type="text" class="form-control {{ $errors->has('givename') ? 'has-error' : '' }}"
                id="givename" value="{{ isset($user->givename) ? $user->givename : old('givename') }}"
                style="width:400px;" required /></td>
    </tr>
    <tr>
        <th>ชื่อรอง</th>
        <td><input name="middlename" type="text"
                class="form-control {{ $errors->has('middlename') ? 'has-error' : '' }}" id="middlename"
                value="{{ isset($user->middlename) ? $user->middlename : old('middlename') }}" style="width:400px;" />
        </td>
    </tr>
    <tr>
        <th>ชื่อสกุล<span class="Txt_red_12"> *</span></th>
        <td><input name="familyname" type="text"
                class="form-control {{ $errors->has('familyname') ? 'has-error' : '' }}" id="familyname"
                value="{{ isset($user->familyname) ? $user->familyname : old('familyname') }}" style="width:400px;"
                required /></td>
    </tr>
    <!-- <tr>
        <th>ชื่อ-สกุลผู้ใช้งาน<span class="Txt_red_12"> *</span></th>
        <td><input name="name" type="text" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" id="name" value="{{ isset($user->name) ? $user->name : ''}}" style="width:400px;" required/></td>
    </tr> -->
    <tr>
        <th>เลขบัตรประชาชน<span class="Txt_red_12"> *</span></th>
        <td><input name="idcard" type="text"
                class="form-control fidcard {{ $errors->has('idcard') ? 'has-error' : '' }}" id="idcard"
                value="{{ isset($user->idcard) ? $user->idcard : old('idcard') }}" style="width:400px;" required /></td>
    </tr>
    <tr>
        <th>หน่วยงาน<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline dep-chain-group">

                <select name="st_department_code" id="lunch"
                    class="chain-department selectpicker {{ $errors->has('st_department_code') ? 'has-error' : '' }}"
                    data-live-search="true" data-size="10" title="กรม" required>
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected"
                        @endif @if($item->code == @$user->st_department_code) selected="selected"
                        @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code" id="lunch"
                    class="chain-bureau selectpicker {{ $errors->has('st_bureau_code') ? 'has-error' : '' }}" data-live-search="true"
                    data-size="10" title="สำนัก" required>
                    <option value="">+ สำนัก +</option>
                    @if(old('st_department_code') || isset($user->st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected"
                        @endif @if($item->code == @$user->st_bureau_code) selected="selected" @endif>{{ $item->title }}
                    </option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code" id="lunch"
                    class="chain-division selectpicker {{ $errors->has('st_division_code') ? 'has-error' : '' }}"
                    data-live-search="true" data-size="10" title="กลุ่ม" required>
                    <option value="">+ กลุ่ม +</option>
                    @if(old('st_bureau_code') || isset($user->st_bureau_code))
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected"
                        @endif @if($item->code == @$user->st_division_code) selected="selected"
                        @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

            </div>
        </td>
    </tr>
    <tr>
        <th>อีเมล์<span class="Txt_red_12"> *</span> / หมายเลขติดต่อ</th>
        <td><span class="form-inline">
                <input name="email" type="text" class="form-control {{ $errors->has('email') ? 'has-error' : '' }}"
                    id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" placeholder="อีเมล์"
                    style="width:300px;" required />
                /
                <input name="tel" type="text" class="form-control" id="tel"
                    value="{{ isset($user->tel) ? $user->tel : old('tel') }}" placeholder="เบอร์ติดต่อ"
                    style="width:300px;" />
            </span> </span></td>
    </tr>
    <tr>
        <th>สิทธิ์การใช้งาน <span class="Txt_red_12"> *</span></th>
        <td><span class="form-inline">
                <select name="permission_group_id"
                    class="form-control {{ $errors->has('permission_group_id') ? 'has-error' : '' }}"
                    style="width:auto;" required>
                    <option value="">เลือกสิทธิ์การใช้งาน</option>
                    @foreach($permission_groups as $item)
                    <option value="{{ $item->id }}" @if($item->id == @old('permission_group_id')) selected="selected"
                        @endif @if($item->id == @$user->permission_group_id) selected="selected"
                        @endif>{{ $item->title }}</option>
                    @endforeach
                </select>
            </span></td>
    </tr>
    <!-- <tr>
        <th>Username<span class="Txt_red_12"> *</span></th>
        <td><input name="textarea2" type="text" class="form-control" id="textarea2" value="" style="width:200px;" /></td>
    </tr> -->
    <tr>
        <th>Password</th>
        <td><input name="password" type="password" class="form-control" id="password" value="" style="width:200px;" />
        </td>
    </tr>
    <tr>
        <th>Confirm Password</th>
        <td><input name="confirm_password" type="password" class="form-control" id="confirm_password" value="" style="width:200px;" /></td>
    </tr>
    <tr>
        <th>เปิดการใช้งาน</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$user->status == 1 ||
            empty($user->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"
        value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"
        onclick="document.location='{{ url('/setting/user') }}'" class="btn btn-default" style="width:100px;" />
</div>

@push('js')
<script>
$(document).ready(function(){
    // chkDigitPid('1-3499-00024-00-7');
    var xxx = '1-3499-00024-00-7';
    console.log(xxx.length);

    $('form').submit(function () {
        var idCard = $.trim($('[name=idcard]').val());
        if(!chkDigitPid(idCard)){
            alert("หมายเลขประจำตัวประชาชนไม่ถูกต้อง");
            return false;
        }
    });
});

function chkDigitPid(p_iPID) {
    var total = 0;
    var iPID;
    var chk;
    var Validchk;
    iPID = p_iPID.replace(/-/g, "");
    Validchk = iPID.substr(12, 1);
    var j = 0;
    var pidcut;
    for (var n = 0; n < 12; n++) {
        pidcut = parseInt(iPID.substr(j, 1));
        total = (total + ((pidcut) * (13 - n)));
        j++;
    }

    chk = 11 - (total % 11);

    if (chk == 10) {
        chk = 0;
    } else if (chk == 11) {
        chk = 1;
    }
    if (chk == Validchk) {
        // alert("ระบุหมายเลขประจำตัวประชาชนถูกต้อง");
        return true;
    } else {
        // alert("ระบุหมายเลขประจำตัวประชาชนไม่ถูกต้อง");
        return false;
    }
}
</script>
@endpush
