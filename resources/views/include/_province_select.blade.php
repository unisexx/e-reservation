@extends('layouts.front')

@section('content')
{{ Form::select("st_boss_position_id", \App\Model\StProvince::where('id','<>',1)->where('status', 1)->orderBy('code','asc')->pluck('name', 'code'), '', ['class'=>'form-control goUrl', 'style'=>'width:auto; display:inline;', 'placeholder'=>'--- เลือกจังหวัด ---']) }}
@endsection

@push('js')
<script>
    $(function(){
        // bind change event to select
        $('select.goUrl').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = 'show?st_province_code='+url; // redirect
            }
            return false;
        });
    });
</script>
@endpush