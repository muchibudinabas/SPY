@extends('templateakademik')
@section('content')
<section class="content-header">
          <h1>
            Detail Mahasiswa
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

            <!-- form start -->
              @foreach ($data as $dataa)
            <div class="box-body">
              <center><h3>Biodata Mahasiswa</h3></center>
              <hr>

              <div class="col-md-1"></div>
              <div class="col-md-10">
              <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">DATA MAHASISWA</th>
                    </tr>

                  </thead>

                  <tr class="bg-info">
                    <th width="33%">NIM</th>
                    <th width="0%">:</th>
                    <th width="67%">{{ $dataa->NIM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>NAMA</th>
                    <th>:</th>
                    <th>{{ $dataa->NAMA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Program Studi</th>
                    <th>:</th>
                    <th>{{ $dataa->UNIT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <center><th>Tgl. Terdaftar Pertama Kali</th></center>
                    <th>:</th>
                    <th>{{ indonesiaDate($dataa->TGL_TERDAFTAR) }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tgl. Lulus</th>
                    <th>:</th>
                    <th>{{ indonesiaDate($dataa->TGL_LULUS) }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>No. Ijazah</th>
                    <th>:</th>
                    <th>{{ $dataa->NO_IJAZAH }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>IPK</th>
                    <th>:</th>
                    <th>{{ $dataa->IPK }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>SKS</th>
                    <th>:</th>
                    <th>{{ $dataa->SKS }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Skor ELPT</th>
                    <th>:</th>
                    <th>{{ $dataa->ELPT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>SKP</th>
                    <th>:</th>
                    @if ($dataa->SKP == null)
                    <th ><span class="label label-warning">Belum diinput</span></th>
                    @endif
                    @if ($dataa->SKP != null)
                    <th >{{ $dataa->SKP }}</th>
                    @endif
                  </tr>
                  <tr class="bg-info">
                    <th>Bidang Ilmu</th>
                    <th>:</th>
                    <th>{{ $dataa->BIDANG_ILMU }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Judul Skripsi/Tesis/Desertasi</th>
                    <th>:</th>
                    <th>{{ $dataa->JUDUL_SKRIPSI }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Dosen Pembimbing 1</th>
                    <th>:</th>
                    <th>{{ $dataa->DOSEN_PEMBIMBING_1 }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Dosen Pembimbing 2</th>
                    <th>:</th>
                    <th>{{ $dataa->DOSEN_PEMBIMBING_2 }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tempat Tanggal Lahir</th>
                    <th>:</th>
                    <th>{{ $dataa->TEMPAT_LAHIR }}, {{ indonesiaDate($dataa->TANGGAL_LAHIR) }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Agama</th>
                    <th>:</th>
                    <th>{{ $dataa->AGAMA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Jenis Kelamin</th>
                    <th>:</th>
                    @if ($dataa->JENIS_KELAMIN == 1)
                    <th >Laki-laki</th>
                    @endif
                    @if ($dataa->JENIS_KELAMIN == 2)
                    <th >Perempuan</th>
                    @endif
                  </tr>
                  <tr class="bg-info">
                    <th>Alamat</th>
                    <th>:</th>
                    <th>{{ $dataa->ALAMAT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Telpon/Handphone</th>
                    <th>:</th>
                    <th>{{ $dataa->TELPON }}</th>
                  </tr>

                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">DATA ORANG TUA</th>
                    </tr>
                  </thead>
                  <tr class="bg-info">
                    <th>Nama Orang Tua</th>
                    <th>:</th>
                    <th>{{ $dataa->NAMA_ORTU }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Alamat Orang Tua</th>
                    <th>:</th>
                    <th>{{ $dataa->ALAMAT_ORTU }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Telpon/Handphone Orang Tua</th>
                    <th>:</th>
                    <th>{{ $dataa->TELPON_ORTU }}</th>
                  </tr>
                  
                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">FILE YUDISIUM</th>
                    </tr>
                  </thead>
                  @foreach ($data2 as $dataa2)
                  <tr class="bg-info">
                    <th>{{ $dataa2->KETERANGAN }}</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa2->FILE_ALUMNI.'') }}" target="_blank">{{ $dataa2->FILE_ALUMNI }}</th>
                  </tr>
                  @endforeach

                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">Lainnya</th>
                    </tr>
                  </thead>
                  <tr class="bg-info">
                    <th>Periode Yudisium</th>
                    <th>:</th>
                    <th>{{ $dataa->YUDISIUM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tanggal Yudisium</th>
                    <th>:</th>
                    <th>{{ indonesiaDate($dataa->TGL_YUDISIUM) }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tanggal Wisuda</th>
                    <th>:</th>
                    <th>{{ indonesiaDate($dataa->TGL_WISUDA) }}</th>
                  </tr>

                </table>
              @endforeach
              </div>
              <a style="text-align:center" class="btn btn-success btn-lg btn-block" style="border: 1px solid #55acee; text-align:center;" href="{{ url('printformdatalulusan') }}" target="_blank">Print Form Data Lulusan</a>
              <br>
             
                <div class="table-responsive">

                  <table class="table table-striped table-bordered" style="size:5px">
                    <th colspan="4">System Logs</th>
                    
                    <tr>
                      <th width="25%"><font size="1">NIP</font></th>
                      <th width="25%"><font size="1">NAMA PEGAWAI</font></th>
                      <th width="25%"><font size="1">JABATAN</font></th>
                      <th width="25%"><font size="1">TANGGAL VERIFIKASI</font></th>
                    </tr>
                    @foreach ($verifikasi as $dataa)
                    <tr>
                      <td width="25%"><font size="2">{{$dataa->NIP}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->NAMA_PEGAWAI}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->JABATAN}}</font></td>
                      <td width="25%"><font size="2">{{$dataa->TGL_DETAIL_VERIFIKASI}}</font></td>
                    </tr>
                    @endforeach
                    <tr>
                    @foreach ($data as $dataa)
                      <td colspan="4"><font size="2">Mahasiswa mendaftar yudisium pada tanggal {{$dataa->TGL_DAFTAR_YUDISIUM}}</font></td>
                    @endforeach
                    </tr>
                  </table>
                </div>
              </div>

              <div class="col-md-1"></div>


            </div><!-- /.box-body -->
            <div class="box-footer">
            <!-- Footer -->
            </div>
          </div><!-- /.box -->

        </section><!-- /.content -->

@endsection