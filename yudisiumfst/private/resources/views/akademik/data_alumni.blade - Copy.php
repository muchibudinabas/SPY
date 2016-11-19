<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templateakademik')
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

            
              
              <div class="box box-success">
                <div class="box-header">
                  <!-- <h3 class="box-title">Input SKP</h3> -->
                    
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-2">
                      
                      <div class="form-group">
                        <label for="periode">Periode Wisuda</label>
                        <select class="form-control" id="periode" name="periode" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                          <option value="">---</option>
                          <option value="{{url('datawisudawanak')}}" >All</option>
                          @foreach($pw as $pww)
                          <option value="{{url('datawisudawanak/'.$pww->ID_PERIODE_WISUDA)}}"s>{{indonesiaDate($pww->TGL_WISUDA)}}</option>
                          @endforeach

                        </select>  
                      </div>


                    </div>
                    <div class="col-xs-6">
                    </div>
                    <div class="col-xs-4">
                    </div>
                  </div>


                    <div class="alert alert-info infooo" style="display:none;">
                        <p></p>
                    </div>

                    <div class="alert alert-info notifoke" style="display:none;">
                        <p></p>
                    </div>

                  <div style="overflow-x:auto;">

                  <table id="example1" class="table table-bordered table-striped" >
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
                        <!-- <td>{{ $persons->NAMA }}</td> -->
                        <!-- <td ><a href="{{ url('detail_mhs') }}/{{ $persons->NIM }}" id="nama-{{ $persons->NIM }}">{{ $persons->NAMA}}</td> -->
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

                  <div class="form-group">
                    <label for="periode2">Periode Wisuda</label>
                    <select name="artist_1" id="artist">
                    @foreach($pw as $pww)
                        <option id="opti" value="{{$pww->ID_PERIODE_WISUDA}}">{{indonesiaDate($pww->TGL_WISUDA)}}</option>
                    @endforeach
                    </select>
                  </div>

                  <div id="newdata">@include('akademik.detailsalumni')</div>
                  
                  </div>
                  <br>
                  <form method="GET" action ="{{ url('exportexcel') }}">  
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

<script type="text/javascript">
  $(document).ready(function() { 
    $(document).on('click', '.option', function() { 
      $.ajax({
        // the route you're requesting should return view('page_details') with the required variables for that view
        url: '/hehehe/heh/' + $(this).attr('periode2'),
        type: 'get'
      }).done(response) { 
        $('div#results').html(response);
      }
    });
  });
</script>
<script type="text/javascript">
  $('#artist').change(function(data){
    $.ajax({
        // url: "datawisudawanak/20162",
        // data: $("#artist").val(),
        url: 'datawisudawanak/'+$("#artist").val(),
        dataType:"html",
        type: "get",
        success: function(data){
           $('#newdata').empty().append(data);
        }
    });
});
</script>
<script type="text/javascript">
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
@endsection