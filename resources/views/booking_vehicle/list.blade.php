@extends('layout.template')

@section('content')
<h3>จองยานพาหนะ</h3>
<div id="search">
<div id="searchBox">
<div class="form-inline"><input type="text" class="form-control" style="width:370px;" id="exampleInputName2" placeholder="รหัสการจอง / ทะเบียนรถ / ชื่อคนขับ">

    <select class="form-control">
      <option>วันที่ขอใช้</option>
      <option>วันที่ไป</option>
      <option>วันที่กลับ</option>
    </select>
    <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;" />
  <img src="images/calendar.png" width="24" height="24" />
<button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
</div>
</div>
</div>

<div id="btnBox"> <a href="{{ url('/booking_vehicle/calendar') }}"><img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" /></a>
  <input type="button" title="export excel" value="export excel" class="btn vtip" />
  <input type="button" title="จองยานพาหนะ" value="จองยานพาหนะ" onclick="document.location='{{ url('/booking_vehicle/form') }}'" class="btn btn-success vtip" />
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
  <th style="width:25%">ไปเพื่อ / รายละเอียดรถ / ชื่อผู้ขับ</th>
  <th style="width:15%">วันที่</th>
  <th style="width:15%">จุดขึ้นรถ / สถานที่ไป</th>
  <th style="width:10%">ผู้ขอใช้ยานพาหนะ</th>
  <th style="width:5%">สถานะ</th>
  <th style="width:10%">จัดการ</th>
</tr>
</thead>
<tbody>
<tr>
  <td>1</td>
  <td nowrap="nowrap">BR61058</td>
  <td>
  <div class="topicMeeting">ไปประชุมคณะอนุกรรมการขับเคลื่อนการแก้ปัญหาการรุกลำน้ำสาธารณะ</div>
  </td>
  <td>
  <div class="boxStartEnd"><span class="request">ขอใช้</span> 17/10/2561 10:00 น.</div>
  <div class="boxStartEnd"><span class="start">ไป</span> 24/10/2561 09:00 น.</div>
    <div class="boxStartEnd"><span class="end">กลับ</span> 24/10/2561 12:00 น.</div></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 08:30 น. <br /><br />
กระทรวงการพัฒนาสังคมฯ </td>
  <td>นางสาวจินตนา  เอกอมร <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>รออนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>2</td>
  <td nowrap="nowrap">BR61057</td>
  <td>
  <div class="topicMeeting">ประชุมคณะกรรมการนโยบายยุทธศาสตร์การพัฒนา</div>
  <div>รถตู้ โตโยต้า 12 ที่นั่ง สีขาว ทะเบียน ฮว 211 กทม.</div>
    นายดารพ    ป้องนวน	088-9866011 </td>
  <td>
  <div class="boxStartEnd"><span class="request">ขอใช้</span> 16/10/2561 14:11 น.</div>
  <div class="boxStartEnd"><span class="start">ไป</span> 19/10/2561 13:00 น.</div>
    <div class="boxStartEnd"><span class="end">กลับ</span> 19/10/2561 16:00 น.</div></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท)  เวลา 12:30 น. <br />
    <br />
    บ้านราชวิถี </td>
  <td>นางราตรี พันธ์มณี <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>อนุมัติ</td>
  <td><img src="{{ url('images/print3.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="พิมพ์เอกสารการจอง" /><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>3</td>
  <td>BR61056</td>
  <td>
  <div class="topicMeeting">รับเอกสารสำคัญ</div>
  <div>รถตู้ นิสสัน 10 ที่นั่ง สีเทา ทะเบียน ฮพ 6699 กทม.</div>
    นายเกรียงศักดิ์    สำรวม	081-7800441 </td>
  <td>
  <div class="boxStartEnd"><span class="request">ขอใช้</span> 16/10/2561 15:35 น.</div>
  <div class="boxStartEnd"><span class="start">ไป</span> 22/10/2561 09:00 น.</div>
    <div class="boxStartEnd"><span class="end">กลับ</span> 22/10/2561 16:00 น.</div></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 08:30 น. <br />
    <br />
    โรงแรมปริ้นพาเลซ </td>
  <td>นายจำเริญ นิจจรัลกุล <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง&lt;br&gt;
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>อนุมัติ</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/print3.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="พิมพ์เอกสารการจอง" /><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>4</td>
  <td>BR61055</td>
  <td>
    <div class="topicMeeting">อบรมการดำเนินงานตัวชี้วัดและผลผลิตเชิงปฏิบัติการ</div>
   </td>
  <td>
  <div class="boxStartEnd"><span class="request">ขอใช้</span> 15/10/2561 11:18 น.</div>
  <div class="boxStartEnd"><span class="start">ไป</span> 18/10/2561 09:30 น.</div>
    <div class="boxStartEnd"><span class="end">กลับ</span> 18/10/2561 15:00 น.</div></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 09:00 น. <br />
    <br />
    กระทรวงการพัฒนาสังคมฯ </td>
  <td>นางราตรี พันธ์มณี <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง&lt;br&gt;
081-1586585  jintana.e@m-society.go.th"/></td>
  <td>ยกเลิก</td>
  <td><a href="<?=basename($_SERVER['PHP_SELF'])?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้"  /></td>
  </tr>
<tr>
  <td>5</td>
  <td>BR61054</td>
  <td>
    <div class="topicMeeting">สัมนางานอำนวยการ</div>
</td>
  <td>
  <div class="boxStartEnd"><span class="request">ขอใช้</span> 15/10/2561 14:11 น.</div>
  <div class="boxStartEnd"><span class="start">ไป</span> 23/10/2561 08:30 น.</div>
    <div class="boxStartEnd"><span class="end">กลับ</span> 26/10/2561 12:00 น.</div></td>
  <td>อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 08:00 น. <br />
    <br />
    สนง.พมจ.จังหวัดประจวบคีรีขันธ์ <br />
    <br /></td>
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