
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

<input type="hidden" class="form-control" id="JENIS_KELAMIN" name="JENIS_KELAMIN">

<div class="form-group">
  <label class="col-sm-3 control-label">Prodi</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="UNIT" name="NAMA" disabled="">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Tanggal Lulus</label>
  <div class="col-sm-9">
    <input type="date" class="form-control" id="TGL_LULUS" name="NAMA">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">No Ijazah</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NO_IJAZAH" name="NAMA" placeholder="No Ijazah">
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>IPK</label>
  <div class="col-sm-9" required>
    <input type="text" class="form-control" id="IPK" name="NAMA" placeholder="IPK" required>
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>SKS</label>
  <div class="col-sm-9" required>
    <input type="text" class="form-control" id="SKS" name="NAMA" placeholder="SKS" required>
  </div>
</div>
<div class="form-group" required>
  <label class="col-sm-3 control-label" required>ELPT</label>
  <div class="col-sm-9" required>
    <input type="text" class="form-control" id="ELPT" name="NAMA" placeholder="ELPT" required>
  </div>
</div>
    
<!-- <input type="hidden" class="form-control" id="SKP" name="SKP"> -->

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
    <button class="btn btn-primary save" type="submit" value="add">Save</button>
    <!-- <button class="btn btn-primary save2" type="submit" value="add2">Save</button> -->
    <!-- <input  class="btn btn-primary save" type="submit" value="add"> -->
    <input id="NIM" name="id" type="hidden">
</div>
