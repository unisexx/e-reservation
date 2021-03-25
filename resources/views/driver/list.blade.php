@extends('layout.template')

@section('content')
<h3>ตั้งค่า พนักงานขับ</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
    <input type="text" class="form-control" style="width:350px;" id="exampleInputName2" placeholder="ชื่อพนักงานขับ">
    <select name="lunch2" class="selectpicker" id="lunch" title="หน่วยงาน" data-live-search="true">
      <option>-- ทุกหน่วยงาน --</option>
      <option>[06102008001] กองยุทธศาสตร์และแผนงาน ฝ่ายบริหารทั่วไป</option>
      <option>[06102011001] ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร ฝ่ายบริหารทั่วไป</option>
    </select>
<button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</form>

  
</div>
</div>
<div id="btnBox">
  <input type="button" title="เพิ่มพนักงานขับ" value="เพิ่มพนักงานขับ" onclick="document.location='{{ url('/driver/form') }}'" class="btn btn-warning vtip" />
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
    <th>ชื่อพนักงานขับ</th>
    <th>หน่วยงาน</th>
    <th>ข้อมูลติดต่อ</th>
    <th>จัดการ</th>
  </tr>
  <tr>
    <td>1</td>
    <td>นายวิทยา    แก่นดี  </td>
    <td>กองเผยแพร่ประชาสัมพันธ์</td>
    <td>081-9814314 </td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>2</td>
    <td>นายดารพ    ป้องนวน	</td>
    <td>กองยุทธศาสตร์และแผนงาน</td>
    <td>088-9866011 </td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr>
    <td>3</td>
    <td>นายเกรียงศักดิ์    สำรวม	</td>
    <td>กองยุทธศาสตร์และแผนงาน</td>
    <td>081-7800441 </td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>4</td>
    <td>นายอุดร    ยาดี	</td>
    <td>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</td>
    <td>081-8698619</td>
    <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  <tr class="odd">
    <td>5</td>
    <td>นายทวีวัฒน์    ชุมธาตุ	</td>
    <td>กองมาตรฐานการพัฒนาสังคมและความมั่นคงของมนุษย์</td>
    <td>086-1128960</td>
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