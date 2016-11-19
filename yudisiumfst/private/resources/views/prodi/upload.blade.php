<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('baru2')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Upload File
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
                    @foreach ($detail_file as $dataa)
                <form class="form-horizontal" method="POST" action="{{ url('upload') }}/{{ $dataa->NIM }}/{{ $dataa->ID_FILE }}" accept-charset="UTF-8"
                        enctype="multipart/form-data">
                            {!! csrf_field() !!}

                  <div class="box-body">

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">NIM</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NIM" name="NIM" value="{{$dataa->NIM}}" placeholder="NIM" disabled="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NAMA" name="NAMA" value="{{$dataa->NAMA}}" placeholder="NAMA" disabled="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">File Yudisium</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="KETERANGAN" name="KETERANGAN" value="{{$dataa->KETERANGAN}}" placeholder="KETERANGAN" disabled="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">File input</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" id="fileyudisium" name="fileyudisium" accept="application/pdf" required="">
                      </div>
                    </div>


                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('detail_mhs') }}/{{ $dataa->NIM }}" class="btn btn-default">Cancel</a>
                    @endforeach
                    <button type="submit" class="btn btn-success pull-right" >Upload</button>
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