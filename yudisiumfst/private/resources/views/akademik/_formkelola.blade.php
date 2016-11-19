
<div class="alert alert-warning infoo" style="display:none;">
    <ul></ul>
    <!-- <li></li> -->
</div>

<div class="form-group">
  <div class="col-sm-9">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">NIP</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NIP" name="NIP" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nama</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NAMA_PEGAWAI" name="NAMA_PEGAWAI" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Jabatan</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="JABATAN" name="JABATAN" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Unit</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="UNIT" name="UNIT" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Aktivasi</label>
  <div class="col-sm-9">
    <select class="form-control " name="AKTIVASI" id="AKTIVASI" value="<?php echo Form::old('AKTIVASI') ?>" required>
      <option value="" selected="selected" >---</option>
      <option value="1" {{ (Input::old("AKTIVASI") == 1 ? "selected":"") }}>Aktif</option>
      <option value="0" >Tidak Aktif</option>
    </select>
  </div>
</div>

<input type="hidden" class="form-control" id="USERNAME" name="USERNAME">

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
