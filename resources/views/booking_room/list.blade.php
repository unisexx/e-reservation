@extends('layout.template')

@section('content')
<h3>จองห้องประชุม</h3>
<div id="search">
<div id="searchBox">
<div class="form-inline"><input type="text" class="form-control" style="width:370px;" id="exampleInputName2" placeholder="รหัสการจอง / หัวข้อการประชุม / ผู้ขอใช้ห้องประชุม">
  <select name="select" class="form-control">
    <option>วันที่เริ่ม</option>
    <option>วันที่สิ้นสุด</option>
  </select>
  <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;" />
  <img src="images/calendar.png" width="24" height="24" />
<button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</div>
</div>
</div>

<div id="btnBox"> <a href="{{ url('/booking_room/calendar') }}"><img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" /></a>
  <input type="button" title="export excel" value="export excel" class="btn vtip" />
  <input type="button" title="จองห้องประชุม" value="จองห้องประชุม" onclick="document.location='{{ url('/booking_room/form') }}'" class="btn btn-success vtip" />
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

<table class="table table-bordered table-striped sortable tblist">
<thead>
<tr>
  <th style="width:5%">ลำดับ</th>
  <th style="width:10%">รหัสการจอง</th>
  <th style="width:30%">หัวข้อการประชุม / ห้องประชุม</th>
  <th style="width:15%">วัน เวลา ที่ต้องการใช้ห้อง</th>
  <th style="width:15%">ผู้ขอใช้ห้องประชุม</th>
  <th style="width:5%">สถานะ</th>
  <th style="width:5%">จัดการ</th>
</tr>
</thead>
<tbody>
<tr>
  <td>1</td>
  <td nowrap="nowrap">BR61058</td>
  <td><div class="topicMeeting">ผลการดำเนินงานรอบสัปดาห์เพื่อใช้ในรายการคืนความสุขให้คนในชาติ</div>
    อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 7 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  <u>จำนวนคนที่รับรองได้</u> 15 คน<br>
	<u>อุปกรณ์ที่ติดตั้งในห้อง</u> Projector 1 เครื่อง<br>
	<u>ผู้รับผิดชอบห้องประชุม</u> นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br>
	<u>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม</u> ไม่มี"/></td>
  <td><div class="boxStartEnd"><span class="start">เริ่ม</span> 02/11/2561 08:30 น.</div>
    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 02/11/2561 12:00 น.</div></td>
  <td>นางสาวจินตนา  เอกอมร <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>รออนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>2</td>
  <td nowrap="nowrap">BR61057</td>
  <td><div class="topicMeeting">ถ่ายทอดตัวชี้วัด</div>
    อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 14 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  จำนวนคนที่รับรองได้ : 15 คน&lt;br&gt;
	อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง&lt;br&gt;
	ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.&lt;br&gt;
	ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี"/></td>
  <td><div class="boxStartEnd"><span class="start">เริ่ม</span> 23/10/2561 10:00 น.</div>
    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 24/10/2561 16:00 น.</div></td>
  <td>นางราตรี พันธ์มณี <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>อนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>3</td>
  <td>BR61056</td>
  <td><div class="topicMeeting">อบรมการใช้งานระบบครุภัณฑ์คอมฯ</div>
    อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องอบรมคอมพิวเตอร์ ชั้น 7 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  จำนวนคนที่รับรองได้ : 15 คน&lt;br&gt;
	อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง&lt;br&gt;
	ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.&lt;br&gt;
	ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี"/></td>
  <td><div class="boxStartEnd"><span class="start">เริ่ม</span> 22/10/2561 09:00 น.</div>
    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 26/10/2561 16:00 น.</div></td>
  <td>นายจำเริญ นิจจรัลกุล <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง&lt;br&gt;
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>อนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>4</td>
  <td>BR61055</td>
  <td><div class="topicMeeting">ประชุมซักซ้อมแนวทางปฎิบัติงาน</div>
    อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 7 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  จำนวนคนที่รับรองได้ : 15 คน&lt;br&gt;
	อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง&lt;br&gt;
	ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.&lt;br&gt;
	ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี"/></td>
  <td><div class="boxStartEnd"><span class="start">เริ่ม</span> 25/10/2561 09:30 น.</div>
    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 25/10/2561 15:00 น.</div></td>
  <td>นางราตรี พันธ์มณี <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง&lt;br&gt;
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>ยกเลิก</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>5</td>
  <td>BR61054</td>
  <td><div class="topicMeeting">ประชุมคณะมนตรีประชาคมสังคมและวัฒนธรรมอาเซียน</div>
    อาคารกรมพัฒนาสังคมและสวัสดิการ ห้องประชุมชั้น 8 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  จำนวนคนที่รับรองได้ : 15 คน&lt;br&gt;
	อุปกรณ์ที่ติดตั้งในห้อง : Projector 1 เครื่อง&lt;br&gt;
	ผู้รับผิดชอบห้องประชุม : นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.&lt;br&gt;
	ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : ไม่มี"/></td>
  <td><div class="boxStartEnd"><span class="start">เริ่ม</span> 19/10/2561 08:30 น.</div>
    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 19/11/2561 16:00 น.</div></td>
  <td>สุรชัย เดชกำแหง  <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง&lt;br&gt;
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>ไม่อนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
  </tbody>
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