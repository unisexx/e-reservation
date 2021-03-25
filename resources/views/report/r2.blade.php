@extends('layout.template')

@section('content')
<h3>รายงานข้อมูลเด็กกำพร้าจากสถานการณ์ความไม่สงบฯ</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
  <select id="lunch" class="selectpicker" data-live-search="true" title="ปีที่เกิดเหตุ">
 	<option>+ ทุกปีที่เกิดเหตุ +</option>
 	<option>2560</option>
    <option>2559</option>
 </select>

  <select id="lunch" class="selectpicker" data-live-search="true" title="จังหวัด">
 	<option>+ ทุกจังหวัด +</option>
 	<option>สงขลา</option>
 </select>
<button type="submit" class="btn btn-info"><img src="images/search.png" width="16" height="16" />ค้นหา</button>
</form>

  
</div>
</div>

<div style="text-align:right; padding:10px;"><img src="images/word.png" width="32" height="32" style="margin-right:10px;" /><img src="images/pdf.png" width="32" height="32" /></div>


<table class="tblist">
<tr>
  <th align="left">ลำดับ</th>
  <th align="left">ชื่อ-สกุลเด็ก<br />
    เลขบัตรประชาชน</th>
  <th align="left">ว.ด.ป เกิด</th>
  <th align="left">กำพร้า</th>
  <th align="left">ที่อยู่</th>
  <th align="left">สถานะการศึกษา</th>
  <th align="left">ระดับการศึกษา</th>
  <th align="left">ชั้นปีที่</th>
  <th align="left">สถาบันการศึกษา</th>
  <th align="left">ชื่อ-สกุล ผู้ประสบเหตุ</th>
  <th align="left">เบอร์โทรศัพท์</th>
  <th align="left">ว.ด.ป <br />
    ที่เกิดเหตุ</th>
  <th align="left">สถานที่เกิดเหตุ</th>
  </tr>
<tr>
  <td>1</td>
  <td>นาย	นัสรี	มะเส็น<br />
    1 9006 01148 78 9</td>
  <td>02/07/2542</td>
  <td>พ่อ</td>
  <td>เลขที่ 64/1	หมู่ 7	ซอย -	ถนน -<br />    
    ตำบลเปียน่	อำเภอสะบ้าย้อย่	จังหวัดสงขลา</td>
  <td>กำลังศึกษา</td>
  <td>มัธยมศึกษาตอนปลาย</td>
  <td><span class="odd">ม.4</span></td>
  <td>โรงเรียนประทีปศาสตร์อิสลามวิทยามูลนิธิ</td>
  <td>นาย	หวันหนิ	มะเส็น<br />
    4 9403 00001 98 8 <br /></td>
  <td>086-2904508</td>
  <td>03/04/2547</td>
  <td>สะบ้าย้อย</td>
  </tr>
<tr class="odd">
  <td>2</td>
  <td>น.ส.	ธัญกุล  	อุทปา<br />
    1 4408 00279 09 8<br /></td>
  <td>19/12/2542</td>
  <td>แม่</td>
  <td>เลขที่ 433/2	หมู่ 1	ซอย - ถนน	-	<br />
    ตำบลแม่ริม่	อำเภอแม่ริม่	จังหวัดเชียงใหม่</td>
  <td>กำลังศึกษา</td>
  <td>มัธยมศึกษาตอนต้น</td>
  <td>ม.2</td>
  <td>บ้านริมใต้</td>
  <td>นาง	ธิวาวรรณ	วิญญูสิงขร<br />
    3 5710 00170 64 1 <br /></td>
  <td>-</td>
  <td>16/09/2549</td>
  <td>หาดใหญ่</td>
  </tr>
<tr>
  <td>3</td>
  <td>ด.ช.	อนุชิต	รัตน์น้อย<br />
    1 9402 01241 94 3</td>
  <td>13/07/2550</td>
  <td>พ่อและแม่</td>
  <td>เลขที่ 101	หมู่ 11 ซอย -	ถนน -<br />
    ตำบล
    โคกโพธิ์	อำเภอโคกโพธิ์	จังหวัดปัตตานี</td>
  <td>กำลังศึกษา</td>
  <td>ประถมศึกษาตอนต้น</td>
  <td>ป.3</td>
  <td>อนุบาลปัตตานี</td>
  <td>นายประเสริฐ รัตน์น้อย<br />
    3 9402 00006 71 8<br />
    นางบุญชื่น	รัตน์น้อย<br />
    3 9303 00251 03 0</td>
  <td>&nbsp;</td>
  <td>08/10/2555</td>
  <td>เทพา</td>
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
  </tr>
</table>
@endsection