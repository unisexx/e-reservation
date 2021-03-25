@extends('layout.template')

@section('content')

<div class="printpage">
<div style="margin:0 auto; text-align:center; margin-top:10px"><p style="font-size:25px;">ใบขออนุญาตใช้รถยนต์ส่วนกลาง</p></div>

<p>แบบประเมินการค่าซ่อมแซม/ปรับปรุง <span>aaaaaaaaaaaaaaaaaaaaaaaaaaa</span></p>
<p>ชื่อเจ้าบ้าน/สถานที่จัดกิจกรรม <span>aaaaaaaaaaaaaaaaaaaaaaaaaaa</span></p>
<p>สถานที่ดำเนินงานบ้านเลขที่ <span>123</span> ตำบล<span>123</span>	อำเภอ<span>123</span>	จังหวัด<span>123</span></p>
<p>ผู้ประเมินการชื่อ<span>123</span>		นามสกุล<span>123</span></p>
<p>ตำแหน่ง<span>123</span></p>
<p>วันที่<span>123</span>	เดือน<span>123</span>	พ.ศ.<span>123</span></p>

<table class="tblistReport" style="margin-top:10px;">
<tr>
  <th rowspan="2">ที่</th>
  <th rowspan="2">รายการ</th>
  <th rowspan="2">จำนวน</th>
  <th rowspan="2">หน่วย</th>
  <th colspan="2">ค่าวัสดุ</th>
  <th rowspan="2">หมายเหตุ</th>
</tr>
<tr>
<th>หน่วยละ (บาท)</th>
<th>รวม (บาท)</th>
</tr>
<tr>
<td>ฟ</td>
<td>ฟ</td>
<td>ฟ</td>
<td>ฟ</td>
<td>ฟ</td>
<td>ฟ</td>
<td>ฟฟ</td>
</tr>
</table>

<p>รวมเป็นเงินทั้งสิ้น <span>52,000</span>บาท (<span>ห้าหมื่นสองพันบาทถ้วน</span>)</p>
<p>ระยะเวลาดำเนินงาน <span>30</span>วัน (โดยคำนวณจากปริมาณงาน)</p>
</div><!--printpage-->

@endsection