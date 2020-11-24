@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-room' : 'booking-room-front');
    $st_rooms = App\Model\StRoom::where('status', 1)->orderBy('name', 'asc')->get();
    $req_st_room_id = request('st_room_id') ?? App\Model\StRoom::where('is_default', 1)->first()->id;
@endphp

<script>
    // window.mobilecheck = function() {
    // var check = false;
    //     (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    //     return check;
    // };

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            // defaultView: window.mobilecheck() ? "listweek" : "dayGridWeek",
            buttonText: {
                list: 'รายการ',
                prev: 'เดือนก่อนหน้า',
                next: 'เดือนถัดไป',
            },
            customButtons: {
                addBtn: {
                    text: '+ ขอจองห้องประชุม/อบรม',
                    click: function() {
                        window.location.href = "/{{ $action }}/create?st_room_id={{ @$req_st_room_id }}";
                    }
                }
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth addBtn'
            },
            // defaultDate: '2019-03-12',
            locale: 'th',
            buttonIcons: false, // show the prev/next text
            weekNumbers: false,
            navLinks: true, // can click day/week names to navigate views
            // editable: true,
            eventLimit: false, // allow "more" link when too many events
            selectable: true,
            selectMirror: true,
            displayEventTime: false,
            select: function(arg) {
                // console.log(arg.startStr);
                window.location.href = "/{{ $action }}/create?start_date=" + arg.startStr;
            },
            events: [
                @foreach($rs as $key => $row) {
                    shortTitle: '[{{ displyDateTime($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}] [{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                    title: '{{ $row->code }}\nสถานะ: {{ $row->status }}\nเรื่อง/หัวข้อการประชุม-อบรม: {{ $row->title }}\nประธานการประชุม: {{ $row->president_name }} ({{ $row->president_position }}) \nวัน-เวลา: {{ displyDateTime2($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}\nผู้ขอใช้: {{ $row->request_name }} ({{ $row->request_position }})\nหน่วยงานผู้ขอใช้: {{ $row->department->title }}, {{ $row->bureau->title }}, {{ $row->division->title }}\nโทรศัพท์: {{ $row->request_tel }}\nอีเมล์: {{ $row->request_email }}\nจำนวน: {{ $row->number }} คน {!! @$row->internet_number > 0 ? "และขอใช้งานอินเตอร์เน็ต: ".$row->internet_number." คน" : "" !!} \nห้องประชุม: {{ $row->st_room->name }}\nผู้รับผิดชอบห้องประชุม: {{ $row->st_room->res_name }}, โทร: {{ $row->st_room->res_tel }}',
                    titleColorBox: '{{ $row->code }}\n<span style="color:#c9884c; font-size:16px;">สถานะ:</span> {{ $row->status }}\n<span style="color:#c9884c; font-size:16px;">เรื่อง/หัวข้อการประชุม-อบรม:</span> {{ $row->title }}\n<span style="color:#c9884c; font-size:16px;">ประธานการประชุม:</span> {{ $row->president_name }} ({{ $row->president_position }}) \n<span style="color:#c9884c; font-size:16px;">วัน-เวลา:</span> {{ displyDateTime2($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}\n<span style="color:#c9884c; font-size:16px;">ผู้ขอใช้:</span> {{ $row->request_name }} ({{ $row->request_position }})\n<span style="color:#c9884c; font-size:16px;">หน่วยงานผู้ขอใช้:</span> {{ $row->department->title }}, {{ $row->bureau->title }}, {{ $row->division->title }}\n<span style="color:#c9884c; font-size:16px;">โทรศัพท์:</span> {{ $row->request_tel }}\n<span style="color:#c9884c; font-size:16px;">อีเมล์:</span> {{ $row->request_email }}\n<span style="color:#c9884c; font-size:16px;">จำนวน:</span> {{ $row->number }} คน {!! @$row->internet_number > 0 ? "และขอใช้งานอินเตอร์เน็ต: ".$row->internet_number." คน" : "" !!} \n<span style="color:#c9884c; font-size:16px;">ห้องประชุม:</span> {{ $row->st_room->name }}\n<span style="color:#c9884c; font-size:16px;">ผู้รับผิดชอบห้องประชุม:</span> {{ $row->st_room->res_name }}, โทร: {{ $row->st_room->res_tel }}',
                    start: '{{ $row->start_date }}T{{ $row->start_time }}',
                    end: '{{ $row->end_date }}T{{ $row->end_time }}',
                    color: "{{ colorStatus($row->status) }}",
                },
                @endforeach
            ],
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
            },
            eventRender: function(info) {
                $(info.el.childNodes).find('.fc-title').text(info.event.extendedProps.shortTitle);
            },
            eventClick: function(info) {
                // alert(info.event.title);
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.extendedProps.titleColorBox.replace(/\n/g, "<br />")+'</div>',
                    width: "50%",
                });
            }
        });

        calendar.render();
    });
</script>
<style>
    #top {
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        font-size: 12px;
    }

    #calendar {
        /* max-width: 90%; */
        margin: 40px auto;
        padding: 0 10px;
    }

    .fc-addBtn-button {
        color: #fff !important;
        background-color: #5cb85c !important;
        border-color: #4cae4c !important;
    }

    .fc-day-grid-event .fc-content {
        white-space: normal;
    }

    .fc-day-top {
        text-align: center !important;
    }
    .fc-ltr .fc-dayGrid-view .fc-day-top .fc-day-number{
        float:none;
    }
</style>

<div id="btnBox">
    <a href="{{ $from == 'backend' ? url('booking-room') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองห้องประชุม/อบรม</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">
            <input id="searchTxt" type="text" class="form-control" style="width:80%;" placeholder="รหัสการจอง / ชื่อผู้ขอจอง" name="search" value="{{ request('search') }}">
            <input type="hidden" name="searchform" value="1">
            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>


@if( @$_GET['searchform'] == 1)

    {{-- แสดงผลแบบตาราง --}}
    <a href="{{ $from == 'backend' ? url('booking-room/show') : url('booking-room-front/show') }}" class="btn btn-lg btn-warning pull-right" style="margin-bottom:10px;">กลับหน้าปฎิทิน</a>
    <h4>ผลการค้นหา</h4>
    <table class="table table-bordered table-striped sortable tblist">
        <thead>
            <tr>
                <th style="width:10%" class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
                <th style="width:30%" class="nosort" data-sortcolumn="2" data-sortkey="2-0">หัวข้อการประชุม / ห้องประชุม</th>
                <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="3-0">วัน เวลา ที่ต้องการใช้ห้อง</th>
                <th style="width:15%" class="nosort" data-sortcolumn="4" data-sortkey="4-0">ผู้ขอใช้ห้องประชุม</th>
                <th style="width:5%" class="nosort" data-sortcolumn="5" data-sortkey="5-0">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rs as $key=>$row)
            <tr @if(($key % 2)==1) class="odd" @endif>
                <td nowrap="nowrap">{{ $row->code }}</td>
                <td>
                    <div class="topicMeeting">{{ $row->title }}</div>
                    {{ $row->st_room->name }}
                    @if(empty(request('export')))
                    <img src="{{ url('images/detail.png') }}" class="vtip" title="
                    <u>จำนวนคนที่รองรับได้</u> {{ $row->st_room->people }} คน<br>
                    <u>อุปกรณ์ที่ติดตั้งในห้อง</u> {{ $row->st_room->equipment }}<br>
                    <u>ผู้รับผิดชอบห้องประชุม</u> {{ $row->st_room->res_name }} {{ $row->st_room->department->title }} {{ $row->st_room->bureau->title }}<br>{{ $row->st_room->division->title }}<br>
                    <u>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม</u> {{ $row->st_room->fee }}" />
                    @endif
                </td>
                <td>
                    <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
                </td>
                <td>{{ $row->request_name }}
                    @if(empty(request('export')))
                    <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
                    {{ $row->request_tel }} {{ $row->request_email }}" />
                    @endif
                </td>
                <td><span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

@else

    {{-- แสดงผลแบบปฏิทิน --}}
    @include('include._color_status', [ 'allrow' => $rs_all, 'from' => $from ])

    <div class="text-center" style="width:50%; margin: 0 auto;">
        <select class="selectpicker goUrl form-control" data-size="15" data-live-search="true" title="+ ห้องประชุม +">
            @foreach($st_rooms as $item)
                <option value="{{ url('booking-room-front/show?st_room_id='.$item->id.'&search='.request('search')) }}" @if(@$req_st_room_id == $item->id) selected="selected" @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div id='calendar'></div>

@endif

@endsection

@push('js')
<script>
$(document).ready(function(){
    if($("select.goUrl option:selected").val()){
        $('#roomName').text($("select.goUrl option:selected").text());
    }
});
</script>

<script>
    $(function(){
        // bind change event to select
        $('select.goUrl').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>
@endpush

@push('css')
<style>
    .bootstrap-select.btn-group .dropdown-toggle .filter-option{
        font-size: 25px;
    }
    .bootstrap-select > .dropdown-toggle{
        height: 55px !important;
    }
</style>
@endpush