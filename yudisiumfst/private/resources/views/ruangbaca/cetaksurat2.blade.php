<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templeteruangbacabaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Cetak Surat Bebas Pinjam Buku
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
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('cetaksuratbebaspinjam') }}" accept-charset="UTF-8"
                        enctype="multipart/form-data">
                            {!! csrf_field() !!}

                  <div class="box-body">
                    <span class="error" style="color:blue;">
                      <div class="alert alert-warning alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <p><b>Oops...! </b> Mahasiswa masih mempunyai tanggungan peminjaman buku.</p>
                      </div>
                  </span>

                  <table class="table table-striped">
                      <tr class="bg-white">
                        <th width="20%">NIM</th>
                        <td width="80%">{{ $nim }}</td>
                      </tr>
                      <tr class="bg-white">
                        <th>NAMA</th>
                        <td>{{ $nama }}</td>
                      </tr>
                      <tr class="bg-white">
                        <th>PRODI</th>
                        <td>{{ $unit }}</td>
                      </tr>
                  </table>
                  <br>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>NO KLAS</th>
                        <th>PENGARANG & JUDUL</th>
                        <th>KOLEKSI</th>
                        <th>JENIS PINJAM</th>
                        <th>TGL PINJAM</th>
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($datapinjam as $persons)
                      <tr id="person{{ $persons->ID_PINJAM_BUKU }}">
                        <td>{{ $persons->NO_KLAS }}</td>
                        <td><a href="{{ url('detail_pinjam') }}/{{ $persons->NIM_ANGGOTA }}/{{ $persons->ID_PINJAM_BUKU }}" id="judul-{{ $persons->ID_PINJAM_BUKU }}" target="_blank">{{ $persons->PENGARANG }}, {{ $persons->JUDUL }}</td>
                        <td>{{ $persons->JENIS_KOLEKSI }}</td>
                        <td>@if ($persons->ID_JENIS_PINJAM == 1)
                        <span class="label label-warning">{{ $persons->JENIS_PINJAM }}</span>
                        @endif
                        @if ($persons->ID_JENIS_PINJAM == 2)
                        <span class="label label-primary">{{ $persons->JENIS_PINJAM }}</span>
                        @endif
                        @if ($persons->ID_JENIS_PINJAM == 3)
                        <span class="label label-danger">{{ $persons->JENIS_PINJAM }}</span>
                        @endif</td>
                        <td>{{ dateDMY($persons->TGL_PINJAM) }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <br>

                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">NIM</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="NIM" name="NIM" value="<?php echo Form::old('NIM') ?>" placeholder="NIM" pattern="[0-9]+" minlength="11" maxlength="12" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tglujian" class="col-sm-2 control-label">Tanggal Ujian</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="TANGGAL_UJIAN" name="TANGGAL_UJIAN" value="<?php echo Form::old('TANGGAL_UJIAN') ?>" required="">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right" target="_blank">Print</button>
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