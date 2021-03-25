@extends('layout.template')

@section('content')
<h3>ตั้งค่า พนักงานขับ (เพิ่ม / แก้ไข)</h3>
<table class="tbadd">
<tr>
  <th>ชื่อสกุล<span class="Txt_red_12"> *</span></th>
  <td><div class="form-inline">
    <input name="textarea4" type="text" class="form-control" id="textarea4" placeholder="ชื่อ-สกุล" style="width:500px;"/></div></td>
</tr>
<tr>
  <th>หน่วยงาน<span class="Txt_red_12"> *</span></th>
  <td><div class="form-inline">
    <select name="lunch2" class="selectpicker" id="lunch" title="หน่วยงาน" data-live-search="true">
      <option>[สป-สบก(กอก)]	สำนักบริหารงานกลาง กลุ่มอำนวยการ</option>
      <option>สป-สบก(กพบ)]	สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล</option>
    </select>
  </div></td>
</tr>
<tr>
  <th>เบอร์ติดต่อ <span class="Txt_red_12">*</span></th>
  <td><div class="form-inline">
    <input name="textarea4" type="text" class="form-control" id="textarea4" placeholder="เบอร์ติดต่อ" style="width:300px;"/>
    </div></td>
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