@extends('layout.template')

@section('content')
<h3>ผู้ใช้งาน</h3>
<div id="search">
<div id="searchBox">
<form class="form-inline">
    <input type="text" class="form-control" style="width:350px;" id="exampleInputName2" placeholder="ชื่อ - สกุล">
      <button type="submit" class="btn btn-info"><img src="images/search.png" width="16" height="16" />ค้นหา</button>
</form>

  
</div>
</div>
<div id="btnBox">
  <input type="button" title="เพิ่มผู้ใช้งาน" value="เพิ่มผู้ใช้งาน" onclick="document.location='{{ url('/user/form') }}'" class="btn btn-warning vtip" />
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
  <th align="left">ลำดับ</th>
  <th align="left">ชื่อ-สกุลผู้ใช้งาน</th>
  <th align="left">หน่วยงาน</th>
  <th align="left">สิทธิ์การใช้งาน</th>
  <th align="left">อีเมล์</th>
  <th align="left">วันที่ลงทะเบียน</th>
  <th align="left">เปิดใช้งาน</th>
  <th align="left">จัดการ</th>
  </tr>
<tr>
  <td>1</td>
  <td>เฟเวอร์ริทดีไซน์</td>
  <td>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</td>
  <td>SuperAdmin</td>
  <td>fd@favouritedesign.com</td>
  <td>05/10/2561</td>
  <td><img src="images/icon_checkbox.png" width="24" height="24" /></td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="images/edit.png" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="images/remove.png" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr class="odd">
  <td>2</td>
  <td>ปิติพร ปิติเสรี</td>
  <td>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</td>
  <td>Admin</td>
  <td class="odd cursor">pitiporn.p@m-society.go.th</td>
  <td class="odd cursor">08/10/2561</td>
  <td class="odd cursor"><img src="images/icon_checkbox.png" width="24" height="24" /></td>
  <td><img src="images/edit.png" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /><img src="images/remove.png" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>3</td>
  <td class="odd">จำเริญ นิจจรัลกุล</td>
  <td class="odd">ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</td>
  <td class="odd">Admin</td>
  <td class="odd cursor">chamroen.n@m-society.go.th</td>
  <td class="odd cursor">08/10/2561</td>
  <td><img src="images/icon_checkbox.png" width="24" height="24" /></td>
  <td class="odd cursor"><img src="images/edit.png" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /><img src="images/remove.png" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr class="odd">
  <td>4</td>
  <td align="left">ศิวพร แสงชัยบุญลักษณ์</td>
  <td class="odd cursor">ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</td>
  <td class="odd cursor">User</td>
  <td class="odd cursor">siwaporn.s@m-society.go.th</td>
  <td class="odd cursor">08/10/2561</td>
  <td class="odd cursor"><img src="images/icon_checkbox.png" width="24" height="24" /></td>
  <td><img src="images/edit.png" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /><img src="images/remove.png" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>5</td>
  <td align="left" class="odd">ศิรินทิพย์ ทิพย์จันทร์</td>
  <td><span class="odd cursor">ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</span></td>
  <td><span class="odd cursor">User</span></td>
  <td>sirinthip.t@m-society.go.th</td>
  <td><span class="odd cursor">08/10/2561</span></td>
  <td><span class="odd cursor"><img src="images/icon_checkbox.png" width="24" height="24" /></span></td>
  <td><img src="images/edit.png" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /><img src="images/remove.png" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
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