<table class="table table-bordered">
    <tr>
        <td>
            @if($rs->image)
                @php 
                    $images = (explode("|",$rs->image));
                @endphp
                @foreach($images as $image)
                    <img src="{{ url('uploads/room/'.$image) }}" width="90"> 
                @endforeach
            @endif
        </td>
        <td>
            <div>จำนวนคนที่รองรับได้ : {{ !empty($rs->people) ? $rs->people : "-" }} คน</div>
            <div>อุปกรณ์ที่ติดตั้งในห้อง : {{ !empty($rs->equipment) ? $rs->equipment : "-" }}</div>
            <div>
                ผู้รับผิดชอบห้องประชุม : {{ !empty($rs->res_name) ? $rs->res_name : "-" }}
                {{ !empty($rs->st_department_code) ? $rs->department->title : "-" }}
                {{ !empty($rs->st_bureau_code) ? $rs->bureau->title : "-" }}
                {{ !empty($rs->st_division_code) ? $rs->division->title : "-" }}
                {{ !empty($rs->res_tel) ? 'โทรศัพท์: '.$rs->res_tel : "-" }}
            </div>
            <div>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม : {{ !empty($rs->fee) ? $rs->fee : "-" }}</div>
            <div>หมายเหตุ : {{ !empty($rs->note) ? $rs->note : "-" }}</div>
        </td>
    </tr>
</table>