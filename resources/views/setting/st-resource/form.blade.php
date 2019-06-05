<table class="tbadd">
    <tr>
        <th>รหัสทรัพยากร<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="code" value="{{ isset($rs->code) ? $rs->code : old('code') }}" type="text" class="form-control {{ $errors->has('code') ? 'has-error' : '' }}" placeholder="รหัสทรัพยากร" style="width:100px;" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>ชื่อทรัพยากร<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" value="{{ isset($rs->name) ? $rs->name : old('name') }}" type="text" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" placeholder="ชื่อทรัพยากร" style="width:500px;" required />
            </div>
        </td>
    </tr>
    <tr>
        <th>เปิด/ปิด</th>
        <td>
            <input name="status" type="hidden" value="0" checked="chedked" />
            <input name="status" type="checkbox" id="status" checked value="1" {!! (@$rs->status == 1 ||
            empty($rs->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-resource') }}'" class="btn btn-default" style="width:100px;" />
</div>