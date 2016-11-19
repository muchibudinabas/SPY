<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('baru2')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Data Wisudawan
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
            
              
              <div class="box box-info">
                <div class="box-header">
                  <!-- <h3 class="box-title">Input SKP</h3> -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="alert alert-info infooo" style="display:none;">
                        <p></p>
                    </div>

                    <div class="alert alert-info notifoke" style="display:none;">
                        <p></p>
                    </div>

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-info">
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>JENIS KELAMIN</th>
                        <th>TGL LULUS</th>
                        <th>PRODI</th>
                        <th>NO IJAZAH</th>
                        <th>IPK</th>
                        <th>SKS</th>
                        <th>ELPT</th>
                        <th>SKP</th>
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->NIM }}">

                        <td>{{ $persons->NIM }}</td>
                        <td><a id="nama-{{ $persons->NIM }}" href="{{ url('detail_mhs') }}/{{ $persons->NIM }}">{{ $persons->NAMA}}</td>
                        @if ($persons->JENIS_KELAMIN == 1)
                        <td >Laki-laki</td>
                        @endif
                        @if ($persons->JENIS_KELAMIN == 2)
                        <td >Perempuan</td>
                        @endif
                        <td>{{ indonesiaDate($persons->TGL_LULUS) }}</td>             
                        <td>{{ $persons->UNIT }}</td>
                        <td>{{ $persons->NO_IJAZAH }}</td>
                        <td>{{ $persons->IPK }}</td>
                        <td>{{ $persons->SKS }}</td>
                        <td>{{ $persons->ELPT }}</td>
                        <td>{{ $persons->SKP }}</td>
                                       
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <br>
                  <form method="GET" action ="{{ url('exportexceldataalumniprodi') }}">  
                    <button type="submit" class="btn btn-warning pull-left">Export to excel</button>
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
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

@endsection