
<div class="alert alert-warning infoo" style="display:none;">
    <ul></ul>
    <!-- <li></li> -->
</div>

<div class="form-group">
  <div class="col-sm-9">
  </div>
</div>
    <input type="hidden" id="ID_FILE" name="NAMA">

<div class="form-group">
  <label class="col-sm-3 control-label">Tanggal Yudisium</label>
  <div class="col-sm-9">
    @foreach($jy as $jyy)
    <input type="hidden" class="form-control" id="ID_JADWAL_YUDISIUM" name="NAMA" value="{{$jyy->ID_JADWAL_YUDISIUM}}">
    <input disabled class="form-control" placeholder="{{indonesiaDate($jyy->TGL_YUDISIUM)}}">
    @endforeach
  </div>
</div>


 <div class="form-group">
  <label class="col-sm-3 control-label">Nama File</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NAMA_FILE" name="NAMA" placeholder="Nama File">
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>Inisial File</label>
  <div class="col-sm-9" required>
    <input type="text" class="form-control" id="INISIAL" name="NAMA" placeholder="Inisial File">
    <!-- <textarea class="form-control" id="TANGGAL_YUDISIUM" name="NAMA" placeholder="Deskripsi" required></textarea> -->
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label">Status</label>
  <div class="col-sm-9">
    <select class="form-control " name="STATUS" id="STATUS" required>
      <option value="1" name="Tampilkan" id="Tampilkan">Tampilkan</option>
      <option value="2" name="Sembunyikan" id="Sembunyikan">Sembunyikan</option>
    </select>
  </div>
</div>



<!-- <div class="form-group">
    <label class="col-md-4 control-label">NIM</label>
    <div class="col-md-8">
        {!! Form::text('NIM', null, ['class' => 'form-control', 'id' => 'NIM']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">NAMA</label>
    <div class="col-md-8">
        {!! Form::text('NAMA', null, ['class' => 'form-control', 'id' => 'NAMA']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">PRODI</label>
    <div class="col-md-8">
        {!! Form::text('NAMA', null, ['class' => 'form-control', 'id' => 'PRODI']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">JENIS KELAMIN</label>
    <div class="col-md-8">
        {!! Form::text('NAMA', null, ['class' => 'form-control', 'id' => 'JENIS_KELAMIN']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">SKP</label>
    <div class="col-md-8">
        {!! Form::text('NAMA', null, ['class' => 'form-control', 'id' => 'SKP']) !!}
    </div>
</div>
 -->


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save3" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
