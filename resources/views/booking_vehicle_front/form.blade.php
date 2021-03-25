@extends('layout.template')

@section('content')
<h3>จองห้องประชุม (เพิ่ม / แก้ไข)</h3>

<div class="form-group form-inline col-md-12">
        <label>รหัสการจอง / เลือกห้องประชุม<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Generate Auto" readonly="readonly"> /
  
  <input type="text" class="form-control" id="exampleInputEmail2" style="min-width:400px;" readonly="readonly">
        <a class='inline' href="#inline_room"><input type="button" title="เลือกห้องประชุม" value="เลือกห้องประชุม" class="btn btn-info vtip" /></a>
   
        </div>
        
        
        <div class="form-group form-inline col-md-12">
  <label>ชื่อเรื่อง / หัวข้อการประชุม<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="ชื่อห้องประชุม" value="" style="min-width:500px;">
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>วัน เวลา ที่ต้องการใช้ห้องประชุม<span class="Txt_red_12"> *</span> / จำนวนผู้เข้าร่วมประชุม<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control fdate" id="exampleInputEmail" value="" style="width:120px;" />
  <img src="{{ url('images/calendar.png') }}" width="24" height="24" /> 
  <input type="text" class="form-control ftime" id="exampleInputEmail3" placeholder="เวลา" value="" style="width:70px;" /> 
  น.
  - 
  <input type="text" class="form-control fdate" id="exampleInputEmail4" value="" style="width:120px;" />
  <img src="{{ url('images/calendar.png') }}" width="24" height="24" />
  <input type="text" class="form-control ftime" id="exampleInputEmail5" placeholder="เวลา" value="" style="width:70px;" />
น 
  /
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="จำนวน" value="" style="width:100px;"> 
คน
  
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
  <div style="margin-bottom:5px;">
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="ชื่อผู้ขอใช้ห้องประชุม" value="" style="min-width:300px;">

  <select name="lunch2" class="selectpicker" id="lunch" title="สังกัด" data-live-search="true">
    <option>[สป-สบก(กอก)]	สำนักบริหารงานกลาง กลุ่มอำนวยการ</option>
    <option>สป-สบก(กพบ)]	สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล</option>
  </select>
</div>
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="เบอร์โทรศัพท์" value="" style="min-width:300px;">
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="อีเมล์" value="" style="min-width:300px;">
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>หมายเหตุ หรือรายละเอียดอื่นๆ</label>
  <textarea class="form-control " id="exampleInputEmail2" style="min-width:800px; height:80px"></textarea>
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>สถานะ</label>
  <select name="select" class="form-control" style="width:auto;">
    <option selected="selected">รออนุมัติ</option>
    <option>อนุมัติ</option>
    <option>ไม่อนุมัติ</option>
    <option>ยกเลิก</option>
</select></div>
        
        <div class="form-group form-inline col-md-12">
        <div id="btnBoxAdd">
        <input name="input" type="button" title="บันทึก" value="บันทึกข้อมูล" class="btn btn-primary"/>
        <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"  onclick="history.back(-1)"  class="btn btn-default"/>
  		
		</div>
		</div>




<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
<div id='inline_room' style='padding:5px; background:#fff;'>
<h3 style="margin:0; padding:0; color:#636">เลือกห้องประชุม</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
<input type="text" class="form-control" style="width:400px;" id="exampleInputName2" placeholder="ชื่อห้องประชุม" />
<button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</form>
</div>
</div>

<table class="tblist">
<tr>
  <th>ลำดับ</th>
  <th>ภาพห้องประชุม</th>
  <th style="width:30%">ชื่อห้องประชุม</th>
  <th style="width:40%">รายละเอียด</th>
  <th>เลือก</th>
  </tr>
<tr>
  <td>1</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคารกรมพัฒนาสังคมและสวัสดิการ ห้องประชุมชั้น 8 </td>
  <td>จำนวนคนที่รับรองได้ : 20 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง, ไมค์ 20 ตัว<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
  </tr>
<tr class="odd">
  <td>2</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 7 </td>
  <td>จำนวนคนที่รับรองได้ : 15 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
  </tr>
<tr>
  <td>3</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td class="odd">อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 14 </td>
  <td>จำนวนคนที่รับรองได้ : 8 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : จอโทรทัศน์ 1 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
  </tr>
<tr class="odd">
  <td>4</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องอบรมคอมพิวเตอร์ ชั้น 7 </td>
  <td>จำนวนคนที่รับรองได้ : 25 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง, ไมค์ 2 ตัว, เครื่องคอมพิวเตอร์ 25 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
  </tr>
</table>
</div>
</div>



@endsection
