@foreach($rs as $key=>$row)
<tr @if(($key % 2)==1) class="odd" @endif>
    <td>{{ $key+1 }}</td>
    <td>@if(@$row->image) <img src="{{ url('uploads/vehicle/'.@$row->image) }}" width="90"> @endif</td>
    <td>{{@$row->st_vehicle_type->name}} {{@$row->brand}} {{!empty(@$row->seat)?@$row->seat:'-'}} ที่นั่ง สี{{@$row->color}} ทะเบียน {{@$row->reg_number}}</td>
    {{-- <td>{{@$row->st_driver->name}} {{@$row->st_driver->tel}}</td> --}}
    <td>{{@$row->status}}</td>
    <td>
        <input type="button" title="เลือก" value="เลือก" class="btn btn-primary vtip selectVehicleBtn" data-vehicle-id="{{ @$row->id }}" data-st-driver-id="{{ @$row->st_driver_id }}" data-vehicle-name="{{@$row->st_vehicle_type->name}} {{@$row->brand}} {{!empty(@$row->seat)?@$row->seat:'-'}} ที่นั่ง สี{{@$row->color}} ทะเบียน {{@$row->reg_number}}">
    </td>
</tr>
@endforeach