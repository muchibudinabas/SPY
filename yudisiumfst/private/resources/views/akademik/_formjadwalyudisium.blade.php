
<div class="alert alert-warning infoo" style="display:none;">
    <ul></ul>
    <!-- <li></li> -->
</div>

<div class="form-group">
  <div class="col-sm-9">
  </div>
</div>

    <input type="hidden" id="ID_JADWAL_YUDISIUM" name="NAMA">

<div class="form-group">
  <label class="col-sm-3 control-label">Periode Wisuda</label>
  <div class="col-sm-9">
    @foreach($pw as $pww)
    <input type="hidden" class="form-control" id="ID_PERIODE" name="NAMA" value="{{$pww->ID_PERIODE_WISUDA}}">
    <input disabled class="form-control" placeholder="{{indonesiaDate($pww->TGL_WISUDA)}}">
    @endforeach
  </div>
</div>

 <div class="form-group">
  <label class="col-sm-3 control-label">Yudisium</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="YUDISIUM" name="NAMA" placeholder="Yudisium">
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>Tanggal Yudisium</label>
  <div class="col-sm-9" required>
    <input type="date" class="form-control" id="TGL_YUDISIUM" name="NAMA">
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label">Status</label>
  <div class="col-sm-9">
    <select class="form-control" id="STATUS_JADWAL_YUDISIUM" name="NAME" required>
      <option value="" selected="selected" >Pilih Status</option>
      <option value="2" name="TampilkanAktif" id="TampilkanAktif">Tampilkan dan Aktif</option>
      <option value="1" name="Tampilkan" id="Tampilkan">Tampilkan</option>
      <option value="0" name="Sembunyikan" id="Sembunyikan">Sembunyikan</option>
    </select>
  </div>
</div>



</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save2" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
