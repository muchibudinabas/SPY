<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('baru2')
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
            <div class="box-body">
              <center><h3>Biodata Mahasiswa</h3></center>
              <hr>


              <div class="col-md-1"></div>
              <div class="col-md-10">

              <div class="box-body">
                <span class="error" style="color:blue;">
                <?php if(Session::has('register_success')): ?>
                  <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                    <?php echo Session::get('register_success') ?>
                  </div>
                <?php endif; ?>
              </span>

              <div id="showmenumhs">
                <table class="table table-striped table-bordered">
                    <thead class="thead-default">
                      <tr class="bg-blue">
                        <th colspan="3"> BIODATA MAHASISWA </th>
                      </tr>
                    </thead>
                </table>
              </div>
                        
              <div class="menumhs" style="display: none; margin-top: -20px;">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                @foreach ($data as $dataa)
                  <tr class="bg-info">
                    <th width="33%">NIM</th>
                    <th width="0%">:</th>
                    <th width="67%" id="nim-{{ $dataa->NIM }}">{{ $dataa->NIM }}</th>
                  </tr>
                  <tr class="bg-info">
                    <th>NAMA</th>
                    <th>:</th>
                    <th id="nama-{{ $dataa->NIM }}">{{ $dataa->NAMA }}</th>
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
                @endforeach
                </table>
              </div>
              </div>

              <div id="showmenu">
                <table class="table table-striped table-bordered">
                    <thead class="thead-default">
                      <tr class="bg-blue">
                        <th colspan="3">DATA ORANG TUA</th>
                      </tr>
                    </thead>
                </table>
              </div>
                        
              <div class="menu" style="display: none; margin-top: -20px;">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                @foreach ($data as $dataa)
                  <tr class="bg-info">
                    <th width="33%">Nama Orang Tua</th>
                    <th width="0%">:</th>
                    <th width="67%">{{ $dataa->NAMA_ORTU }}</th>
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
                @endforeach
                </table>
                </div>
              </div>

              <div id="showmenufile">
                <table class="table table-striped table-bordered">
                    <thead class="thead-default">
                      <tr class="bg-blue">
                        <th colspan="3">FILE YUDISIUM</th>
                      </tr>
                    </thead>
                </table>
              </div>
                        
              <div class="menufile" style="display: none; margin-top: -20px;">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  @foreach ($data2 as $dataa2)
                  <tr class="bg-info">
                    <th width="33%">{{ $dataa2->KETERANGAN }}</th>
                    <th width="0%">:</th>
                    <th width="67%"><a href="{{ url('private/uploads/files/'.$dataa2->FILE_ALUMNI.'') }}" target="_blank">{{ $dataa2->FILE_ALUMNI }}</th>
                  </tr>
                  @endforeach
                </table>
                </div>
              </div>

              <div id="showmenu1">
                <table class="table table-striped table-bordered">
                    <thead class="thead-default">
                      <tr class="bg-blue">
                        <th colspan="3">Lainnya</th>
                      </tr>
                    </thead>
                </table>
              </div>
                        
              <div class="menu1" style="display: none; margin-top: -20px;">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                @foreach ($data as $dataa)
                  <tr class="bg-info">
                    <th width="33%">Periode Yudisium</th>
                    <th width="0%">:</th>
                    <th width="67%">{{ $dataa->YUDISIUM }}</th>
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
                @endforeach
                </table>
                </div>
              </div>

              <!-- </div> -->
              @foreach ($data as $dataa)
              @if ($dataa->VERIFIKASI == 1)
              <a class="btn btn-primary btn-lg btn-block" href="{{ url('printformdatalulusan') }}" target="_blank">Print Form Data Lulusan</a>
              <a class="btn btn-default btn-lg btn-block" href="{{ url('onprocess') }}">Back</a>
              @endif
              @if ($dataa->VERIFIKASI == 0)
              <button class="btn btn-success btn-lg btn-block open-modal" id="open-modal"> Approve </button>
              <button class="btn btn-danger btn-lg btn-block open-cancel" id="open-cancel"> Cancel </button>
              <a class="btn btn-default btn-lg btn-block" href="{{ url('onprocess') }}">Back</a>
              @endif
              @endforeach
               <br>
                <div class="table-responsive">

                  <table class="table table-striped table-bordered" style="size:5px">
                    <th colspan="4">System Logs</th>
                    @foreach ($verifikasi as $dataa)
                    @if ($dataa->NIP == null)
                    @endif
                    @if ($dataa->NIP != null)
                    <tr>
                      <th width="25%"><font size="1">NIP</font></th>
                      <th width="25%"><font size="1">NAMA PEGAWAI</font></th>
                      <th width="25%"><font size="1">JABATAN</font></th>
                      <th width="25%"><font size="1">TANGGAL VERIFIKASI</font></th>
                    </tr>
                    @endif
                    @endforeach

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

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Approve Pendaftaran</h4>
                        </div>
                        <div class="modal-body">
                          @foreach ($data as $dataa)
                        <form role="form" id="footer-form" method="POST" action="{{ url('approvePendaftaran',$dataa->NIM) }}">
                        {!! csrf_field() !!}

                          <p>Apakah anda yakin akan mengapprove data <big style="color:#339BEB;">{{ $dataa->NAMA }}</big> dengan NIM <big style="color:#339BEB;"> {{ $dataa->NIM }} </big> ?</p>
                          @endforeach

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success"> Approve </button>
                        </div>
                        </form>
                    </div>
                  </div>
                </div>
                <!-- Modal -->

                <!-- Modal -->
                <div id="myModalCancel" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cancel Pendaftaran</h4>
                        </div>
                        <div class="modal-body">
                          @foreach ($data as $dataa)
                          <p>Apakah anda yakin akan mengcancel data <big style="color:#339BEB;">{{ $dataa->NAMA }}</big> dengan NIM <big style="color:#339BEB;"> {{ $dataa->NIM }} </big> ?</p>
                          @endforeach

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-danger"> Cancel </button>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->

              </div>
              <div class="col-md-1"></div>


            </div><!-- /.box-body -->
          </div><!-- /.box -->

        </section><!-- /.content -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>

<script type="text/javascript">
  
$(document).ready(function(){

    $('.open-modal').click(function(){
            $('#myModal').modal('show');
    });

    $('.open-cancel').click(function(){
            $('#myModalCancel').modal('show');
    });

});

</script>
@endsection