<table class="tbadd">
    <tr class="{{ $errors->has('name') ? 'has-error' : '' }}">
        <th>ชื่อประเภทรถ<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" value="{{ isset($stvehicletype->name) ? $stvehicletype->name : old('name') }}" type="text" class="form-control" placeholder="ชื่อประเภทรถ" style="width:500px;" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>เปิด/ปิด</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$stvehicletype->status == 1 ||
            empty($stvehicletype->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"
        value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"
        onclick="document.location='{{ url('/setting/st-vehicle-type') }}'" class="btn btn-default" style="width:100px;" />
</div>