@foreach($rs as $key=>$row)
<tr @if(($key % 2)==1) class="odd" @endif>
    <td>{{ $key+1 }}</td>
    <td nowrap="nowrap">{{ $row->code }}</td>
    <td nowrap="nowrap">{{ $row->stBoss->name }}</td>
    <td>
        <div class="topicMeeting">{{ $row->title }}</div>
    </td>
    <td>
        <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
        <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
    </td>
    <td>{{ $row->request_name }}
        <div>{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
        {{ $row->request_tel }} {{ $row->request_email }}</div>
    </td>
    <td><span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span></td>
</tr>
@endforeach