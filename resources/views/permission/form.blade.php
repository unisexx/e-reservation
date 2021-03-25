@extends('layout.template')

@section('content')
<h3>สิทธิ์การใช้งาน (เพิ่ม / แก้ไข)</h3>
<table class="tbadd">
<tr>
  <th>ชื่อสิทธิ์การใช้งาน<span class="Txt_red_12"> *</span></th>
  <td><input name="textarea7" type="text" class="form-control" id="textarea7" value="" style="width:400px;"/></td>
</tr>
<tr>
  <th>ความสามารถเรียกดูรายการ<span class="Txt_red_12"> *</span></th>
  <td>
    <label class="chkbox"><input type="radio" name="radio" id="radio3" value="radio" />
    ทั้งหมด
    </label>
<label class="chkbox"><input type="radio" name="radio" id="radio4" value="radio" />
  เฉพาะตนเอง</label>
<!--<span style="border-bottom:#999 dashed 1px; margin-bottom:10px;"><label style="font-weight:700;"><input type="checkbox" name="checkbox2" id="checkbox2" /> 
    IsAdmin</label> </span>-->
</td>
</tr>
<tr>
  <th class="paddL40">จองห้องประชุม</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox4" id="checkbox4" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox4" id="checkbox4" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox4" id="checkbox4" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox4" id="checkbox4" />
    ลบ</label></td>
</tr>
<tr>
  <th class="paddL40">จองยานพาหนะ</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox3" id="checkbox3" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox3" id="checkbox3" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox3" id="checkbox3" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox3" id="checkbox3" />
      ลบ</label></td>
  </tr>
<tr>
  <th colspan="2" class="topic">เมนูตั้งค่าข้อมูลหลัก</th>
</tr>
<tr>
  <th class="paddL40">ผู้ใช้งาน</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox2" id="checkbox2" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox2" id="checkbox2" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox2" id="checkbox2" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox2" id="checkbox2" />
    ลบ</label></td>
</tr>
<tr>
  <th class="paddL40">สิทธิ์การใช้งาน</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox7" id="checkbox10" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox7" id="checkbox10" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox7" id="checkbox10" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox7" id="checkbox10" />
    ลบ</label></td>
</tr>
<tr>
  <th class="paddL40">ห้องประชุม</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox9" id="checkbox13" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox9" id="checkbox13" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox9" id="checkbox13" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox9" id="checkbox13" />
    ลบ</label></td>
</tr>
<tr>
  <th class="paddL40">ยานพาหนะ</th>
  <td><label class="chkbox">
    <input type="checkbox" name="checkbox10" id="checkbox14" />
    ดู</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox10" id="checkbox14" />
      เพิ่ม</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox10" id="checkbox14" />
      แก้ไข</label>
    <label class="chkbox">
      <input type="checkbox" name="checkbox10" id="checkbox14" />
    ลบ</label></td>
</tr>
<tr>
  <th colspan="2" class="topic">เมนูรายงาน</th>
</tr>
<tr>
  <th class="paddL40">รายงาน 1</th>
  <td><input type="checkbox" name="checkbox17" id="checkbox7" />
ดู</td>
</tr>
<tr>
  <th class="paddL40">รายงาน 2  </th>
  <td><input type="checkbox" name="checkbox18" id="checkbox8" />
ดู</td>
</tr>
<tr>
  <th class="paddL40">ประวัติการใช้งาน</th>
  <td><input type="checkbox" name="checkbox19" id="checkbox19" />
ดู</td>
  </tr>
</table>
<div id="btnBoxAdd">
  <input name="input" type="button" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"/>
  <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"  onclick="history.back(-1)"  class="btn btn-default" style="width:100px;"/>
</div>
@endsection