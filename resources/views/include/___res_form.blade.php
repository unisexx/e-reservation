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

if (isset($st_boss_res->st_department_code)) {
    $st_bureaus = App\Model\StBureau::where('code', 'like', $st_boss_res->st_department_code . '%')->orderBy('code', 'asc')->get();
}

if (isset($st_boss_res->st_bureau_code)) {
    $st_divisions = App\Model\StDivision::where('code', 'like', $st_boss_res->st_bureau_code . '%')->orderBy('code', 'asc')->get();
}
?>

<div class="dep-chain-group" style="margin-top:10px;">
    <div class="form-inline">
        {{ Form::text("res[res_name][]", @$st_boss_res->res_name, ['class'=>'form-control', 'placeholder'=>'ชื่อผู้ดูแล', 'style'=>'width:300px', 'required'=>'required']) }}
        {{ Form::text("res[res_tel][]", @$st_boss_res->res_tel, ['class'=>'form-control', 'placeholder'=>'เบอร์ติดต่อ', 'style'=>'width:200px', 'required'=>'required']) }}

        <select name="res[st_department_code][]" id="lunch" class="chain-department selectpicker" data-live-search="true" data-size="8" title="กรม" required>
            <option value="">+ กรม +</option>
            @foreach($st_departments as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_department_code')) selected="selected" @endif @if($item->code == @$st_boss_res->st_department_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
        </select>

        <select name="res[st_bureau_code][]" id="lunch" class="chain-bureau selectpicker" data-live-search="true" data-size="8" title="สำนัก" required>
            <option value="">+ สำนัก +</option>
            @if(old('st_department_code') || isset($st_boss_res->st_department_code))
            @foreach($st_bureaus as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_bureau_code')) selected="selected" @endif @if($item->code == @$st_boss_res->st_bureau_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

        <select name="res[st_division_code][]" id="lunch" class="chain-division selectpicker" data-live-search="true" data-size="8" title="กลุ่ม" required>
            <option value="">+ กลุ่ม +</option>
            @if(old('st_bureau_code') || isset($st_boss_res->st_bureau_code))
            @foreach($st_divisions as $item)
            <option value="{{ $item->code }}" @if($item->code == @old('st_division_code')) selected="selected" @endif @if($item->code == @$st_boss_res->st_division_code) selected="selected" @endif>{{ $item->title }}</option>
            @endforeach
            @endif
        </select>

        {{ Form::hidden("res[id][]", @$st_boss_res->id) }}

        <img class="removeRes" src="{{ asset('images/remove-circle.png') }}" width="16" style="cursor: pointer;" data-id="{{ @$st_boss_res->id }}">
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');
    });
</script>