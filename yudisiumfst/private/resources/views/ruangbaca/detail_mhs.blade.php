@extends('templeteakademikbaru')
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
            <div class="box-body">
              <center><h3>Biodata Mahasiswa</h3></center>
              <br>

              <div class="col-md-1"></div>
              <div class="col-md-10">
              @foreach ($data as $dataa)
                <table class="table table-striped">
                  <thead class="thead-default">
                    <tr class="bg-blue">
                      <th colspan="3">DATA MAHASISWA</th>
                    </tr>

                  </thead>

                  <tr class="bg-info">
                    <th>NIM</th>
                    <th>:</th>
                    <th>{{ $dataa->NIM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>NAMA</th>
                    <th>:</th>
                    <th>{{ $dataa->NAMA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Program Studi</th>
                    <th>:</th>
                    <th>{{ $dataa->PRODI }}</th>
                  </tr>
                  <tr class="bg-info">
                    <center><th>Tgl. Terdaftar Pertama Kali</th></center>
                    <th>:</th>
                    <th>{{ $dataa->TGL_TERDAFTAR }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tgl. Lulus</th>
                    <th>:</th>
                    <th>{{ $dataa->TGL_LULUS }}</th>
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
                    <th>{{ $dataa->SKP }}</th>
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
                    <th>{{ $dataa->TEMPAT_LAHIR }}{{ $dataa->TANGGAL_LAHIR }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Agama</th>
                    <th>:</th>
                    <th>{{ $dataa->AGAMA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Jenis Kelamin</th>
                    <th>:</th>
                    <th>{{ $dataa->JENIS_KELAMIN }}</th>
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
                  <tr class="bg-info">
                    <th>Bukti Pembayaran SOP Terakhir</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->SOP.'') }}" target="_blank">{{ $dataa->SOP }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Surat Bebas Pinjam Buku Ruang Baca Fakultas</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->BUKU_FAK.'') }}" target="_blank">{{ $dataa->BUKU_FAK }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Surat Bebas Pinjam Alat</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->PINJAM_ALAT.'') }}" target="_blank">{{ $dataa->PINJAM_ALAT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Surat Bebas Pinjam Buku Perpustakaan UA</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->BUKU_UA.'') }}" target="_blank">{{ $dataa->BUKU_UA }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>ELPT</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->FILE_ELPT.'') }}" target="_blank">{{ $dataa->FILE_ELPT }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Tanda Bukti Hardcover Skripsi</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->HARDCOVER_SKRIPSI.'') }}" target="_blank">{{ $dataa->HARDCOVER_SKRIPSI }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Fotocopy Ijazah Terakhir</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->IJAZAH_TERAKHIR.'') }}" target="_blank">{{ $dataa->IJAZAH_TERAKHIR }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>Surat Keterangan Telah Foto Dari Rektorat</th>
                    <th>:</th>
                    <th><a href="{{ url('private/uploads/files/'.$dataa->FOTO_REKTORAT.'') }}" target="_blank">{{ $dataa->FOTO_REKTORAT }}</th>
                  </tr>

                </table>
              @endforeach
                <br>
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