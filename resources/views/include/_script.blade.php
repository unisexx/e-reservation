<!-- Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

<!-- Fonts -->
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->

<!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->




<!-- Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

<!-- Styles -->
<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}"> 

<!-- JavaScripts -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>

	
<link rel="stylesheet" href="{{ url('css/style.css') }}">	
<link rel="stylesheet" href="{{ url('css/bootstrap-select.css') }}">
<script src="{{ url('js/bootstrap-select.js') }}"></script>

<script src="{{ url('js/jquery-ui-1.12.1.js') }}"></script>
<link rel="stylesheet" href="{{ url('css/jquery-ui-1.12.1.css') }}">

<link href="{{ url('css/bootstrap-sortable.css') }}" rel="stylesheet" type="text/css">
<script src="{{ url('js/bootstrap-sortable.js') }}"></script>
<script src="{{ url('js/moment.min.js') }}"></script>

<!-- Colorbox jquery -->
<script src="{{ url('js/jquery.colorbox.js') }}"></script>
<link media="screen" rel="stylesheet" href="{{ url('css/colorbox.css') }}" />
<script>
    $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        $(".inline").colorbox({inline:true, width:"95%"});
        $(".inline2").colorbox({inline:true, width:"70%"});
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>

<script src="{{ url('js/jstree.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('css/jstree.style.min.css') }}" />
<script>
$(function () {
    // 6 create an instance when the DOM is ready
    $('#jstree').jstree();
    // 7 bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
        console.log(data.selected);
    });
    // 8 interact with the tree - either way is OK
    $('button').on('click', function () {
        $('#jstree').jstree(true).select_node('child_node_1');
        $('#jstree').jstree('select_node', 'child_node_1');
        $.jstree.reference('#jstree').select_node('child_node_1');
    });
});
</script>

<script>  
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

<!-- Tooltip jquery -->
<script type="text/javascript" src="{{ url('js/vtip.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('css/vtip.css') }}" />

<!-- number format -->
<script type="text/javascript" src="{{ url('js/jquery.number.js') }}"></script>
<script type="text/javascript">
$(function(){
	$('input.numDecimal').number( true, 2 );
	$('input.numInt').number( true, 0 );
	
	$('input.numOnly').bind('keypress', function(e) {
        return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
	});
});
</script>

<!-- Input format new -->
<script src="{{ url('js/jquery.inputmask.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>

<!-- Input format -->
<script type="text/javascript" src="{{ url('js/jquery.maskedinput.js') }}"></script>
<script type="text/javascript">
jQuery(function($){
    $(".fdate").mask("99/99/9999");
    $(".fmobile").mask("(999) 999-9999");
    $(".fidcard").mask("9-9999-99999-99-9");
    $(".fnum").mask("999,999,999");
    $(".ftime").mask("99:99");
});
</script>


<!-- Listbox show/hide -->
<script type="text/javascript">
$(document).ready(function(){
	$(".boxBetween").hide();
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
			
			if($(this).attr("value")=="6"){
                $(".boxBetween").show();
            }
            if($(this).attr("value")=="1" || $(this).attr("value")=="2" || $(this).attr("value")=="3" || $(this).attr("value")=="4" || $(this).attr("value")=="5"){
                $(".boxBetween").hide();
            }
        });
    }).change();
});
</script>

<!-- Radio show/hide -->
<script type="text/javascript">
$(document).ready(function(){
	$(".boxAddMulti").hide();
    $('input[type="radio"]').click(function(){
		
		//assets/form 
        if($(this).attr("value")=="addone"){
			$(".boxAddMulti").hide();
        }
		if($(this).attr("value")=="addmulti"){
			$(".boxAddMulti").show();
        }
		
    });
});
</script>

<script>
$( function() {
    var availableTags = [
        "[600200001] หน่วยตรวจสอบภายใน สำนักงานปลัดกระทรวงการพัฒนาสังคมฯ กรุงเทพฯ",
        "[600200003] สำนักบริหารงานกลาง สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
        "[600200000] สำนักงานปลัดกระทรวงพัฒนาสังคมและความมั่นคงของมนุษย์ กรุงเทพฯ",
        "[600200002] กลุ่มพัฒนาระบบบริหาร สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
        "[600200004] ส่วนการคลัง สำนักงานปลัดกระทรวงพัฒนาสังคมฯ กรุงเทพฯ",
    ];
    $( "#tags" ).autocomplete({
        source: availableTags
    });

    var availableTags2 = [
        "สป-สบก(กอก) สำนักบริหารงานกลาง กลุ่มอำนวยการ",
        "สป-สบก(กพบ) สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล",
        "สป-สบก(กพอ) สำนักบริหารงานกลาง กลุ่มการพัฒนาองค์กรและระบบงาน",
        "สป-สบก(สกค) สำนักบริหารงานกลาง ส่วนการคลัง",
        "สป-สบก(กพค) กลุ่มการพัฒนาบุคคลและเสริมสร้างคุณธรรม",
    ];
    $( "#tags2" ).autocomplete({
        source: availableTags2
    });
} );
</script>

{{-- alertify --}}
<script src="{{ url('/js/alertify/alertify.min.js') }}"></script>
<link href="{{ url('/js/alertify/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/js/alertify/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" />


<!-- chain select หน่วยงาน -->
<script>
$(document).ready(function(){
    $('body').on('change', 'select[name=st_department_code]', function(){
        getBureau( $(this).val() );
    });
    $('body').on('change', 'select[name=st_bureau_code]', function(){
        getDivision( $(this).val() );
    });
});

function getBureau($st_department_code){
    $('select[name=st_bureau_code],select[name=st_division_code]').empty().selectpicker('refresh');

    $.ajax({
        method: "GET",
        url: "{{ url('ajaxGetBureau') }}",
        data: { 
            st_department_code: $st_department_code,
        }
    }).done(function( data ) {
        $.map(data, function (i) { 
            $('select[name=st_bureau_code]').append('<option value="' + i.code + '">' + i.title + '</option>'); 
        });
        $('select[name=st_bureau_code]').selectpicker('refresh');
    });
}

function getDivision($st_bureau_code){
    $('select[name=st_division_code]').empty().selectpicker('refresh');

    $.ajax({
        method: "GET",
        url: "{{ url('ajaxGetDivision') }}",
        data: { 
            st_bureau_code: $st_bureau_code,
        }
    }).done(function( data ) {
        $.map(data, function (i) { 
            $('select[name=st_division_code]').append('<option value="' + i.code + '">' + i.title + '</option>'); 
        });
        $('select[name=st_division_code]').selectpicker('refresh');
    });
}
</script>