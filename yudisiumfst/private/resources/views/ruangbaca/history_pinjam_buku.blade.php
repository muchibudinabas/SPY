<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templeteruangbacabaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Histori Pinjam Buku
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
            <div class="col-xs-12">
            
              
              <div class="box box-default">
                <div class="box-header">
                  <!-- <h3 class="box-title">Input SKP</h3> -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <!-- <button class="btn-success btn-sm" id="btn-add"><i class="fa fa-plus-circle"></i> Add</button><br/><br/> -->
                    
                    <div class="alert alert-success infooo" style="display:none;">
                        <p></p>
                    </div>

                    <div class="alert alert-success notifoke" style="display:none;">
                        <p></p>
                    </div>

                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th width="0%">NIM</th>
                        <th width="30%">NAMA</th>
                        <th width="0%">PRODI</th>
                        <th width="30%">NO KLAS</th>
                        <th width="40%">PENGARANG & JUDUL</th>
                        <!-- <th>JUDUL</th> -->
                        <th width="0%">KOLEKSI</th>
                        <th width="0%">JENIS PINJAM</th>

                        <th width="0%">TGL PINJAM</th>
                        <th width="0%">TGL KEMBALI</th>

                        <!-- <th>Actions</th> -->
                        <!-- <th colspan="2">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->ID_PINJAM_BUKU }}">

                        <td>{{ $persons->NIM_ANGGOTA }}</td>
                        <td id="nama-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->NAMA_ANGGOTA}}</td>
                        <!-- <td>{{ $persons->NAMA }}</td> -->
                        <!-- <td ><a href="{{ url('detail_mhs') }}/{{ $persons->NIM }}" id="nama-{{ $persons->NIM }}">{{ $persons->NAMA}}</td> -->
                        <td>{{ $persons->UNIT }}</td>
                        <td>{{ $persons->NO_KLAS }}</td>
                        <td id="judul-{{ $persons->ID_PINJAM_BUKU }}"><a href="{{ url('detail_pinjam') }}/{{ $persons->NIM_ANGGOTA }}/{{ $persons->ID_PINJAM_BUKU }}" id="judul-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->PENGARANG }}, {{ $persons->JUDUL }}</td>
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
                        <td>{{ dateDMY($persons->TGL_KEMBALI) }}</td>
                        <!-- <td>{{ $persons->NO_KLAS }}</td> -->
                        
                        
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <br>
                  <form method="GET" action ="{{ url('exportexcelhistorypinjambuku') }}">  
                    <button type="submit" class="btn btn-success pull-left">Export to excel</button>
                  </form>



  </div><!-- /.box-body -->
            <!-- <div class="box-footer"> -->
            <!-- Footer -->
            <!-- </div> /.box-footer -->
          </div><!-- /.box -->

        </section><!-- /.content -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>

<script type="text/javascript">
 

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

@endsection