<table class="tbadd">
    <tr>
        <th>ระดับตำแหน่ง<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                @php
                    $stPositionLevel = App\Model\StPositionLevel::where('status',1)->get();
                @endphp
                <select name="level" class="form-control">
                    @foreach($stPositionLevel as $item)
                        <option value="{{ $item->id }}" @if(@$rs->level == $item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <th>ชื่อ-สกุล<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="name" type="text" class="form-control" placeholder="ชื่อ-สกุล" style="width:500px;" value="{{ $rs->name ?? old('name') }}" required/></div>
        </td>
    </tr>
    <tr>
        <th>ตำแหน่ง<span class="Txt_red_12"> *</span></th>
        <td><input name="position" type="text" class="form-control" placeholder="ตำแหน่ง" style="width:500px;" value="{{ $rs->position ?? old('position') }}" required /></td>
    </tr>
    <tr>
        <th>เบอร์ติดต่อ <span class="Txt_red_12">*</span></th>
        <td>
            <div class="form-inline">
                <input name="tel" type="text" class="form-control" placeholder="เบอร์ติดต่อ" style="width:300px;" value="{{ $rs->tel ?? old('tel') }}" required/>
            </div>
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
