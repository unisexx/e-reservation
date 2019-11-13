@extends('layouts.admin')

@section('content')

<h3>ผู้ใช้งาน (เปลี่ยนรหัสผ่าน)</h3>

@if ($errors->any())
<ul class="alert alert-danger list-unstyled">
    <li><b>ไม่สามารถบันทึกได้เนื่องจาก</b></li>
    @foreach ($errors->all() as $error)
    <li>- {{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ url('profile_save') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <?php
        // สิทธิ์การใช้งาน
        $permission_groups = App\Model\PermissionGroup::where('status',1)->orderBy('id','asc')->get();

        // คำนำหน้าชื่อ
        $st_prefixs = App\Model\StPrefix::orderBy('id','asc')->get();

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
            <th>ชื่อ - สกุล</th>
            <td>{{ $user->prefix->title ?? '-' }}{{ $user->givename ?? '-'}} {{ $user->middlename ?? ''}} {{ $user->familyname ?? '-'}}</td>
        </tr>
        <tr>
            <th>เลขบัตรประชาชน</th>
            <td>{{ $user->idcard ?? '-'}}</td>
        </tr>
        <tr>
            <th>หน่วยงาน</th>
            <td>
                <div class="form-inline">
                    {{ $user->department->title ?? '-'}} >
                    {{ $user->bureau->title ?? '-'}} >
                    {{ $user->division->title ?? '-'}}
                </div>
            </td>
        </tr>
        <tr>
            <th>อีเมล์ / หมายเลขติดต่อ</th>
            <td>{{ $user->email ?? '-' }} / {{ $user->tel ?? '-' }}</td>
        </tr>
        <tr>
            <th>สิทธิ์การใช้งาน</th>
            <td>
                {{ $user->permission_group->title ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>รหัสผ่านปัจจุบัน<span class="Txt_red_12"> *</span></th>
            <td><input name="now_password" type="password" class="form-control" id="password" value="" style="width:200px;" />
            </td>
        </tr>
        <tr>
            <th>รหัสผ่านใหม่<span class="Txt_red_12"> *</span></th>
            <td><input name="password" type="password" class="form-control" id="password" value="" style="width:200px;" />
            </td>
        </tr>
        <tr>
            <th>ยืนยันรหัสผ่านใหม่<span class="Txt_red_12"> *</span></th>
            <td><input name="password_confirmation" type="password" class="form-control" value="" style="width:200px;" /></td>
        </tr>
    </table>
    <div id="btnBoxAdd">
        <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"/>
        <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"
            onclick="document.location='{{ url('home') }}'" class="btn btn-default" style="width:100px;" />
    </div>


</form>

@endsection
