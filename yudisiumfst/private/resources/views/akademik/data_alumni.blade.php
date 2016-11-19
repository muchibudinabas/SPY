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


              <div class="row">
                <div class="col-xs-3">

                  <div class="form-group">
                    <!-- <p>Periode Wisuda</p> -->
                    <label for="periode2">Periode Wisuda</label>
                    <select id="artist" name="artist_1">
                      <option value="1">All Periode</option>
                      @foreach($pw as $pww)
                      <option id="opsi-{{$pww->ID_PERIODE_WISUDA}}" value="{{$pww->ID_PERIODE_WISUDA}}">{{indonesiaDate($pww->TGL_WISUDA)}}</option>
                      @endforeach
                    </select>  
                  </div>
                
                </div>
                <div class="col-xs-9">
                </div>
              </div>

              <div class="box box-default" id="newdata">
                @include('akademik.detailsalumni')
              </div>



            </div><!-- /.box-body -->
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