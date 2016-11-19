@extends('templeteruangbacabaru')
@section('content')
<section class="content-header">
          <h1>
            <!-- Detail Pinjam -->
            <br>
            <!-- <small>Fakultas Sains Teknologi Universitas Airlangga</small> -->
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

          <!-- Default box -->
          <div class="box">
            <!-- <div class="box-header with-border"> -->
            <!-- <center><h3 class="box-title">Biodata Mahasiswa</h3></center> -->
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
            <!-- </div> -->
            <div class="box-body">
              <center><h3>Detail Pinjam</h3></center>
              <hr>
              <!-- <br> -->

              <div class="col-md-1"></div>
              <div class="col-md-10">
              @foreach ($data as $dataa)
                <table class="table ">
                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">DATA PEMINJAM</th>
                    </tr>

                  </thead>

                  <tr class="bg-info">
                    <th width="33%">NIM</th>
                    <th width="0%">:</th>
                    <th width="67%">{{ $dataa->NIM_ANGGOTA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Nama</th>
                    <th>:</th>
                    <th>{{ $dataa->NAMA_ANGGOTA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Prodi</th>
                    <th>:</th>
                    <th>{{ $dataa->UNIT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Alamat</th>
                    <th>:</th>
                    <th>{{ $dataa->ALAMAT_ANGGOTA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Telpon</th>
                    <th>:</th>
                    <th>{{ $dataa->TELPON_ANGGOTA }}</th>
                  </tr>

                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">DETAIL PINJAM</th>
                    </tr>
                  </thead>
                  <tr class="bg-info">
                    <th>Judul</th>
                    <th>:</th>
                    <th>{{ $dataa->JUDUL }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Pengarang</th>
                    <th>:</th>
                    <th>{{ $dataa->PENGARANG }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>No Klas</th>
                    <th>:</th>
                    <th>{{ $dataa->NO_KLAS }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Koleksi</th>
                    <th>:</th>
                    <th>{{ $dataa->JENIS_KOLEKSI }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Jenis Pinjam</th>
                    <th>:</th>
                    <th>{{ $dataa->JENIS_PINJAM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tanggal Pinjam</th>
                    <th>:</th>
                    <th>{{ $dataa->TGL_PINJAM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Status Pinjam</th>
                    <th>:</th>
                    @if ($dataa->STATUS_PINJAM == 0)
                    <th ><span class="label label-danger">Belum dikembalikan</span></th>
                    @endif
                    @if ($dataa->STATUS_PINJAM == 1)
                    <th ><span class="label label-success">Sudah dikembalikan</span></th>
                    @endif
                  </tr>
                  <tr class="bg-info">
                    <th>Tanggal Kembali</th>
                    <th>:</th>
                    <th>{{ $dataa->TGL_KEMBALI }}</th>
                  </tr>

                </table>
              @endforeach
                

                <br>
                <div class="table-responsive">

                  <table class="table table-striped table-bordered" style="size:5px">
                    <th colspan="4" >Log System</th>
                    <tr>
                      <th width="25%"><font size="1">NIP</font></th>
                      <th width="25%"><font size="1">NAMA PEGAWAI</font></th>
                      <th width="25%"><font size="1">JABATAN</font></th>
                      <th width="25%"><font size="1">KET</font></th>
                    </tr>
                    @foreach ($data as $dataa)
                    <tr>
                      <td width="25%"><font size="2">{{$dataa->NIP}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->NAMA_PEGAWAI}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->JABATAN}}</font></td>
                      <td width="25%"><font size="2">Pinjam</font></td>
                    </tr>
                    @endforeach
                    
                    @foreach ($data1 as $dataa)
                    <tr>
                      <td width="25%"><font size="2">{{$dataa->NIP}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->NAMA_PEGAWAI}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->JABATAN}}</font></td>
                      <td width="25%"><font size="2">Kembali</font></td>
                    </tr>
                    @endforeach
                  </table>
                </div>

                <br>
                <br>
              </div>
              <div class="col-md-1"></div>



            </div><!-- /.box-body -->
            <!-- <div class="box-footer"> -->
            <!-- Footer -->
            <!-- </div> /.box-footer -->
          </div><!-- /.box -->

        </section><!-- /.content -->

@endsection