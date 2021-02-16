{{-- booking_vehicle_id จากฟอร์มหลัก --}}
@php
    $mbv = App\Model\BookingVehicle::find($_GET['booking_vehicle_id']);
    // dump($booking_vehicle);
@endphp

@foreach($rs as $key=>$row)
<tr @if(($key % 2)==1) class="odd" @endif>
    <td>{{ $key+1 }}</td>
    <td>@if(@$row->image) <img src="{{ url('uploads/vehicle/'.@$row->image) }}" width="90"> @endif</td>
    <td>{{@$row->st_vehicle_type->name}} {{@$row->brand}} {{!empty(@$row->seat)?@$row->seat:'-'}} ที่นั่ง สี{{@$row->color}} ทะเบียน {{@$row->reg_number}}</td>
    {{-- <td>{{@$row->st_driver->name}} {{@$row->st_driver->tel}}</td> --}}
    <td>{{@$row->status}}</td>
    <td>
        {{-- 
            เช็กรายการจองซ้ำ
            หารายการจองรถที่อยู่่ในช่วงเวลาเดียวกันกับ booking_vehicle_id ตั้งต้น 
        --}}
        @php
            $rs = App\Model\BookingVehicle::select('*')->where('st_vehicle_id', $row->id);

            $start_date = @$mbv->start_date;
            $end_date = @$mbv->end_date;
            $start_time = @$mbv->start_time;
            $end_time = @$mbv->end_time;
            $rs = $rs->where(function ($q) use ($start_date, $end_date) {
                        $q->whereRaw('start_date <= ? and end_date >= ? or start_date <= ? and end_date >= ? ', [$start_date, $start_date, $end_date, $end_date]);
                    })->where(function ($q) use ($start_time, $end_time) {
                        $q->whereRaw('start_time <= ? and end_time >= ? or start_time <= ? and end_time >= ? ', [$start_time, $start_time, $end_time, $end_time]);
                    });

            // ไม่นับรายการจองของตัวเอง
            $rs = $rs->where('id', '<>', @$mbv->id);

            $rs = $rs->get();
            // dump($rs);
        @endphp
        <ul>
            @foreach($rs as $item)
            <li>
                จองแล้ว ({{ $item->code }}) (วันที่ {{ DB2Date($item->start_date) }} {{ date("H:i", strtotime($item->start_time)) }} น. - {{ DB2Date($item->end_date) }} {{ date("H:i", strtotime($item->end_time)) }} น.)
            </li>
            @endforeach
        </ul>
    </td>
    <td>
        <input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip selectVehicleBtn" data-vehicle-id="{{ @$row->id }}" data-st-driver-id="{{ @$row->st_driver_id }}" data-vehicle-name="{{@$row->st_vehicle_type->name}} {{@$row->brand}} {{!empty(@$row->seat)?@$row->seat:'-'}} ที่นั่ง สี{{@$row->color}} ทะเบียน {{@$row->reg_number}}">
    </td>
</tr>
@endforeach