<?php
    // perms
    $perms = App\Model\Perm::where('parent_id',0)->orderBy('order','asc')->get();
    isset($permissiongroup->id) ? $pm = App\Model\PermissionRole::where('permission_group_id',$permissiongroup->id)->pluck('permission_id')->toArray() : '';
?>

<table class="tbadd">
    <tr>
        <th>ชื่อสิทธิ์การใช้งาน<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="title" type="text" id="title" class="form-control" value="{{ isset($permissiongroup->title) ? $permissiongroup->title : ''}}" style="width:500px;" required/>
            </div>
        </td>
        <td></td>
    </tr>
    <tr>
        <th>เปิดการใช้งาน</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$permissiongroup->status == 1 || empty($permissiongroup->id)) ? 'checked="checked"' : '' !!} />
        </td>
        <td></td>
    </tr>
    @foreach($perms as $perm)
    <tr>
        <th colspan="3" class="topic">{!! $perm->name !!}</th>
    </tr>
        @foreach ($perm->childs()->orderBy('order')->where('status',1)->get() as $key => $child)
        <tr class="perm_id_{{ $child->id }}">
            <th class="paddL40"><div style="width: 200px;">{!! $child->name !!}</div></th>
            <td class="row_{{ $child->id }}">
                @foreach($child->permissions()->orderBy('id')->get() as $key => $p)
                    <label class="chkbox">
                        <input type="checkbox" name="pm[]" value="{{ $p->id }}" {{ @in_array($p->id, $pm) == 1 ? 'checked=chedked' : '' }} /> {{ $p->display_name }}
                    </label>
                @endforeach
            </td>
            @if($child->id <> 20 && $child->id <> 21)
            <td>
                <label style="float: right; width: 400px;">
                    <button type="button" class="btn btn-sm btn-default checkAllRow">เลือกทั้งหมด</button>
                    <button type="button" class="btn btn-sm btn-default unCheckAllRow">ไม่เลือกทั้งหมด</button>
                </label>
            </td>
            @else
                <td></td>
            @endif
        </tr>
        @endforeach
    @endforeach
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/permission-group') }}'" class="btn btn-default" style="width:100px;" />
</div>

<script>
$(document).ready(function(){
    $('body').on('change', '.row_20 input[type=checkbox]', function(){
        if(this.checked) {
            $(this).closest('.chkbox').siblings().find('input[type=checkbox]').prop('checked', false);
        }
    });

    $('.checkAllRow').on('click', function(){
        var value = $(this).closest('tr').find('input').prop('checked', true);
        return false;
    });

    $('.unCheckAllRow').on('click', function(){
        $(this).parent().closest('tr').find('input').prop('checked', false);
        return false;
    });

    var permissionGroupId = "{{ @$permissiongroup->id }}";
    if(permissionGroupId == ''){
        $('.perm_id_20').find('input[type=checkbox]:eq(0)').attr("checked","checked");
    }

    // คลิกดูเฉพาะห้องที่มีการจอง conference
    // $('body').on('click' ,'input[name="pm[]"][value="72"]', function(){
    //     if($(this).is(':checked')){
    //         $('input[name="pm[]"][value="1"]').prop('checked', true);
    //     }else{
    //         $('input[name="pm[]"][value="1"]').prop('checked', false);
    //     }
    // });
});
</script>