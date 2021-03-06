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
                <input name="name" type="text" class="form-control chkDoubleSraA" placeholder="ชื่อ-สกุล" style="width:500px;" value="{{ $rs->name ?? old('name') }}" required/></div>
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
        <th>ผู้ดูแลผู้บริหาร</th>
        <td>
            @php
                // หา permission_group_id ที่มีสิทธิ์ในการดูแลผู้บริหาร (permission_id = 93)
                $permission_group_ids = \App\Model\PermissionGroup::whereHas('permissionRole', function($q){
                    $q->where('permission_id',93);
                })->pluck('id');

                // เอา permission_group_id ที่ได้มาหา user
                $users = \App\User::whereIn('permission_group_id', $permission_group_ids)->where('status', 1)->get();

            @endphp
            @foreach($users as $user)
            <div>
                <label>
                    {{ Form::checkbox('res[user_id][]', @$user->id, @count($rs->stBossRes) ? @$rs->stBossRes->where('user_id', @$user->id)->count() > 0 ? true : false : '') }} {{ @$user->prefix->title }} {{ @$user->givename }} {{ @$user->familyname }}
                </label>
            </div>
            @endforeach
        </td>
    </tr>
    <tr>
        <th>สี<span class="Txt_red_12"> *</span></th>
        <td>
            {{ Form::text('color', $rs->color ?? '#f1f1f1', ['id' => 'custom', 'class'=>'form-control', 'required']) }}
        </td>
    </tr>
    <tr>
        <th>อักษรย่อ<span class="Txt_red_12"> *</span></th>
        <td>
            {{ Form::text('abbr', @$rs->abbr, ['class'=>'form-control', 'required', 'maxlength'=>'2', 'size'=>'2', 'style'=>'width:50px']) }}
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

@push('js')
<script>
    $(document).ready(function(){
        // กดปุ่มเพิ่มตัวชี้วัด
        $('body').on('click','#addRes',function(){
            $('#resHere').append($('<div>').load('{{ url("load-bossres") }}'));
        });
    });

    // กดปุ่มลบผู้ดูแล
    $('body').on('click', '.removeRes', function(){
        Swal.fire({
        title: 'ยืนยันการลบข้อมูล?',
        text: "หลังจากที่ลบไปแล้วจะไม่สามารถดึงข้อมูลนี้กลับมาได้อีก!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ลบเลย',
        cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                // create remove input
                if($(this).attr('data-id').length){
                    $("<input type='hidden' name='removeRes[id][]' value='"+$(this).attr('data-id')+"'>").appendTo("form");
                }
                // remove item
                $(this).closest('.dep-chain-group').remove();

                // เช็กว่าเป็นแถวสุดท้ายหรือไม่
                chkResRow();
            }
        });
    });

    // ถ้าไม่มีแถวฟอร์มผู้ดูแล ให้เพิ่มอัติโนมัติ 1 แถว
    function chkResRow(){
        if($('.dep-chain-group').length == 0){
            $('#resHere').append($('<div>').load('{{ url("load-bossres") }}'));
        }
    }
</script>
@endpush

@push('js')
<script>
    $("#custom").spectrum({
        preferredFormat: "hex"
    });
</script>
@endpush