
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
    <input type="text" class="form-control" id="NIM" name="NIM" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nama</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NAMA" name="NAMA" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Prodi</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="UNIT" name="UNIT" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Password Baru</label>
  <div class="col-sm-9">
    <input type="password" class="form-control" id="PASSWORD_BARU" name="PASSWORD_BARU" placeholder="Password Baru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Konfirmasi Password Baru</label>
  <div class="col-sm-9">
    <input type="password" class="form-control" id="KONFIRMASI_PASSWORD_BARU" name="KONFIRMASI_PASSWORD_BARU" placeholder=" Konfirmasi Password Baru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required>
  </div>
</div>

<input type="hidden" class="form-control" id="JENIS_KELAMIN" name="JENIS_KELAMIN">
<input type="hidden" class="form-control" id="TELPON" name="TELPON">

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
