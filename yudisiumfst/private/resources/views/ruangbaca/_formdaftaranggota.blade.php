
<div class="alert alert-warning infoo" style="display:none;">
    <ul></ul>
    <!-- <li></li> -->
</div>

<div class="form-group">
  <div class="col-sm-9">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">NIM</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NIM_ANGGOTA" name="NIM_ANGGOTA" placeholder="NIM">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nama</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NAMA_ANGGOTA" name="NAMA_ANGGOTA" placeholder="Nama">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Alamat</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="ALAMAT_ANGGOTA" name="ALAMAT_ANGGOTA" placeholder="Alamat">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Prodi</label>
  <div class="col-sm-9">
    <select class="form-control " name="ID_UNIT" id="ID_UNIT" value="<?php echo Form::old('ID_UNIT') ?>" required>
    <option value="" selected="selected" >Prodi</option>
      @foreach($prodi as $prodii)
      <option value="{{$prodii->ID_UNIT}}" {{ (Input::old("ID_UNIT") == $prodii->ID_UNIT ? "selected":"") }}>{{$prodii->UNIT}}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Telpon/HP</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="TELPON_ANGGOTA" name="TELPON_ANGGOTA" placeholder="Telpon/HP">
  </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
