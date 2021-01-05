<table class="tbadd">
    <tr>
        <th>ชื่อระดับตำแหน่ง<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" type="text" class="form-control" placeholder="ชื่อระดับตำแหน่ง" style="width:500px;" value="{{ $rs->name ?? old('name') }}" required/></div>
        </td>
    </tr>
    <tr>
        <th>เปิดการใช้งาน</th>
        <td>
            <input name="status" type="hidden" value="0" checked="checked" />
            <input name="status" type="checkbox" id="status" value="1" {!! (@$rs->status == 1 || empty($rs->id)) ? 'checked="checked"' : '' !!} />
        </td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/setting/st-boss') }}'" class="btn btn-default" style="width:100px;" />
</div>
