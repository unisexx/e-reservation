@extends('layout.template')

@section('content')
<h3>จองยานพาหนะ (เพิ่ม / แก้ไข)</h3>
        <div class="form-group form-inline col-md-12">
  <label>ไปเพื่อ<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control " id="exampleInputEmail2" style="width:600px;" value="" />
        </div>
        
        <div class="form-group form-inline col-md-6">
        <label>จำนวนผู้โดยสาร <span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control numOnly" id="exampleInputEmail2" style="width:100px;" > คน
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>วันที่ไป<span class="Txt_red_12"> *</span> / วันที่กลับ<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control fdate" id="exampleInputEmail" value="" style="width:120px;" />
  <img src="{{ url('images/calendar.png') }}" width="24" height="24" /> 
  <input type="text" class="form-control ftime" id="exampleInputEmail3" placeholder="เวลา" value="" style="width:70px;" /> 
  น.
  /
  <input type="text" class="form-control fdate" id="exampleInputEmail4" value="" style="width:120px;" />
  <img src="{{ url('images/calendar.png') }}" width="24" height="24" />
  <input type="text" class="form-control ftime" id="exampleInputEmail5" placeholder="เวลา" value="" style="width:70px;" />
น 
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>จุดขึ้นรถ<span class="Txt_red_12"> *</span></label>
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="สถานที่ขึ้นรถ" value="" style="width:400px;">
  <input type="text" class="form-control ftime" id="exampleInputEmail5" placeholder="เวลา" value="" style="width:70px;" /> น.
        </div>
        
        <div class="form-group form-inline col-md-12">
  <label>ข้อมูลการติดต่อผู้ขอใช้ <span class="Txt_red_12"> *</span></label>
  <div style="margin-bottom:5px;">
  <input type="text" class="form-control " id="exampleInputEmail2" placeholder="ชื่อผู้ขอใช้ยานพาหนะ" value="" style="min-width:300px;">

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
  </select>
  
  <input type="text" class="form-control" id="exampleInputEmail2" style="min-width:400px;" readonly="readonly">
        <a class='inline' href="#inline_vehicle"><input type="button" title="เลือกยานพาหนะ" value="เลือกยานพาหนะ" class="btn btn-info vtip" /></a>
        <span class="note">* กรณีเลือกอนุมัติให้ admin เลือกยานพาหนะ</span>
  </div>
        
        <div class="form-group form-inline col-md-12">
        <div id="btnBoxAdd">
        <input name="input" type="button" title="บันทึก" value="บันทึกข้อมูล" class="btn btn-primary"/>
        <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"  onclick="history.back(-1)"  class="btn btn-default"/>
  		
		</div>
		</div>




<!-- This contains the hidden content for inline calls ห้องประชุม-->
<div style='display:none'>
<div id='inline_vehicle' style='padding:5px; background:#fff;'>
<h3 style="margin:0; padding:0; color:#636">เลือกยานพาหนะ</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
<input type="text" class="form-control" style="width:400px;" id="exampleInputName2" placeholder="ชื่อพนักงานขับรถ / รายละเอียดรถ" />
<button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</form>
</div>
</div>

<table class="tblist">
  <tr>
    <th style="width:10%">ลำดับ</th>
    <th style="width:10%">ภาพยานพาหนะ</th>
    <th style="width:30%">ประเภท / ยี่ห้อ  / ที่นั่ง / สี	/ 	เลขทะเบียน</th>
    <th style="width:20%">พนักงานขับวันนี้</th>
    <th style="width:10%">สถานะ</th>
    <th>เลือก</th>
    </tr>
  <tr>
    <td>1</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 10 ที่นั่ง สีบรอนซ์เงิน ทะเบียน ฮก 93 กทม.</td>
    <td>นายวิทยา    แก่นดี  081-9814314 </td>
    <td>พร้อมใช้</td>
    <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
    </tr>
  <tr class="odd">
    <td>2</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 12 ที่นั่ง สีขาว ทะเบียน ฮว 211 กทม.</td>
    <td>นายดารพ    ป้องนวน	088-9866011 </td>
    <td>พร้อมใช้</td>
    <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
    </tr>
  <tr>
    <td>3</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td class="odd">รถตู้ นิสสัน 10 ที่นั่ง สีเทา ทะเบียน ฮพ 6699 กทม.</td>
    <td>นายเกรียงศักดิ์    สำรวม	081-7800441 </td>
    <td>พร้อมใช้</td>
    <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
    </tr>
  <tr class="odd">
    <td>4</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถกระบะ โตโยต้า 2 ที่นั่ง สีขาว ทะเบียน ฮว 211 กทม.</td>
    <td>นายอุดร    ยาดี	081-8698619</td>
    <td>ซ่อมบำรุง</td>
    <td>&nbsp;</td>
    </tr>
  <tr class="odd">
    <td>5</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 10 ที่นั่ง สีเทา  ทะเบียน ฮบ 818 กทม.</td>
    <td>นายทวีวัฒน์    ชุมธาตุ	086-1128960</td>
    <td>พร้อมใช้</td>
    <td><input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip" /></td>
  </tr>
</table>
</div>
</div>



@endsection
