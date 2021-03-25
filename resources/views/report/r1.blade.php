@extends('layout.template')

@section('content')
<h3>รายงานข้อมูลสินทรัพย์</h3>
<div id="search">
<div id="searchBox">
<div class="form-inline"><input type="text" class="form-control" style="width:370px;" id="exampleInputName2" placeholder="รหัส GF / รหัสครุภัณฑ์ / ชื่อทรัพย์ / รุ่นแบบ">
  <button type="submit" class="btn btn-info"><img src="images/search.png" width="16" height="16" />ค้นหา</button>
  <button class="btn btn-default" data-toggle="collapse" data-target="#boxAdvanceSearch"><img src="images/advancesearch.png" width="22" height="22" /> ค้นหาขั้นสูง</button>

  
  <div id="boxAdvanceSearch" class="collapse" style="margin-top:5px;"><!--<div class="collapse" id="boxAdvanceSearch">-->
  <fieldset style="border:1px solid #E5E5E5; padding:10px; margin-bottom:10px;">
  <legend style="margin:0; padding:0; font-size:14px;">หมวด / กลุ่ม / ประเภท / ชนิด ครุภัณฑ์</legend>
        <select id="lunch" class="selectpicker" data-live-search="true" title="เลือกหมวดครุภัณฑ์">
          <option>+ ทุกหมวดครุภัณฑ์ +</option>
          <option>[12050300] อาคารเพื่อประโยชน์อื่น</option>
          <option>[12050400] สิ่งปลูกสร้าง</option>
          <option>[12050401] สิ่งปลูกสร้างราชพัสดุ</option>
          <option>[12060100] ครุภัณฑ์สำนักงาน</option>
          <option>[12060200] คุรภัณฑ์ยานพาหนะ</option>
          <option>[12060300] คุรภัณฑ์ไฟฟ้า</option>
          <option>[12060400] ครุภัณฑ์โฆษณา</option>
          <option>[12060500] คุรภัณฑ์การเกษตร</option>
          <option>[12060600] คุรภัณฑ์โรงงาน</option>
          <option>[12060700] คุรภัณฑ์ก่อสร้าง</option>
          <option>[12060800] คุรภัณฑ์สำรวจ</option>
          <option>[12060900] คุรภัณฑ์วิทยาศาสตร์</option>
          <option>[12061000] คุรภัณฑ์คอมพิวเตอร์</option>
          <option>[12061100] คุรภัณฑ์การศึกษา</option>
          <option>[12061200] คุรภัณฑ์งานบ้าน</option>
        </select>

        <select id="lunch" class="selectpicker" data-live-search="true" title="ทุกกลุ่มครุภัณฑ์">
          <option>+ ทุกกลุ่มครุภัณฑ์ +</option>
          <option></option>
        </select>

        <select id="lunch" class="selectpicker" data-live-search="true" title="ทุกประเภทครุภัณฑ์">
          <option>+ ทุกประเภทครุภัณฑ์ +</option>
          <option></option>
        </select>
        
        <select id="lunch" class="selectpicker" data-live-search="true" title="ทุกชนิดครุภัณฑ์">
          <option>+ ทุกชนิดครุภัณฑ์ +</option>
          <option></option>
        </select>

    </fieldset>

<fieldset style="border:1px solid #E5E5E5; padding:10px; margin-bottom:10px;">
  <legend style="margin:0; padding:0; font-size:14px;">ศูนย์ต้นทุน / หน่วยงาน</legend>
<div style="margin-bottom:5px;"><input type="text" class="form-control" style="width:450px;" id="tags" placeholder="ศูนย์ต้นทุน [auto complete]"></div>
<input type="text" class="form-control" style="width:450px;" id="tags2" placeholder="หน่วยงาน [auto complete]">
</fieldset>
  
<fieldset style="border:1px solid #E5E5E5; padding:10px; margin-bottom:10px;">
  <legend style="margin:0; padding:0; font-size:14px;">เกณฑ์ทรัพย์สิน / ราคา</legend>
  <select name="select" class="form-control ">
    <option>แสดงรายการสินทรัพย์ทั้งหมด</option>
    <option>แสดงรายการสินทรัพย์ในเกณฑ์</option>
    <option>แสดงรายการสินทรัพย์ต่ำกว่าเกณฑ์</option>
  </select>
    <select class="form-control">
   <option>+ เงื่อนไขราคา +</option>
   <option value="1">เท่ากับ</option>
   <option value="2">มากกว่าหรือเท่ากับ</option>
   <option value="3">น้อยกว่าหรือเท่ากับ</option>
   <option value="4">มากกว่า</option>
   <option value="5">น้อยกว่า</option>
   <option value="6">ระหว่าง</option>
  </select>
  <input type="text" class="form-control numDecimal" style="width:150px;" id="exampleInputName2" placeholder="จำนวนราคา">  
  <span class="boxBetween"> - <input type="text" class="form-control numDecimal" style="width:150px;" id="exampleInputName2" placeholder="จำนวนราคา"></span>
</fieldset>

<fieldset style="border:1px solid #E5E5E5; padding:10px; margin-bottom:10px;">
  <legend style="margin:0; padding:0; font-size:14px;">การตัดจำหน่าย</legend>
  <select name="select" class="form-control ">
    <option>แสดงรายการทั้งหมด</option>
    <option>แสดงรายการที่ตัดจำหน่ายแล้ว</option>
    <option>แสดงรายการที่ยังไม่ได้ตัดจำหน่าย</option>
  </select>
</fieldset>

<fieldset style="border:1px solid #E5E5E5; padding:10px;">
  <legend style="margin:0; padding:0; font-size:14px;">วันที่</legend>
  
    วันที่ลงบัญชี
    <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;"> 
    <img src="images/calendar.png" width="24" height="24" /> - 
    <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;"> 
    <img src="images/calendar.png" width="24" height="24" style="margin-right:30px;" />
    
    วันที่ได้รับสินทรัพย์ (Cap.date)
    <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;"> 
    <img src="images/calendar.png" width="24" height="24" /> -
    <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;"> 
    <img src="images/calendar.png" width="24" height="24" />
</fieldset>
  
  </div>
  
  
 
  
</div>



  
</div>
</div>

<div style="text-align:right; padding:10px;">
<div style="display:inline-block; width:auto; border: 1px dotted #999; padding:5px 10px;">
พิมพ์/ส่งออกข้อมูลทรัพย์สิน (ทั้งหมด)
<img src="images/print3.png" width="32" height="32" style="margin-right:10px;" />
<img src="images/excel.png" width="32" height="32" />
</div>

<div style="display:inline-block; width:auto; border: 1px dotted #999; padding:5px 10px;">
พิมพ์/ส่งออกทะเบียนคุมทรัพย์สิน (ทั้งหมด)
<img src="images/print-32.png" width="32" height="32" style="margin-right:10px;" />
<img src="images/excel2.png" width="32" height="32" />
</div>
</div>

<div class="paginationTG">
	<ul>
    <li style="margin-right:10px;">หน้าที่</li>
	<li class="currentpage">1</li><li ><a href=''>2</a></li>
	<li><a href="">3</a></li>
	<li><a href="">4</a></li>
	<li><a href="">5</a></li>
	<li><a href="">6</a></li>
	<li><a href="">7</a></li> . . . <li ><a href="">19</a></li>
	<li><a href="">20</a></li><li ><a href="">21</a></li>
    <li style="margin-left:30px;">ค้นหาเจอ 25,536 รายการ</li>
	</ul>
</div>


<table class="tblistReport">
<tr>
  <th align="left">ลำดับ</th>
  <th align="left">วันที่ลงบัญชี</th>
  <th align="left">วันที่ได้รับทรัพย์สิน</th>
  <th align="left">รหัสสินทรัพย์ (GFMIS)</th>
  <th align="left">รหัสครุภัณฑ์</th>
  <th align="left">ชื่อทรัพย์สิน</th>
  <th align="left">รุ่น/แบบ</th>
  <th align="left">ราคา</th>
  <th align="left">วิธีการได้มา</th>
  <th align="left">ปีงบประมาณ</th>
  <th align="left">เลขที่เอกสาร</th>
  <th align="left">หลักฐานการจ่าย</th>
  <th align="left">หมายเหตุ</th>
  <th align="left">พิมพ์/ส่งออก</th>
  </tr>
<tr>
  <td>1</td>
  <td>17/10/2560</td>
  <td>17/10/2560</td>
  <td>100000023416</td>
  <td>พม/สสว6/04-06-01/001/2561</td>
  <td>เครื่องถ่ายเอกสารดิจิตอล</td>
  <td>ยี่ห้อ kyocera รุ่น FA-5501i LJf6801400</td>
  <td>180,000.00</td>
  <td>ตกลงราคา</td>
  <td>2561</td>
  <td>K10016927</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><img src="images/print2.png" width="16" height="14" class="vtip" title="พิมพ์ทะเบียนคุมสินทรัพย์รายการนี้" /> / <img src="images/excel_mini.png" width="16" height="16" class="vtip" title="ส่งออกข้อมูลทะเบียนคุมสินทรัพย์รายการนี้"  /></td>
  </tr>
<tr class="odd">
  <td>2</td>
  <td>21/11/2559</td>
  <td>21/11/2559</td>
  <td>100000022054</td>
  <td>พม/พมจ-ปท/04-01-01/003/2560</td>
  <td>ตู้เหล็กเก็บเอกสารชนิด 2 บาน เปิด ขนาด 91*45*183 ซ.ม. ยี่ห้อ STAR </td>
  <td>&nbsp;</td>
  <td>5,500.00</td>
  <td>ตกลงราคา</td>
  <td>2560</td>
  <td>0069/10/59</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr class="cut">
  <td>3</td>
  <td>15/01/2559</td>
  <td>15/01/2559</td>
  <td>100000020691</td>
  <td>พม/พมจ-นภ/04-01-01/001/2559</td>
  <td>ตู้เหล็กเก็บเอกสาร 2 บานเปิด ยี่ห้อ SURE	</td>
  <td>ยี่ห้อ SURE</td>
  <td>5,050.00</td>
  <td>ตกลงราคา</td>
  <td>2559</td>
  <td>เล่มที่ 44 เลขที่ 20</td>
  <td>&nbsp;</td>
  <td>ตัดจำหน่าย วันที่ 15/01/2559</td>
  <td>&nbsp;</td>
  </tr>
<tr class="odd">
  <td>4</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  </tr>
<tr>
  <td>5</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  <td align="left" class="odd">&nbsp;</td>
  </tr>
</table>


<div class="paginationTG">
	<ul>
    <li style="margin-right:10px;">หน้าที่</li>
	<li class="currentpage">1</li><li ><a href=''>2</a></li>
	<li><a href="">3</a></li>
	<li><a href="">4</a></li>
	<li><a href="">5</a></li>
	<li><a href="">6</a></li>
	<li><a href="">7</a></li> . . . <li ><a href="">19</a></li>
	<li><a href="">20</a></li><li ><a href="">21</a></li>
  </ul>
</div>
@endsection