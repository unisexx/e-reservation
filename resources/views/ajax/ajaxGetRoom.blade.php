@foreach($rs as $key=>$item)
<tr @if(($key % 2)==1) class="odd" @endif>
    <td>{{ $key+1 }}</td>
    <td>
        @if($item->image)
            @php 
                $images = (explode("|",$item->image));
            @endphp
            @foreach($images as $image)
                <img src="{{ url('uploads/room/'.$image) }}" width="90"> 
            @endforeach
        @endif
    </td>
    <td>{{ $item->name }}</td>
    <td>
        <div>จำนวนคนที่รับรองได้ : {{ !empty($item->people) ? $item->people : "-" }} คน</div>
        <div>อุปกรณ์ที่ติดตั้งในห้อง : {{ !empty($item->equipment) ? $item->equipment : "-" }}</div>
        <div>
            ผู้รับผิดชอบห้องประชุม : {{ !empty($item->res_name) ? $item->res_name : "-" }}
            {{ !empty($item->st_department_code) ? $item->department->title : "-" }}
            {{ !empty($item->st_bureau_code) ? $item->bureau->title : "-" }}
            {{ !empty($item->st_division_code) ? $item->division->title : "-" }}
        </div>
        <div>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : {{ !empty($item->fee) ? $item->fee : "-" }}</div>
    </td>
    <td>
        <input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip selectRoomBtn" data-room-id="{{ $item->id }}" data-room-name="{{ $item->name}} ">
    </td>
</tr>
@endforeach