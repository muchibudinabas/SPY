<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templateakademik')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Penyimpanan File
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
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('penyimpananfile') }}" accept-charset="UTF-8"
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
                      <label for="" class="col-sm-3 control-label" style="float:left; text-align: left; ">Penyimpanan File</label>
                      <div class="col-sm-9">
                        <select class="form-control " name="ID_CLOUD" id="ID_CLOUD" value="<?php echo Form::old('ID_CLOUD') ?>" required>
                          @foreach($cloud as $agamaa)
                          <option value="{{$agamaa->ID_CLOUD}}" {{ ($cloudaktif == $agamaa->ID_CLOUD ? "selected":"") }}>{{$agamaa->CLOUD_STORAGE}}</option>
                          @endforeach
                        </select> 
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right" >Select</button>
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