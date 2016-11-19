<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templetekemahasiswaanbaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Input SKP
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
                <form class="form-horizontal" method="POST" action="{{ url('inputskp') }}" accept-charset="UTF-8"
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
                    <?php if(Session::has('register_success')): ?>
                      <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('register_success') ?>
                      </div>
                    <?php endif; ?>
                  </span>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">NIM</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NIM" name="NIM" value="<?php echo Form::old('NIM') ?>" placeholder="NIM" required="" pattern="[0-9]+" minlength="11" maxlength="12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NAMA" name="NAMA" value="<?php echo Form::old('NAMA') ?>" placeholder="Nama" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Prodi</label>
                      <div class="col-sm-10">
                        <select class="form-control " name="ID_PRODI" id="ID_PRODI" value="<?php echo Form::old('prodi') ?>" required>
                        <option value="" selected="selected" >Prodi</option>
                          @foreach($prodi as $prodii)
                          <option value="{{$prodii->ID_UNIT}}" {{ (Input::old("ID_PRODI") == $prodii->ID_UNIT ? "selected":"") }}>{{$prodii->UNIT}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">SKP</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="SKP" name="SKP" value="<?php echo Form::old('SKP') ?>" placeholder="SKP" pattern="[0-9]+" required="">
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