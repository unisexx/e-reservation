<table class="tbadd">
    <tr>
        <th>ประเภท<span class="Txt_red_12"> *</span> / ยี่ห้อ<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <select name="" class="form-control">
                    <option>-- เลือกประเภทรถ --</option>
                </select>
                <input name="textarea4" type="text" class="form-control" id="textarea4" placeholder="ยี่ห้อ"
                    style="width:300px;" /></div>
        </td>
    </tr>
    <tr>
        <th>ที่นั่ง<span class="Txt_red_12"> *</span> / สี <span class="Txt_red_12"> *</span> / เลขทะเบียน<span
                class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <input name="textarea7" type="text" class="form-control" id="textarea7" placeholder="ที่นั่ง"
                    style="width:100px;" />
                <input name="textarea4" type="text" class="form-control" id="textarea4" placeholder="สี"
                    style="width:200px;" />
                <input name="textarea4" type="text" class="form-control" id="textarea4" placeholder="เลขทะเบียน"
                    style="width:200px;" />
            </div>
        </td>
    </tr>
    <tr>
        <th>หน่วยงานที่รับผิดชอบ<span class="Txt_red_12"> *</span></th>
        <td>
            <div class="form-inline">
                <select name="lunch" class="selectpicker" id="lunch2" title="หน่วยงาน" data-live-search="true">
                    <option selected="selected">[06102008001] กองยุทธศาสตร์และแผนงาน ฝ่ายบริหารทั่วไป</option>
                    <option>[06102011001] ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร ฝ่ายบริหารทั่วไป</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <th>พนักงานขับวันนี้<span class="Txt_red_12"> *</span></th>
        <td><span class="form-inline">
                <select name="select2" class="form-control">
                    <option>นายวิทยา แก่นดี 081-9814314</option>
                    <option>นายดารพ ป้องนวน 088-9866011</option>
                </select>
            </span></td>
    </tr>
    <tr>
        <th>สถานะ</th>
        <td><span class="form-inline">
                <select name="select" class="form-control">
                    <option>พร้อมใช้</option>
                    <option>ซ่อมบำรุง</option>
                </select>
            </span></td>
    </tr>
</table>
<div id="btnBoxAdd">
    <input name="input" type="submit" title="บันทึก" value="บันทึก" class="btn btn-primary" style="width:100px;"
        value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}" />
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ"
        onclick="document.location='{{ url('/setting/st-room') }}'" class="btn btn-default" style="width:100px;" />
</div>