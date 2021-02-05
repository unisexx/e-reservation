<!-- Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

<!-- Fonts -->
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->

<!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->




<!-- Fonts -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">


<!-- Styles -->
<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">

<!-- JavaScripts -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>


<link rel="stylesheet" href="{{ url('css/style.css?v=1.0.2') }}">
<link rel="stylesheet" href="{{ url('css/bootstrap-select.css') }}">
<script src="{{ url('js/bootstrap-select.js') }}"></script>

<script src="{{ url('js/jquery-ui-1.12.1.js') }}"></script>
<link rel="stylesheet" href="{{ url('css/jquery-ui-1.12.1.css') }}">

<link href="{{ url('css/bootstrap-sortable.css') }}" rel="stylesheet" type="text/css">
<script src="{{ url('js/bootstrap-sortable.js') }}"></script>
<script src="{{ url('js/moment.min.js') }}"></script>

<!-- Google recaptcha Api -->
<script src="//www.google.com/recaptcha/api.js"></script>

<!-- Colorbox jquery -->
<script src="{{ url('js/jquery.colorbox.js') }}"></script>
<link media="screen" rel="stylesheet" href="{{ url('css/colorbox.css') }}" />
<script>
    $(document).ready(function() {
        //Examples of how to assign the Colorbox event to elements
        $(".inline").colorbox({
            inline: true,
            width: "95%",
            height: "95%"
        });
        $(".inline2").colorbox({
            inline: true,
            width: "70%"
        });
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function() {
            $('#click').css({
                "background-color": "#f00",
                "color": "#fff",
                "cursor": "inherit"
            }).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>

<!-- <script src="{{ url('js/jstree.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('css/jstree.style.min.css') }}" />
<script>
    $(function() {
        // 6 create an instance when the DOM is ready
        $('#jstree').jstree();
        // 7 bind to events triggered on the tree
        $('#jstree').on("changed.jstree", function(e, data) {
            console.log(data.selected);
        });
        // 8 interact with the tree - either way is OK
        $('button').on('click', function() {
            $('#jstree').jstree(true).select_node('child_node_1');
            $('#jstree').jstree('select_node', 'child_node_1');
            $.jstree.reference('#jstree').select_node('child_node_1');
        });
    });
</script> -->

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<!-- Tooltip jquery -->
<script type="text/javascript" src="{{ url('js/vtip.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('css/vtip.css') }}" />

<!-- number format -->
<script type="text/javascript" src="{{ url('js/jquery.number.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('input.numDecimal').number(true, 2);
        $('input.numInt').number(true, 0);

        $('input.numOnly').bind('keypress', function(e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) ? false : true;
        });
    });
</script>

<!-- Input format new -->
<script src="{{ url('js/jquery.inputmask.bundle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();
    });
</script>

<!-- Input format -->
<script type="text/javascript" src="{{ url('js/jquery.maskedinput.js') }}"></script>
<script type="text/javascript">
    jQuery(function($) {
        $(".fdate").mask("99/99/9999");
        $(".fmobile").mask("(999) 999-9999");
        $(".fidcard").mask("9-9999-99999-99-9");
        $(".fnum").mask("999,999,999");
        $(".ftime").mask("99:99");
    });
</script>


<!-- Listbox show/hide -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".boxBetween").hide();
        $("select").change(function() {
            $(this).find("option:selected").each(function() {

                if ($(this).attr("value") == "6") {
                    $(".boxBetween").show();
                }
                if ($(this).attr("value") == "1" || $(this).attr("value") == "2" || $(this).attr("value") == "3" || $(this).attr("value") == "4" || $(this).attr("value") == "5") {
                    $(".boxBetween").hide();
                }
            });
        }).change();
    });
</script>

<!-- Radio show/hide -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".boxAddMulti").hide();
        $('input[type="radio"]').click(function() {

            //assets/form 
            if ($(this).attr("value") == "addone") {
                $(".boxAddMulti").hide();
            }
            if ($(this).attr("value") == "addmulti") {
                $(".boxAddMulti").show();
            }

        });
    });
</script>

<script>
    $(function() {
        var availableTags = [
            "[600200001] หน่วยตรวจสอบภายใน สำนักงานปลัดกระทรวงการพัฒนาสังคมฯ กรุงเทพฯ",
            "[600200003] สำนักบริหารงานกลาง สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
            "[600200000] สำนักงานปลัดกระทรวงพัฒนาสังคมและความมั่นคงของมนุษย์ กรุงเทพฯ",
            "[600200002] กลุ่มพัฒนาระบบบริหาร สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
            "[600200004] ส่วนการคลัง สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
        ];
        $("#tags").autocomplete({
            source: availableTags
        });

        var availableTags2 = [
            "สป-สบก(กอก) สำนักบริหารงานกลาง กลุ่มอำนวยการ",
            "สป-สบก(กพบ) สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล",
            "สป-สบก(กพอ) สำนักบริหารงานกลาง กลุ่มการพัฒนาองค์กรและระบบงาน",
            "สป-สบก(สกค) สำนักบริหารงานกลาง ส่วนการคลัง",
            "สป-สบก(กพค) กลุ่มการพัฒนาบุคคลและเสริมสร้างคุณธรรม",
        ];
        $("#tags2").autocomplete({
            source: availableTags2
        });
    });
</script>

{{-- datepicker --}}
<script src="{{ url('/js/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
<link rel='stylesheet' type='text/css' href="{{ url('/js/bootstrap-datepicker-thai/css/datepicker.css') }}" />
<script type="text/javascript">
    function datepicker_active(obj) {
        $(obj).datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'th-th',
            clearBtn: true
        });
        $(obj).each(function(k, v) {
            $(this).addClass('form-control').css({
                'display': 'inline-block',
                'width': '120px'
            }); //.attr('readonly',true);
            $(this).attr('placeholder', (!$(this).attr('placeholder') ? 'วัน/เดือน/ปี' : $(this).attr('placeholder')));
            $(this).after(' <img src="{{url('images/calendar.png')}}" alt="" width="24" height="24" /> ');
        });
    }
    $(function() {
        datepicker_active('.datepicker');
        /*
        $('.datepicker').datepicker({
        	format:'dd/mm/yyyy',
        	autoclose:true,
        	language:'th-th',
        	clearBtn: true
        });
        $('.datepicker').each(function(k, v){
        	$(this).addClass('form-control').css({'display':'inline-block', 'width':'120px'}); //.attr('readonly',true);
        	$(this).attr('placeholder',(!$(this).attr('placeholder')?'วัน/เดือน/ปี':$(this).attr('placeholder')));
        	$(this).after(' <img src="{{url('images/calendar.png')}}" alt="" width="24" height="24" /> ');
        })
        */
    });
</script>

{{-- alertify --}}
<script src="{{ url('/js/alertify/alertify.min.js') }}"></script>
<link href="{{ url('/js/alertify/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/js/alertify/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" />


<!-- chain select หน่วยงาน -->
{{-- <script>
    $(document).ready(function() {
        $('body').on('change', 'select[name=st_department_code]', function() {
            getBureau($(this).val());
        });
        $('body').on('change', 'select[name=st_bureau_code]', function() {
            getDivision($(this).val());
        });
    });

    function getBureau($st_department_code) {
        $('select[name=st_bureau_code],select[name=st_division_code]').empty().selectpicker('refresh');

        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetBureau') }}",
            data: {
                st_department_code: $st_department_code,
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $('select[name=st_bureau_code]').append('<option value="' + i.code + '">' + i.title + '</option>');
            });
            $('select[name=st_bureau_code]').selectpicker('refresh');
        });
    }

    function getDivision($st_bureau_code) {
        $('select[name=st_division_code]').empty().selectpicker('refresh');

        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetDivision') }}",
            data: {
                st_bureau_code: $st_bureau_code,
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $('select[name=st_division_code]').append('<option value="' + i.code + '">' + i.title + '</option>');
            });
            $('select[name=st_division_code]').selectpicker('refresh');
        });
    }
</script> --}}

<!-- chain select หน่วยงานใหม่ -->
<script>
    $(document).ready(function() {
        $('body').on('change', 'select.chain-department', function() {
            getBureau($(this));
        });
        $('body').on('change', 'select.chain-bureau', function() {
            getDivision($(this));
        });
    });

    function getBureau($department, $st_bureau_code_select = false) {
        $thisGroup = $department.closest('.dep-chain-group');
        $thisGroup.find('select.chain-bureau, select.chain-division').empty().selectpicker('refresh');
        var st_bureau_code_select = $st_bureau_code_select;
        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetBureau') }}",
            data: {
                st_department_code: $department.val(),
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $thisGroup.find('select.chain-bureau').append('<option value="' + i.code + '">' + i.title + '</option>');
            });
            $thisGroup.find('select.chain-bureau').val(st_bureau_code_select);
            $thisGroup.find('select.chain-bureau').selectpicker('refresh');
        });
    }

    function getDivision($bureau, $st_division_code_select = false) {
        $thisGroup = $bureau.closest('.dep-chain-group');
        $thisGroup.find('select.chain-division').empty().selectpicker('refresh');
        var st_division_code_select = $st_division_code_select;
        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetDivision') }}",
            data: {
                st_bureau_code: $bureau.val(),
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $thisGroup.find('select.chain-division').append('<option value="' + i.code + '">' + i.title + '</option>');
            });
            $thisGroup.find('select.chain-division').val(st_division_code_select);
            $thisGroup.find('select.chain-division').selectpicker('refresh');
        });
    }
</script>

<!-- chain select หน่วยงานของยานพาหนะ -->
<script>
    $(document).ready(function() {
        $('body').on('change', 'select.chain-department-vehicle', function() {
            getBureauVehicle($(this));
        });
        $('body').on('change', 'select.chain-bureau-vehicle', function() {
            getDivisionVehicle($(this));
        });
    });

    function getBureauVehicle($department) {
        $thisGroup = $department.closest('.dep-chain-group');
        $thisGroup.find('select.chain-bureau-vehicle, select.chain-division-vehicle').empty().selectpicker('refresh');

        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetBureauVehicle') }}",
            data: {
                st_department_code: $department.val(),
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $thisGroup.find('select.chain-bureau-vehicle').append('<option value="' + i.st_bureau_code + '">' + i.bureau.title + '</option>');
            });
            $thisGroup.find('select.chain-bureau-vehicle').selectpicker('refresh');
        });
    }

    function getDivisionVehicle($bureau) {
        $thisGroup = $bureau.closest('.dep-chain-group');
        $thisGroup.find('select.chain-division-vehicle').empty().selectpicker('refresh');

        $.ajax({
            method: "GET",
            url: "{{ url('ajaxGetDivisionVehicle') }}",
            data: {
                st_bureau_code: $bureau.val(),
            }
        }).done(function(data) {
            $.map(data, function(i) {
                $thisGroup.find('select.chain-division-vehicle').append('<option value="' + i.st_division_code + '">' + i.division.title + '</option>');
            });
            $thisGroup.find('select.chain-division-vehicle').selectpicker('refresh');
        });
    }
</script>


<!-- full calendar -->
<link href="{{ url('js/fullcalendar-4.0.1/packages/core/main.css') }}" rel="stylesheet" />
<link href="{{ url('js/fullcalendar-4.0.1/packages/daygrid/main.css') }}" rel="stylesheet" />
<link href="{{ url('js/fullcalendar-4.0.1/packages/timegrid/main.css') }}" rel="stylesheet" />
<link href="{{ url('js/fullcalendar-4.0.1/packages/list/main.css') }}" rel="stylesheet" />
<script src="{{ url('js/fullcalendar-4.0.1/packages/core/main.js') }}"></script>
<script src="{{ url('js/fullcalendar-4.0.1/packages/core/locales-all.js') }}"></script>
<script src="{{ url('js/fullcalendar-4.0.1/packages/interaction/main.js') }}"></script>
<script src="{{ url('js/fullcalendar-4.0.1/packages/daygrid/main.js') }}"></script>
<script src="{{ url('js/fullcalendar-4.0.1/packages/timegrid/main.js') }}"></script>
<script src="{{ url('js/fullcalendar-4.0.1/packages/list/main.js') }}"></script>


<!-- เช็กเวลาที่เริ่ม - สิ้นสุด -->
<script>
$(document).ready(function(){
    if($('.chkTime').length){
        chkTime();
    }
    
    $('body').on('change', '.chkTime select,.chkTime input', function(){
        chkTime();
    });
});

function chkTime(){
    sDateEle = $("#sDate");
    sHourEle = $("#sHour");
    sMinuteEle = $("#sMinute");
    eDateEle = $("#eDate");
    eHourEle = $("#eHour");
    eMinuteEle = $("#eMinute");

    // ถ้าวันที่เริ่ม - สิ้นสุดมีค่าเท่ากัน ให้คำนวนเวลา
    a = thToTimeStamp(sDateEle.val());
    b = thToTimeStamp(eDateEle.val());
    // console.log(sDateEle.val());
    // console.log(eDateEle.val());
    // console.log(a);
    // console.log(b);
    if(a == b){

        // ถ้านาทีที่เริ่ม - สิ้นสุดมีค่าเท่ากัน ให้คำนวนเวลา
        if(parseInt(sHourEle.val()) == parseInt(eHourEle.val())){

            // ถ้านาทีที่เริ่ม มีค่ามากกว่า ชั่วโมงที่สิ้นสุด ให้ปรับ นาทีที่สิ้นสุดมีค่าเท่ากับนาทีที่เริ่ม
            if(parseInt(sMinuteEle.val()) > parseInt(eMinuteEle.val())){
                eMinuteEle.val( sMinuteEle.val() ).selectpicker('refresh');
            }

        // ถ้าชั่วโมงที่เริ่ม มีค่ามากกว่า ชั่วโมงที่สิ้นสุด ให้ปรับ ชั่วโมงที่สิ้นสุดมีค่าเท่ากับชั่วโมงที่เริ่ม
        }else if( parseInt(sHourEle.val()) > parseInt(eHourEle.val()) ){
            eHourEle.val( sHourEle.val() ).selectpicker('refresh');

            // ถ้านาทีที่เริ่ม มีค่ามากกว่า ชั่วโมงที่สิ้นสุด ให้ปรับ นาทีที่สิ้นสุดมีค่าเท่ากับนาทีที่เริ่ม
            if(parseInt(sMinuteEle.val()) > parseInt(eMinuteEle.val())){
                eMinuteEle.val( sMinuteEle.val() ).selectpicker('refresh');
            }
        }

    }

    // อัพเดท input start_time , end_time 
    $('[name=start_time]').val( sHourEle.val()+":"+sMinuteEle.val() );
    $('[name=end_time]').val( eHourEle.val()+":"+eMinuteEle.val() );
}

// แปลงวันไทยเป็น timestamp
function thToTimeStamp(thDate){
    // แปลงให้เป็นปี ค.ศ. ก่อน
    var dateArray = thDate.split("/");
    return new Date((parseInt(dateArray[2])-543), dateArray[1], dateArray[0]).getTime();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }
</style>