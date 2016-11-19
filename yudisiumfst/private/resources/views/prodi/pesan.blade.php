<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('baru2')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Pesan
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
                    @foreach ($data as $dataa)
                <form class="form-horizontal" method="POST" action="{{ url('pesan') }}/{{ $dataa->NIM }}/{{ $dataa->ID_FILE }}" accept-charset="UTF-8"
                        enctype="multipart/form-data">
                            {!! csrf_field() !!}

                  <div class="box-body">

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Ke</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NAMAMHS" name="NAMAMHS" value="{{$namamhs}}" placeholder="NAMA" disabled="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Subjek</label>
                      <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="NIM" name="NIM" value="{{$dataa->NIM}}" placeholder="NIM">
                        <input type="hidden" class="form-control" id="ID_FILE" name="ID_FILE" value="{{$dataa->ID_FILE}}" placeholder="ID_FILE">
                        <input type="text" class="form-control" id="KETERANGAN" name="KETERANGAN" value="{{$dataa->KETERANGAN}}" placeholder="KETERANGAN" disabled="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Pesan</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="PESAN" name="PESAN" placeholder="{{$dataa->PESAN}}"  value="{{$dataa->PESAN}}" required=""></textarea>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('detail_mhs') }}/{{ $dataa->NIM }}" class="btn btn-default">Cancel</a>
                    @endforeach
                    <button type="submit" class="btn btn-success pull-right" >Send</button>
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