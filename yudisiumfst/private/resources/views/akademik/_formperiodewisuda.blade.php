
<div class="alert alert-warning infoo" style="display:none;">
    <ul></ul>
</div>

<div class="form-group">
  <div class="col-sm-9">
  </div>
</div>
    <input type="hidden" id="ID_PERIODE_WISUDA" name="NAMA">

<div class="form-group" required>
  <label class="col-sm-3 control-label" required>Tanggal Wisuda</label>
  <div class="col-sm-9" required>
    <input type="date" class="form-control" id="TGL_WISUDA" name="NAMA">
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>Deskripsi</label>
  <div class="col-sm-9" required>
    <textarea class="form-control" id="DESKRIPSI" name="NAMA" placeholder="Deskripsi" required></textarea>
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label">Status</label>
  <div class="col-sm-9">
    <select class="form-control" id="STATUS_PERIODE_WISUDA" name="NAME" required>
      <option value="1" name="Tampilkan" id="Tampilkan">Tampilkan</option>
      <option value="0" name="Sembunyikan" id="Sembunyikan">Sembunyikan</option>
    </select>
  </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
