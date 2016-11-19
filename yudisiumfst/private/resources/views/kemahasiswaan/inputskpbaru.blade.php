<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templetekemahasiswaanbaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Input SKP
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

                <span class="error" style="color:blue;">
                    <?php if(Session::has('register_success')): ?>
                      <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('register_success') ?>
                      </div>
                    <?php endif; ?>
                </span>

                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th width="15%" style="display:none;">TGL</th>
                        <th width="25%">NIM</th>
                        <th width="40%">NAMA</th>
                        <th width="35%">PRODI</th>
                        <th width="0%">SKP</th>
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->NIM }}">

                        <td style="display:none;">{{ $persons->TGL_DAFTAR_YUDISIUM }}</td>
                        <td>{{ $persons->NIM }}
                        <input type="hidden" class="form-control" id="nim[{{ $persons->NIM }}]" name="nim[{{ $persons->NIM }}]" value="{{ $persons->NIM }}" placeholder="NIM" form="footer-form">
                        </td>

                        <td id="nama-{{ $persons->NIM }}">{{ $persons->NAMA }}</td>
                        <td>{{ $persons->UNIT }}</td>
                        <td>
                        <input type="text" class="form-control" id="skp[{{ $persons->NIM }}]" name="skp[{{ $persons->NIM }}]" placeholder="SKP" form="footer-form" pattern="[0-9]+">
                        </td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                    <!-- <br> -->
                      <input type="submit" value="Save" class="btn btn-success btn-md btn-block" form="footer-form">
                    <br>
                </div>
                    <!-- <br> -->
                    <form role="form" id="footer-form" method="POST" action="{{ url('inputskp') }}">
                    {!! csrf_field() !!}
                    </form>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit SKP</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('kemahasiswaan._form')  
                {!! Form::close() !!}
              
            </div>

          </div>
        </div>
        <!-- Modal -->




        <!-- set up the modal to start hidden and fade in and out -->
        <div id="myModal2" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- dialog body -->
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Hello world!
              </div>
              <!-- dialog buttons -->
              <div class="modal-footer"><button type="button" class="btn btn-primary">OK</button></div>
            </div>
          </div>
        </div>
      



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
    $('#example1').dataTable( {
        "aaSorting": [[ 0, "asc" ]]
    } );
} );
</script>

<script type="text/javascript">
  
$(document).ready(function(){
    
    var infoo       = $('.infoo');
    var infooo       = $('.infooo');
    var notifoke       = $('.notifoke');
    var notifdelete       = $('.notifdelete');

    var infoodelete = $('.infoo-delete');
    var $_token    = $('#token').val();

    $('.open-modal').click(function(){
        infoo.hide().find('ul').empty();

        var NIM = $(this).val();
        $.get('inputskp/edit' + '/' + NIM, function (data) {
            // $('#id').val(data.id);
            $('#NIM').val(data.NIM);
            $('#NAMA').val(data.NAMA);
            $('#UNIT').val(data.UNIT);
            $('#SKP').val(data.SKP);
            $('.save').val("update");
            $('#myModal').modal('show');
        }) 
    });

    $('#btn-add').click(function(){
        $('.save').val("add");
        $('#frm').trigger("reset");
        infoo.hide().find('ul').empty();

        $('#myModal').modal('show');
    });

    $('.oke').click(function(){
        var NIM = $(this).val();
        var nama = $('#nama-'+NIM).html();
        var x = confirm('Are you sure you want to delete '+nama+'?');
        // var x = bootbox.confirm("sdsd", function(result) {
        // });
            // $('#myModal2').modal('show');

        // bootbox.alert("Hello world!", function() {
        //   Example.show("Hello world callback");
        // });

        // bootbox.confirm("Are you happy with the decision you have made?", function(result) {
        


        if(x) {
            $.ajax({
                type: "POST",
                headers: { 'X-XSRF-TOKEN' : $_token }, 
                url: 'inputskp/delete' + '/' + NIM,
                success: function (data) {
                    
                    infoodelete.hide().find('ul').empty();
                    if(data.success == false)
                    {
                        // infoodelete.find('ul').append('<li>'+data.errors+'</li>');
                        // infoodelete.slideDown();
                        // infoodelete.fadeTo(2000, 500).slideUp(500, function(){
                        //    infoodelete.hide().find('ul').empty();
                        // }); 

                        notifdelete.find('p').append('');
 
                        notifdelete.slideDown();
                        notifdelete.fadeTo(2000, 500).slideUp(500, function(){
                           notifoke.hide().find('p').empty();
                        });  
                    }
                    else
                    {
                        $("#person" + NIM).remove();

                        notifoke.find('p').append('<strong>Success! </strong> Data berhasil dihapus.');
 
                        notifoke.slideDown();
                        notifoke.fadeTo(2000, 500).slideUp(500, function(){
                           notifoke.hide().find('p').empty();
                        });
                    }
                },
            });

            return true;          
        }

        
        // });//
        
    });



    $(".save").click(function (e) {
        e.preventDefault();
        var state = $('.save').val();
        var NIM = $('#NIM').val();
        var url = 'inputskp/store';

        if (state == "update"){
            url  = 'inputskp/inputSkp/' + NIM;
        }

        var formData = {
            NIM: $('#NIM').val(),
            NAMA: $('#NAMA').val(),
            UNIT: $('#UNIT').val(),
            SKP: $('#SKP').val()
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
                    infoo.fadeTo(2000, 500).slideUp(500, function(){
                       infoo.hide().find('ul').empty();
                    });
                }
                else
                {
                    var person = '<tr id="person' + data.data.NIM + '"><td>' + data.data.NIM + '</td><td>' + data.data.NAMA + '</td><td>' + data.data.UNIT + '</td><td>' + data.data.SKP + '</td>';
                    person += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-blue open-modal" value="' + data.id + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    person += '&nbsp;<button class="btn btn-xs bg-red open-modal oke" value="' + data.id + '"><i class="glyphicon glyphicon-trash"></i> Delete</button></td></tr>';

                    $('#table').append("<tr class='item" + data.ID_AGAMA + "'><td>" + data.ID_AGAMA + "</td><td>" + data.AGAMA + "</td><td><button class='edit-modal btn btn-info' data-ID_AGAMA='" + data.ID_AGAMA + "' data-AGAMA='" + data.AGAMA + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-ID_AGAMA='" + data.ID_AGAMA + "' data-AGAMA='" + data.AGAMA + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");


                    
                    if (state == "add"){ 
                        $('#person-list').append(person);
                    }else{ 
                        $("#person" + NIM).replaceWith(person);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide');

                    infooo.find('p').append('<strong>Success! </strong> Data berhasil disimpan.');
 
                    infooo.slideDown();
                    infooo.fadeTo(2000, 500).slideUp(500, function(){
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
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

    @endsection