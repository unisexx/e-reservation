@extends('layout.template')

@section('content')
<h3>ตั้งค่า ห้องประชุม (เพิ่ม / แก้ไข)</h3>
<table class="tbadd">
<tr>
  <th>ภาพห้องประชุม<span class="Txt_red_12"> *</span></th>
  <td><input type="file" name="fileField" id="fileField" /></td>
</tr>
<tr>
  <th>ชื่อห้องประชุม<span class="Txt_red_12"> *</span></th>
  <td><input name="textarea7" type="text" class="form-control" id="textarea7" value="" style="width:500px;"/></td>
</tr>
<tr>
  <th>จำนวนคนที่รับรองได้<span class="Txt_red_12"> *</span></th>
  <td><div class="form-inline"><input name="textarea4" type="text" class="form-control" id="textarea4" value="" style="width:100px;"/> คน</div></td>
</tr>
<tr>
  <th>อุปกรณ์ที่ติดตั้งในห้อง<span class="Txt_red_12"> *</span></th>
  <td><input name="textarea5" type="text" class="form-control" id="textarea5" value="" style="width:500px;"/></td>
</tr>
<tr>
  <th>ผู้รับผิดชอบห้องประชุม<span class="Txt_red_12"> *</span></th>
  <td>
  <div class="form-inline" style="margin-bottom:5px;">
    <input type="text" class="form-control " id="exampleInputEmail2" placeholder="ชื่อผู้รับผิดชอบ" value="" style="width:300px;" />
    <input type="text" class="form-control " id="exampleInputEmail2" placeholder="เบอร์ติดต่อ" value="" style="width:200px;" />
    </div>
    <select name="lunch2" class="selectpicker" id="lunch" title="สังกัด" data-live-search="true">
      <option>[สป-สบก(กอก)]	สำนักบริหารงานกลาง กลุ่มอำนวยการ</option>
      <option>[สป-สบก(กพบ)]	สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล</option>
    </select>
    
    
  </td>
</tr>
<tr>
  <th>ค่าใช้จ่าย/ค่าธรรมเนียมฯ<span class="Txt_red_12"> *</span></th>
  <td><label style="margin-right:20px;"><input name="" type="radio" value="" /> มี</label> <label><input name="" type="radio" value="" /> ไม่มี</label></td>
</tr>
<tr>
  <th>หมายเหตุ</th>
  <td><textarea name="textarea" rows="5" class="form-control" id="textarea" style="width:500px;"></textarea></td>
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