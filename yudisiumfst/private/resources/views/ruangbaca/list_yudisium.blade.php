<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templeteakademikbaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Input No Ijazah
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
            
              
              <div class="box">
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
                        <th>Actions</th>
                        <!-- <th colspan="2">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->NIM }}">

                        <td>{{ $persons->NIM }}</td>
                        <td><a id="nama-{{ $persons->NIM }}" href="{{ url('detail_mhs') }}/{{ $persons->NIM }}">{{ $persons->NAMA}}</td>
                        <!-- <td>{{ $persons->NAMA }}</td> -->
                        <!-- <td ><a href="{{ url('detail_mhs') }}/{{ $persons->NIM }}" id="nama-{{ $persons->NIM }}">{{ $persons->NAMA}}</td> -->
                        <td>{{ $persons->JENIS_KELAMIN }}</td>
                        <td>{{ $persons->TGL_LULUS }}</td>
                        <td>{{ $persons->PRODI }}</td>
                        <td>{{ $persons->NO_IJAZAH }}</td>
                        <td>{{ $persons->IPK }}</td>
                        <td>{{ $persons->SKS }}</td>
                        <td>{{ $persons->ELPT }}</td>
                        <td>{{ $persons->SKP }}</td>
                        

                        <td style="text-align:center;width:15%;">
                        <button class="btn btn-xs bg-blue open-modal" value="{{$persons->NIM}}"><i class="glyphicon glyphicon-edit"></i> Input No Ijazah</button>
                        <button class="btn btn-xs bg-green oke" value="{{$persons->NIM}}"><i class="glyphicon glyphicon-ok"></i> Oke</button>
                        <!-- <button class="btn btn-xs btn-danger oke" value="{{$persons->NIM}}"><i class="glyphicon glyphicon-trash"></i> Delete</button> -->
                        </td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Input No Ijazah</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('akademik._form')  
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
  
$(document).ready(function(){
    
    var infoo       = $('.infoo');
    var infooo       = $('.infooo');
    var notifoke       = $('.notifoke');

    var infoodelete = $('.infoo-delete');
    var $_token    = $('#token').val();

    $('.open-modal').click(function(){
        infoo.hide().find('ul').empty();
        var NIM = $(this).val();
        $.get('inputnoijazah/edit' + '/' + NIM, function (data) {
            // $('#id').val(data.id);
            $('#NIM').val(data.NIM);
            $('#NAMA').val(data.NAMA);
            $('#PRODI').val(data.PRODI);
            $('#TGL_LULUS').val(data.TGL_LULUS);
            $('#NO_IJAZAH').val(data.NO_IJAZAH);
            $('#IPK').val(data.IPK);
            $('#SKS').val(data.SKS);
            $('#ELPT').val(data.ELPT);

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
        var x = confirm('Pilih oke, bila isian No Ijazah '+nama+' sudah benar?');
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
                url: 'inputnoijazah/verifikasiAk' + '/' + NIM,
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
                        $("#person" + NIM).remove();

                        notifoke.find('p').append('Data telah terverifikasi!');
 
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
        var url = 'inputnoijazah/store';

        if (state == "update"){
            url  = 'inputnoijazah/inputNoIjazah/' + NIM;
        }

        var formData = {
            NIM: $('#NIM').val(),
            NAMA: $('#NAMA').val(),
            PRODI: $('#PRODI').val(),
            TGL_LULUS: $('#TGL_LULUS').val(),
            NO_IJAZAH: $('#NO_IJAZAH').val(),
            IPK: $('#IPK').val(),
            SKS: $('#SKS').val(),
            ELPT: $('#ELPT').val(),
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
                    var person = '<tr id="person' + data.data.NIM + '"><td>' + data.data.NIM + '</td><td>' + data.data.NAMA + '</td><td>' + data.data.JENIS_KELAMIN + '</td><td>' + data.data.TGL_LULUS + '</td><td>' + data.data.PRODI + '</td><td>' + data.data.NO_IJAZAH + '</td><td>' + data.data.IPK + '</td><td>' + data.data.SKS + '</td><td>' + data.data.ELPT + '</td><td>' + data.data.SKP + '</td>';
                    person += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-blue open-modal" value="' + data.id + '"><i class="glyphicon glyphicon-edit"></i> Input No Ijazah</button>';
                    person += '&nbsp;<button class="btn btn-xs bg-green oke" value="' + data.id + '"><i class="glyphicon glyphicon-ok"></i> Oke</button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#person-list').append(person);
                    }else{ 
                        $("#person" + NIM).replaceWith(person);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide');

                    infooo.find('p').append('Data telah berhasil disimpan!');
 
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