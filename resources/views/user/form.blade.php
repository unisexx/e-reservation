@extends('layout.template')

@section('content')
<h3>ผู้ใช้งาน (เพิ่ม / แก้ไข)</h3>
<table class="tbadd">
  <tr>
    <th>ชื่อ-สกุลผู้ใช้งาน<span class="Txt_red_12"> *</span></th>
    <td><input name="textarea7" type="text" class="form-control" id="textarea7" value="" style="width:400px;"/></td>
  </tr>
  <tr>
    <th>เลขบัตรประชาชน<span class="Txt_red_12"> *</span></th>
    <td><input name="textarea6" type="text" class="form-control" id="textarea6" value="" style="width:400px;"/></td>
  </tr>
  <tr>
    <th>หน่วยงาน<span class="Txt_red_12"> *</span></th>
    <td><div class="form-inline">
      <select name="lunch2" class="selectpicker" id="lunch" title="หน่วยงาน" data-live-search="true">
        <option>[06102008001] กองยุทธศาสตร์และแผนงาน ฝ่ายบริหารทั่วไป</option>
      <option>[06102011001] ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร ฝ่ายบริหารทั่วไป</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <th>อีเมล์<span class="Txt_red_12"> *</span> / หมายเลขติดต่อ</th>
    <td><span class="form-inline">
      <input name="textarea4" type="text" class="form-control" id="textarea4" value="" placeholder="อีเมล์" style="width:300px;"/>
      /
      <input name="textarea5" type="text" class="form-control" id="textarea5" value="" placeholder="เบอร์ติดต่อ" style="width:300px;"/>
    </span> </span></td>
  </tr>
  <tr>
    <th>สิทธิ์การใช้งาน</th>
    <td><span class="form-inline">
      <select name="select" class="form-control" style="width:auto;">
        <option selected="selected">เลือกสิทธิ์การใช้งาน</option>
        <option>SuperAdmin</option>
        <option>Admin</option>
        <option>User</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <th>Username<span class="Txt_red_12"> *</span></th>
    <td><input name="textarea2" type="text" class="form-control" id="textarea2" value="" style="width:200px;"/></td>
  </tr>
  <tr>
    <th>Password<span class="Txt_red_12"> *</span></th>
    <td><input name="textarea" type="text" class="form-control" id="textarea" value="" style="width:200px;"/></td>
  </tr>
  <tr>
    <th>Confirm Password<span class="Txt_red_12"> *</span></th>
    <td><input name="textarea3" type="text" class="form-control" id="textarea3" value="" style="width:200px;"/></td>
  </tr>
  <tr>
    <th>เปิด/ปิด</th>
    <td><input name="checkbox17" type="checkbox" id="checkbox7" checked="checked" /></td>
  </tr>
</table>
<div id="btnBoxAdd">
  <input name="input" type="button" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"/>
  <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"  onclick="history.back(-1)"  class="btn btn-default" style="width:100px;"/>
</div>

@endsection