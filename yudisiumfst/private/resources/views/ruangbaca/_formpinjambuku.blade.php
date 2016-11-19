
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
    <input type="text" class="form-control" id="NIM_PEMINJAM" name="NIM_PEMINJAM" placeholder="NIM">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Jenis Pinjam</label>
  <div class="col-sm-9">
    <select class="form-control " name="ID_JENIS_PINJAM" id="ID_JENIS_PINJAM" value="<?php echo Form::old('jp') ?>" required>
    <option value="" selected="selected" > --- </option>
      @foreach($jenispinjam as $jp)
      <option value="{{$jp->ID_JENIS_PINJAM}}" {{ (Input::old("jp") == $jp->ID_JENIS_PINJAM ? "selected":"") }}>{{$jp->JENIS_PINJAM}}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">No. Klas</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="NO_KLAS" name="NO_KLAS" placeholder="No. Klas">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Pengarang</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="PENGARANG" name="PENGARANG" placeholder="Pengarang">
    <!-- <textarea type="text" class="form-control" id="PENGARANG" name="PENGARANG" placeholder="Pengarang"></textarea> -->
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Judul</label>
  <div class="col-sm-9">
    <!-- <input type="text" class="form-control" id="JUDUL" name="JUDUL" placeholder="JUDUL"> -->
    <textarea type="text" class="form-control" id="JUDUL" name="JUDUL" placeholder="Judul"></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Koleksi</label>
  <div class="col-sm-9">
    <select class="form-control " name="ID_JENIS_KOLEKSI" id="ID_JENIS_KOLEKSI" value="<?php echo Form::old('ID_JENIS_KOLEKSI') ?>" required>
    <option value="" selected="selected" > --- </option>
      @foreach($koleksi as $koleksii)
      <option value="{{$koleksii->ID_JENIS_KOLEKSI}}" {{ (Input::old("ID_JENIS_KOLEKSI") == $koleksii->ID_JENIS_KOLEKSI ? "selected":"") }}>{{$koleksii->JENIS_KOLEKSI}}</option>
      @endforeach
    </select>
  </div>
</div>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button class="btn btn-primary save" type="button" value="add">Save</button>
    <input id="NIM" name="id" type="hidden">
</div>
