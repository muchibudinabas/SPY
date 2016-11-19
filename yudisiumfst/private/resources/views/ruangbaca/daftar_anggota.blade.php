<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templeteruangbacabaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Daftar Anggota
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

                    <button class="btn-success btn-sm" id="btn-add"><i class="fa fa-plus-circle"></i> Add</button><br/><br/>
                    
                    <div class="alert alert-success infooo" style="display:none;">
                        <p></p>
                    </div>

                    <div class="alert alert-success notifoke" style="display:none;">
                        <p></p>
                    </div>

                    <span class="error" style="color:blue;">
                        <?php if(Session::has('register_danger2')): ?>

                            <div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 0px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                                <?php echo Session::get('register_danger2') ?>
                            </div>

                        <?php endif; ?>
                    </span>

                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>PRODI</th>
                        <th>TELPON</th>
                        <th>Actions</th>
                        <!-- <th colspan="2">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->NIM_ANGGOTA }}">

                        <td>{{ $persons->NIM_ANGGOTA }}</td>
                        <!-- <td>{{ $persons->NAMA}}</td> -->
                        <!-- <td>{{ $persons->NAMA }}</td> -->
                        <td id="nama-{{ $persons->NIM_ANGGOTA }}">{{ $persons->NAMA_ANGGOTA}}</td>
                        <td>{{ $persons->ALAMAT_ANGGOTA }}</td>
                        <td>{{ $persons->UNIT }}</td>
                        <td>{{ $persons->TELPON_ANGGOTA }}</td>
                        

                        <td style="text-align:center;width:15%;">
                        <button class="btn btn-xs bg-blue open-modal" value="{{$persons->NIM_ANGGOTA}}"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                        <button class="btn btn-xs bg-red delete" value="{{$persons->NIM_ANGGOTA}}"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        <!-- <button class="btn btn-xs btn-danger oke" value="{{$persons->NIM}}"><i class="glyphicon glyphicon-trash"></i> Delete</button> -->
                        </td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Daftar Anggota</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('ruangbaca._formdaftaranggota')  
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
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>

<script type="text/javascript">
  
$(document).ready(function(){
    
    var infoo       = $('.infoo');
    var infooo       = $('.infooo');
    var notifoke       = $('.notifoke');

    var infoodelete = $('.infoo-delete');
    var $_token    = $('#token').val();

    $('.open-modal').click(function(){
        infoo.hide().find('ul').empty();
        var NIM_ANGGOTA = $(this).val();
        $.get('daftaranggota/edit' + '/' + NIM_ANGGOTA, function (data) {
            // $('#id').val(data.id);
            $('#NIM_ANGGOTA').val(data.NIM_ANGGOTA);
            $('#NAMA_ANGGOTA').val(data.NAMA_ANGGOTA);
            $('#ID_UNIT').val(data.ID_UNIT);
            $('#ALAMAT_ANGGOTA').val(data.ALAMAT_ANGGOTA);
            $('#TELPON_ANGGOTA').val(data.TELPON_ANGGOTA);

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

    $('.delete').click(function(){
        var NIM_ANGGOTA = $(this).val();
        var nama = $('#nama-'+NIM_ANGGOTA).html();
        var x = confirm('Apakah anda yakin ingin menghapus '+nama+'?');
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
                url: 'daftaranggota/delete' + '/' + NIM_ANGGOTA,
                success: function (data) {
                    
                    infoodelete.hide().find('ul').empty();
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
                        $("#person" + NIM_ANGGOTA).remove();

                        notifoke.find('p').append('Data berhasil dihapus!');
 
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
        var NIM_ANGGOTA = $('#NIM_ANGGOTA').val();
        var url = 'daftaranggota/store';

        if (state == "update"){
            url  = 'daftaranggota/update/' + NIM_ANGGOTA;
        }

        var formData = {
            NIM_ANGGOTA: $('#NIM_ANGGOTA').val(),
            NAMA_ANGGOTA: $('#NAMA_ANGGOTA').val(),
            ALAMAT_ANGGOTA: $('#ALAMAT_ANGGOTA').val(),
            ID_UNIT: $('#ID_UNIT').val(),
            UNIT: $( "#ID_UNIT option:selected" ).text(),

            TELPON_ANGGOTA: $('#TELPON_ANGGOTA').val(),
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
                    var person = '<tr id="person' + data.data.NIM_ANGGOTA + '"><td>' + data.data.NIM_ANGGOTA + '</td><td>' + data.data.NAMA_ANGGOTA + '</td><td>' + data.data.ALAMAT_ANGGOTA + '</td><td>' + data.data.UNIT + '</td><td>' + data.data.TELPON_ANGGOTA + '</td>';
                    person += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-blue open-modal" value="' + data.NIM_ANGGOTA + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    person += '&nbsp;<button class="btn btn-xs bg-red oke" value="' + data.NIM_ANGGOTA + '"><i class="glyphicon glyphicon-trash"></i> Delete</button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#person-list').append(person);
                    }else{ 
                        $("#person" + NIM_ANGGOTA).replaceWith(person);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide');

                    infooo.find('p').append('Data berhasil disimpan!');
 
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