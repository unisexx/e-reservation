<table class="tbadd">
    <tr class="{{ $errors->has('name') ? 'has-error' : '' }}">
        <th>ชื่อสกุล<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" value="{{ isset($rs->name) ? $rs->name : old('name') }}" type="text" class="form-control" placeholder="ชื่อ-สกุล"
                    style="width:500px;" /></div>
        </td>
    </tr>
    <tr class="{{ $errors->has('st_department_id') ? 'has-error' : '' }}">
        <th>หน่วยงาน<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <select name="st_department_id" class="selectpicker" id="lunch" title="หน่วยงาน" data-live-search="true">
                    <option>[สป-สบก(กอก)] สำนักบริหารงานกลาง กลุ่มอำนวยการ</option>
                    <option>สป-สบก(กพบ)] สำนักบริหารงานกลาง กลุ่มการพัฒนาระบบการบริหารงานบุคคล</option>
                </select>
            </div>
        </td>
    </tr>
    <tr class="{{ $errors->has('tel') ? 'has-error' : '' }}">
        <th>เบอร์ติดต่อ <span class="Txt_red_12">*</span></th>
        <td>
            <div class="form-inline">
                <input name="tel" value="{{ isset($rs->tel) ? $rs->tel : old('tel') }}" type="text" class="form-control" placeholder="เบอร์ติดต่อ" style="width:300px;" />
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
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"
        value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"
        onclick="document.location='{{ url('/setting/st-driver') }}'" class="btn btn-default"
        style="width:100px;" />
</div>
