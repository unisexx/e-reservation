@extends('layout.template')

@section('content')
<h3>ตั้งค่า ยานพาหนะ</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
    <input type="text" class="form-control" style="width:350px;" id="exampleInputName2" placeholder="ชื่อยานพาหนะ">
      <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</form>

  
</div>
</div>
<div id="btnBox">
  <input type="button" title="เพิ่มยานพหนะ" value="เพิ่มยานพหนะ" onclick="document.location='{{ url('/vehicle/form') }}'" class="btn btn-warning vtip" />
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
	</ul>
</div>
<table class="tblist">
  <tr>
    <th style="width:10%">ลำดับ</th>
    <th style="width:10%">ภาพยานพาหนะ</th>
    <th style="width:30%">ประเภท / ยี่ห้อ  / ที่นั่ง / สี	/ 	เลขทะเบียน</th>
    <th style="width:20%">พนักงานขับวันนี้</th>
    <th style="width:10%">สถานะ</th>
    <th style="width:10%">จัดการ</th>
  </tr>
  <tr>
    <td>1</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 10 ที่นั่ง สีบรอนซ์เงิน ทะเบียน ฮก 93 กทม.</td>
    <td>นายวิทยา    แก่นดี  081-9814314 </td>
    <td>พร้อมใช้</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>2</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 12 ที่นั่ง สีขาว ทะเบียน ฮว 211 กทม.</td>
    <td>นายดารพ    ป้องนวน	088-9866011 </td>
    <td>พร้อมใช้</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr>
    <td>3</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td class="odd">รถตู้ นิสสัน 10 ที่นั่ง สีเทา ทะเบียน ฮพ 6699 กทม.</td>
    <td>นายเกรียงศักดิ์    สำรวม	081-7800441 </td>
    <td>พร้อมใช้</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>4</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถกระบะ โตโยต้า 2 ที่นั่ง สีขาว ทะเบียน ฮว 211 กทม.</td>
    <td>นายอุดร    ยาดี	081-8698619</td>
    <td>ซ่อมบำรุง</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>5</td>
    <td><img src="{{ url('images/photo_room.png') }}" /></td>
    <td>รถตู้ โตโยต้า 10 ที่นั่ง สีเทา  ทะเบียน ฮบ 818 กทม.</td>
    <td>นายทวีวัฒน์    ชุมธาตุ	086-1128960</td>
    <td>พร้อมใช้</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
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