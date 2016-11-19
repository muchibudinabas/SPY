<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templateakademik')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            File Yudisium
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
            
              
              <div class="box box-">
                <div class="box-header">
                  <!-- <h3 class="box-title">Input SKP</h3> -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    

                    <div class="row">  
                        <div class="col-xs-10">
                            <button class="btn btn-xs bg-green" id="btn-add3"><i class="fa fa-plus-circle"></i> Add</button>
                            <br>
                            <br>

                            <div class="alert alert-success infooo3" style="display:none;">
                                <p> </p>
                            </div>

                            <div class="alert alert-success notifdeletesuccess3" style="display:none;">
                                <p> </p>
                            </div>
                        <div class="table-responsive">
                          <table id="example" class="table table-bordered table-striped">
                            <thead>
                              <tr class="bg-blue">
                                <th width="20%">TGL YUDISIUM</th>
                                <th width="40%">NAMA FILE</th>
                                <th width="0%">INISIAL</th>
                                <th width="0%">STATUS</th>
                                <th width="0%">Actions</th>
                                <!-- <th colspan="2">Actions</th> -->
                              </tr>
                            </thead>
                            <tbody id="person3-list" name="person3-list">
                            @foreach ($person3 as $persons)
                              <tr id="person3{{ $persons->ID_FILE }}">
                                <td>{{indonesiaDate($persons->TGL_YUDISIUM)}}</td>
                                <td>{{ $persons->NAMA_FILE }}</td>
                                <td>{{$persons->INISIAL}}</td>
                                <td>@if ($persons->STATUS == 1)
                                <span class="label label-success">Tampilkan</span>
                                @endif
                                @if ($persons->STATUS == 2)
                                <span class="label label-danger">Sembunyikan</span>
                                @endif
                                </td>

                                <td style="text-align:center;width:15%;">
                                <button class="btn btn-xs bg-blue open-modal3" value="{{$persons->ID_FILE}}"><i class="glyphicon glyphicon-edit"></i> </button>
<!--                                 <button class="btn btn-xs btn-danger delete3" value="{{$persons->ID_FILE}}"><i class="glyphicon glyphicon-trash"></i> </button> -->
                                </td>
                                
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        <br>
                        </div>
                        <br>
                        </div>

                        <div class="col-xs-6">
                       
                        </div>
                        

                    </div>

                    

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Periode Wisuda</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('akademik._formperiodewisuda')  
                {!! Form::close() !!}
              
            </div>

          </div>
        </div>
        <!-- Modal -->

        <!-- Modal -->
        <div id="myModal3" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">File Yudisium</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('akademik._formfileyudisium')  
                {!! Form::close() !!}
              
            </div>

          </div>
        </div>
        <!-- Modal -->


  </div><!-- /.box-body -->
            <!-- <div class="box-footer"> -->
            <!-- Footer -->
            <!-- </div> /.box-footer -->
          </div><!-- /.box -->

        </section><!-- /.content -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script> -->

<script type="text/javascript">
  
$(document).ready(function(){
    
    var infoo       = $('.infoo');
    var infooo       = $('.infooo');
    var infooo2       = $('.infooo2');

    var notifoke       = $('.notifoke');
    var notifdeletesuccess2       = $('.notifdeletesuccess2');


    var infodelete = $('.info-delete');
    var $_token    = $('#token').val();

    $('.open-modal').click(function(){
        infoo.hide().find('ul').empty();
        var ID_PERIODE_WISUDA = $(this).val();
        $.get('periodewisuda/edit' + '/' + ID_PERIODE_WISUDA, function (data) {
            // $('#id').val(data.id);
            $('#ID_PERIODE_WISUDA').val(data.ID_PERIODE_WISUDA);
            $('#PERIODE_WISUDA').val(data.PERIODE_WISUDA);
            $('#DESKRIPSI').val(data.DESKRIPSI);

            $('.save').val("update");
            $('#myModal').modal('show');
        }) 
    });

    $('.open-modal2').click(function(){
        infoo.hide().find('ul').empty();
        var ID_JADWAL_YUDISIUM = $(this).val();
        $.get('jadwalyudisium/edit' + '/' + ID_JADWAL_YUDISIUM, function (data) {
            // $('#id').val(data.id);
            $('#ID_JADWAL_YUDISIUM').val(data.ID_JADWAL_YUDISIUM);
            $('#YUDISIUM').val(data.YUDISIUM);
            $('#TANGGAL_YUDISIUM').val(data.TANGGAL_YUDISIUM);

            $('.save').val("update");
            $('#myModal2').modal('show');
        }) 
    });

    $('#btn-add').click(function(){
        $('.save').val("add");
        $('#frm').trigger("reset");
        infoo.hide().find('ul').empty();
        $('#myModal2').modal('show');
    });


    $(".save").click(function (e) {
        e.preventDefault();
        
        var state = $('.save').val();
        var ID_PERIODE_WISUDA = $('#ID_PERIODE_WISUDA').val();
        var url = 'inputnoijazah/store';

        if (state == "update"){
            url  = 'periodewisuda/periodeWisuda/' + ID_PERIODE_WISUDA;
        }

        var formData = {
            ID_PERIODE_WISUDA: $('#ID_PERIODE_WISUDA').val(),

            PERIODE_WISUDA: $('#PERIODE_WISUDA').val(),
            DESKRIPSI: $('#DESKRIPSI').val(),
        }

        $.ajax({

            type: 'POST',
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: formData,
            dataType: 'json',
            headers: { 'X-XSRF-TOKEN' : $_token }, 
            success: function (data) {
                
                infoo.hide().find('ul').empty();
                    
                if(data.success == false)
                {
                    console.log(url);
                    $.each(data.errors, function(index, error) {
                        infoo.find('ul').append('<li>'+error+'</li>');
                    });

                    infoo.slideDown();
                    infoo.fadeTo(3000, 500).slideUp(500, function(){
                       infoo.hide().find('ul').empty();
                    });
                }
                else
                {
                    var person = '<tr id="person' + data.data.ID_PERIODE_WISUDA + '"><td>' + data.data.PERIODE_WISUDA + '</td><td>' + data.data.DESKRIPSI + '</td>';
                    person += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-blue open-modal" value="' + data.data.ID_PERIODE_WISUDA + '"><i class="glyphicon glyphicon-edit"></i> </button>';
                    
                    if (state == "add"){ 
                        $('#person-list').append(person);
                    }else{ 
                        $("#person" + ID_PERIODE_WISUDA).replaceWith(person);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide');

                    infooo.find('p').append('<strong> Success! </strong> Data berhasil disimpan.');
 
                    infooo.slideDown();
                    infooo.fadeTo(3000, 500).slideUp(500, function(){
                       infooo.hide().find('p').empty();
                    });
                }

                
            },
            error: function (data) {}
        });
    });

    
    
});

</script>


<script type="text/javascript">
  
$(document).ready(function(){
    
    var infoo       = $('.infoo');
    var infooo       = $('.infooo');
    var infooo3       = $('.infooo3');


    var notifoke       = $('.notifoke');

    var notifdeletesuccess3       = $('.notifdeletesuccess3');

    var infodelete = $('.info-delete');
    var $_token    = $('#token').val();


    $('.open-modal3').click(function(){
        infoo.hide().find('ul').empty();
        var ID_FILE = $(this).val();
        $.get('fileyudisium/edit' + '/' + ID_FILE, function (data) {
            // $('#id').val(data.id);
            $('#ID_FILE').val(data.ID_FILE);
            $('#ID_JADWAL_YUDISIUM').val(data.ID_JADWAL_YUDISIUM);
            $('#NAMA_FILE').val(data.NAMA_FILE);
            $('#INISIAL').val(data.INISIAL);
            $('#STATUS').val(data.STATUS);

            $('.save').val("update");
            $('#myModal3').modal('show');
        }) 
    });

    $('#btn-add3').click(function(){
        $('.save').val("add");
        $('#frm').trigger("reset");
        infoo.hide().find('ul').empty();
        $('#myModal3').modal('show');
    });



    $('.delete3').click(function(){
        var ID_FILE = $(this).val();
        var x = confirm("Are you sure you want to delete?");
        if(x)
        {
            $.ajax({
                type: "POST",
                headers: { 'X-XSRF-TOKEN' : $_token }, 
                url: 'fileyudisium/delete/' + ID_FILE,
                success: function (data) {
                    
                    infodelete.hide().find('ul').empty();
                    if(data.success == false)
                    {
                        infoodelete.find('ul').append('<li>'+data.errors+'</li>');
                        infoodelete.slideDown();
                        infoodelete.fadeTo(2000, 500).slideUp(500, function(){
                           infoodelete.hide().find('ul').empty();
                        });   
                    }
                    else
                    {
                        $("#person3" + ID_FILE).remove();
                        notifdeletesuccess3.find('p').append('<strong> Success! </strong> Data berhasil dihapus.');
 
                        notifdeletesuccess3.slideDown();
                        notifdeletesuccess3.fadeTo(3000, 500).slideUp(500, function(){
                           notifdeletesuccess3.hide().find('p').empty();
                        });
                    }
                },
            });

            return true;
            
        }
        
    });

    $(".save3").click(function (e) {
        e.preventDefault();
        
        var state = $('.save').val();
        var ID_FILE = $('#ID_FILE').val();
        var url = 'fileyudisium/store';

        if (state == "update"){
            url  = 'fileyudisium/update/' + ID_FILE;
        }

        var formData = {
            ID_FILE: $('#ID_FILE').val(),
            ID_JADWAL_YUDISIUM: $('#ID_JADWAL_YUDISIUM').val(),
            NAMA_FILE: $('#NAMA_FILE').val(),
            INISIAL: $('#INISIAL').val(),
            STATUS: $('#STATUS').val(), 
        }

        $.ajax({

            type: 'POST',
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: formData,
            dataType: 'json',
            headers: { 'X-XSRF-TOKEN' : $_token }, 
            success: function (data) {
                
                infoo.hide().find('ul').empty();
                    
                if(data.success == false)
                {
                    console.log(url);
                    $.each(data.errors, function(index, error) {
                        infoo.find('ul').append('<li>'+error+'</li>');
                    });

                    infoo.slideDown();
                    infoo.fadeTo(3000, 500).slideUp(500, function(){
                       infoo.hide().find('ul').empty();
                    });

                }
                else
                {
                    var person3 = '<tr id="person' + data.data.ID_FILE + '"><td>' + data.data.ID_JADWAL_YUDISIUM + '</td><td>' + data.data.NAMA_FILE + '</td><td>' + data.data.INISIAL + '</td><td><span class="label label-success">' + data.data.Tampilkan + '</span><span class="label label-danger">' + data.data.Sembunyikan + '</span></td>';
                    person3 += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-blue open-modal2" value="' + data.data.ID_FILE + '"><i class="glyphicon glyphicon-edit"></i> </button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#person3-list').append(person3);
                    }else{ 
                        $("#person3" + ID_FILE).replaceWith(person3);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal3').modal('hide');

                    infooo3.find('p').append('<strong> Success! </strong> Data berhasil disimpan.');
 
                    infooo3.slideDown();
                    infooo3.fadeTo(3000, 500).slideUp(500, function(){
                       infooo3.hide().find('p').empty();
                    });
                }

                
            },
            error: function (data) {}
        });
    });
});

</script>


<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

@endsection