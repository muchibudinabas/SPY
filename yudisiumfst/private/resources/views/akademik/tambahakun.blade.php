<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templateakademik')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Tambah Akun
            <!-- <small>Fakultas Sains Teknologi</small> -->
          </h1>
          <ol class="breadcrumb"> 
            <li> 
              <i class="fa fa-home"></i> 
              <a href="{{url('home')}}">Home</a> 
              <i class=""></i> 
            </li> <?php $link = url('home'); ?> @for($i = 1; $i <= count(Request::segments()); $i++) 
            <li> @if($i < count(Request::segments()) & $i > 0) <?php $link .= "/" . Request::segment($i); ?> 
              <a href="<?= $link ?>">{{Request::segment($i)}}</a> {!!'
              <i class=""></i>'!!} @else {{Request::segment($i)}} @endif 
            </li> 
            @endfor 
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              


              <!-- Horizontal Form -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('tambahakun') }}" accept-charset="UTF-8"
                        enctype="multipart/form-data">
                            {!! csrf_field() !!}

                  <div class="box-body">
                    <span class="error" style="color:blue;">
                    <?php if(Session::has('register_danger')): ?>
                      <div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('register_danger') ?>
                      </div>
                    <?php endif; ?>
                  </span>
                  <div class="box-body">
                    <span class="error" style="color:blue;">
                    <?php if(Session::has('register_warning')): ?>
                      <div class="alert alert-warning alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('register_warning') ?>
                      </div>
                    <?php endif; ?>
                  </span>
                  <div class="box-body">
                    <span class="error" style="color:blue;">
                    <?php if(Session::has('register_success')): ?>
                      <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('register_success') ?>
                      </div>
                    <?php endif; ?>
                  </span>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NIP" name="NIP" value="<?php echo Form::old('NIP') ?>" placeholder="NIP" required="" pattern="[0-9]+" maxlength="18">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NAMA" name="NAMA" value="<?php echo Form::old('NAMA') ?>" placeholder="Nama" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-10">
                        <select class="form-control " name="ID_JABATAN" id="ID_JABATAN" value="<?php echo Form::old('ID_JABATAN') ?>" required>
                        <option value="" selected="selected" >---</option>
                          @foreach($jabatan as $jabatann)
                          <option value="{{$jabatann->ID_JABATAN}}" {{ (Input::old("ID_JABATAN") == $jabatann->ID_JABATAN ? "selected":"") }}>{{$jabatann->JABATAN}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Unit</label>
                      <div class="col-sm-10">
                        <select class="form-control " name="ID_UNIT" id="ID_UNIT" value="<?php echo Form::old('ID_UNIT') ?>" required>
                        <option value="" selected="selected" {{ (Input::old("ID_UNIT") == 'ID_UNIT' ? "selected":"") }}>Unit</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="USERNAME" name="USERNAME" value="<?php echo Form::old('USERNAME') ?>" placeholder="Username" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" value="<?php echo Form::old('PASSWORD') ?>" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Aktivasi</label>
                      <div class="col-sm-10">
                        <select class="form-control " name="AKTIVASI" id="AKTIVASI" value="<?php echo Form::old('AKTIVASI') ?>" required>
                          <option value="" selected="selected" >---</option>
                          <option value="1" {{ (Input::old("AKTIVASI") == 1 ? "selected":"") }}>Aktif</option>
                          <option value="0" >Tidak Aktif</option>
                        </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-success pull-right" >Save</button>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->

              

            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-4">
            
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->

        
@endsection