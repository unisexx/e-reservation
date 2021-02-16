@foreach($rs as $key=>$row)
<tr @if(($key % 2)==1) class="odd" @endif>
    <td>{{ $key+1 }}</td>
    <td nowrap="nowrap">{{ $row->code }}</td>
    <td>
        <div class="topicMeeting">{{ $row->gofor }}</div>
        <div>
            @if(!empty($row->st_vehicle_id))
            {{ $row->st_vehicle->st_vehicle_type->name }} {{ $row->st_vehicle->brand }} {{ $row->st_vehicle->seat }} ที่นั่ง {{ $row->st_vehicle->color }} ทะเบียน {{ $row->st_vehicle->reg_number }} <br>ชื่อผู้ขับ {{ @$row->st_vehicle->st_driver->name ?? "-" }}
            @endif
        </div>
    </td>
    <td>
        <div class="boxStartEnd"><span class="request">วันที่ขอใช้</span> {{ DB2Date($row->request_date) }} {{ date("H:i", strtotime($row->request_time)) }} น.</div>
        <div class="boxStartEnd"><span class="start">วันที่ไป</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
        <div class="boxStartEnd"><span class="end">วันที่กลับ</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
    </td>
    <td>{{ $row->point_place }} เวลา {{ date("H:i", strtotime($row->point_time)) }} น.</td>
    <td>{{ $row->destination }}</td>
    <td>
        <div>{{ $row->request_name }}</div>
        <div>
            {{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br> {{ $row->request_tel }} {{ $row->request_email }}
        </div>
    </td>
    <td><span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span></td>
</tr>
@endforeach