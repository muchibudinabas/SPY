<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('baru2')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            On Process
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

                    <div class="alert alert-info infooo" style="display:none;">
                        <p></p>
                    </div>

                    <div class="alert alert-info notifoke" style="display:none;">
                        <p></p>
                    </div>

                    <span class="error" style="color:blue;">
                        <?php if(Session::has('register_success')): ?>
                          <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                            <?php echo Session::get('register_success') ?>
                          </div>
                        <?php endif; ?>
                    </span>
                    
                <!-- <div style="overflow-x:auto;"> -->
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th width="0%">NIM</th>
                        <th width="25%">NAMA</th>
                        <th width="15%">PRODI</th>
                        <th width="0%">JENIS KELAMIN</th>
                        <th width="20%">TGL LULUS</th>
                        <th width="25%">NO IJAZAH</th>
                        <th width="0%">SKP</th>
                        <th width="0%">STATUS</th>
                        <th width="0%">NO IJAZAH</th>

                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->NIM }}">

                        <td>{{ $persons->NIM }}</td>
                        <td><a id="nama-{{ $persons->NIM }}" href="{{ url('mhs_onprocess') }}/{{ $persons->NIM }}">{{ $persons->NAMA}}</td>
                        <td>{{ $persons->UNIT }}</td>
                        @if ($persons->JENIS_KELAMIN == 1)
                        <td >Laki-laki</td>
                        @endif
                        @if ($persons->JENIS_KELAMIN == 2)
                        <td >Perempuan</td>
                        @endif
                        <td>{{ indonesiaDate($persons->TGL_LULUS) }}</td>             
                        <td>{{ $persons->NO_IJAZAH }}</td>
                        <td>{{ $persons->SKP }}</td>
                        <td>@if ($persons->VERIFIKASI == 1)
                        <span class="label label-success">Approved</span>
                        @endif
                        @if ($persons->VERIFIKASI == 0)
                        <span class="label label-warning">Belum diapprove</span>
                        @endif</td>


                        <td>@if (is_null($persons->NO_IJAZAH))
                        <span class="label label-warning">Belum diinput</span><br>
                        @else
                        <span class="label label-success">Sudah diinput</span><br>
                        @endif
                        @if ($persons->VERIFIKASI_AK == 0)
                        <span class="label label-warning">Belum diverifikasi</span>
                        @endif
                        @if ($persons->VERIFIKASI_AK == 1)
                        <span class="label label-success">Sudah diverifikasi</span>
                        @endif
                        </td>
                                       
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <!-- <br> -->
                </div>

                  <form method="GET" action ="{{ url('exportexceldataalumniprodionprocess') }}">
                  <br>  
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
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

@endsection