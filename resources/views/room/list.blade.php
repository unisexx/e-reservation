@extends('layout.template')

@section('content')
<h3>ตั้งค่า ห้องประชุม</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
    <input type="text" class="form-control" style="width:350px;" id="exampleInputName2" placeholder="ชื่อห้องประชุม">
      <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</form>

  
</div>
</div>
<div id="btnBox">
  <input type="button" title="เพิ่มห้องประชุม" value="เพิ่มห้องประชุม" onclick="document.location='{{ url('/room/form') }}'" class="btn btn-warning vtip" />
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
  <th>ลำดับ</th>
  <th>ภาพห้องประชุม</th>
  <th style="width:30%">ชื่อห้องประชุม</th>
  <th style="width:40%">รายละเอียด</th>
  <th>จัดการ</th>
  </tr>
<tr>
  <td>1</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคารกรมพัฒนาสังคมและสวัสดิการ ห้องประชุมชั้น 8 </td>
  <td>จำนวนคนที่รับรองได้ : 20 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง, ไมค์ 20 ตัว<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr class="odd">
  <td>2</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 7 </td>
  <td>จำนวนคนที่รับรองได้ : 15 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>3</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td class="odd">อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 14 </td>
  <td>จำนวนคนที่รับรองได้ : 8 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : จอโทรทัศน์ 1 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr class="odd">
  <td>4</td>
  <td><img src="{{ url('images/photo_room.png') }}" /></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องอบรมคอมพิวเตอร์ ชั้น 7 </td>
  <td>จำนวนคนที่รับรองได้ : 25 คน<br />
    อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง, ไมค์ 2 ตัว, เครื่องคอมพิวเตอร์ 25 เครื่อง<br />
    ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br />
    ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี</td>
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