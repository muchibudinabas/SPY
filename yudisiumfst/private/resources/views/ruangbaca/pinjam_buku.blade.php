<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('templeteruangbacabaru')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Pinjam Buku
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
                        <th width="0%">TGL JATUH TEMPO</th>

                        <th width="0%">Actions</th>
                        <!-- <th colspan="2">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody id="person-list" name="person-list">
                    @foreach ($person as $persons)
                      <tr id="person{{ $persons->ID_PINJAM_BUKU }}">

                        <td id="nim-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->NIM_ANGGOTA }}</td>
                        <!-- <td id="nama-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->NAMA_ANGGOTA}}</td> -->
                        <!-- <td>{{ $persons->NAMA }}</td> -->
                        <td id="nama-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->NAMA_ANGGOTA}}</td>
                        <td>{{ $persons->UNIT }}</td>
                        <td>{{ $persons->NO_KLAS }}</td>
                        <td><a href="{{ url('detail_pinjam') }}/{{ $persons->NIM_ANGGOTA }}/{{ $persons->ID_PINJAM_BUKU }}" id="judul-{{ $persons->ID_PINJAM_BUKU }}">{{ $persons->PENGARANG }}, {{ $persons->JUDUL }}</td>
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
                        @if ($persons->ID_JENIS_PINJAM == 1)
                        <td></td>
                        @endif
                        @if ($persons->ID_JENIS_PINJAM == 2)
                        <td></td>
                        @endif
                        @if ($persons->ID_JENIS_PINJAM == 3)
                        <td>{{ dateDMYoneWeek($persons->TGL_PINJAM) }}</td>
                        @endif
                        <!-- <td>{{ $persons->NO_KLAS }}</td> -->
                        
                        <td style="text-align:center;width:15%;">
<!--                         <button class="btn btn-xs bg-blue open-modal" value="{{$persons->ID_PINJAM_BUKU}}"><i class="glyphicon glyphicon-edit"></i> Input No Ijazah</button> -->
                        <button class="btn btn-xs bg-green oke" value="{{$persons->ID_PINJAM_BUKU}}"><i class="glyphicon glyphicon-ok-circle"></i> Kembalikan</button>
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
                <h4 class="modal-title" id="myModalLabel">Pinjam Buku</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(array('id' => 'frm', 'name' => 'frm', 'class' => 'form-horizontal')) !!}
                <input id="token" type="hidden" value="{{$encrypted_token}}">
                @include('ruangbaca._formpinjambuku')  
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
        var ID_PINJAM_BUKU = $(this).val();
        $.get('pinjambuku/edit' + '/' + ID_PINJAM_BUKU, function (data) {
            $('#ID_PINJAM_BUKU').val(data.ID_PINJAM_BUKU);

            $('#NIM_PEMINJAM').val(data.NIM_PEMINJAM);
            $('#NAMA_PEMINJAM').val(data.NAMA_PEMINJAM);

            // get name
            var NAMA_PEMINJAM = $('#NAMA_PEMINJAM-'+ID_PINJAM_BUKU).html();
            var NIM_PEMINJAM = $('#NIM_PEMINJAM-'+ID_PINJAM_BUKU).html();
            //set name
            $('#NIM_PEMINJAM-modal').html(NIM_PEMINJAM);
            $('#NAMA_PEMINJAM-modal').html(NAMA_PEMINJAM);
            
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
        var ID_PINJAM_BUKU = $(this).val();
        var nama = $('#nama-'+ID_PINJAM_BUKU).html();
        var judul = $('#judul-'+ID_PINJAM_BUKU).html();
        var x = confirm('Apakah anda yakin '+nama+' telah mengembalikan buku '+judul+'?');
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
                url: 'pinjambuku/kembalibuku/' + ID_PINJAM_BUKU,
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
                        $("#person" + ID_PINJAM_BUKU).remove();

                        notifoke.find('p').append('Data berhasil disimpan!');
 
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
        var ID_PINJAM_BUKU = $('#ID_PINJAM_BUKU').val();
        var url = 'pinjambuku/store';

        if (state == "update"){
            url  = 'pinjambuku/kembalibuku/' + ID_PINJAM_BUKU;
        }

        var formData = {
            ID_PINJAM_BUKU: $('#ID_PINJAM_BUKU').val(),
            NIM_PEMINJAM: $('#NIM_PEMINJAM').val(),
            NAMA_PEMINJAM: $('#NAMA_PEMINJAM').val(),
            ID_UNIT: $('#ID_UNIT').val(),
            UNIT: $( "#ID_UNIT option:selected" ).text(),

            ID_JENIS_PINJAM: $('#ID_JENIS_PINJAM').val(),
            JENIS_PINJAM: $( "#ID_JENIS_PINJAM option:selected" ).text(),

            NO_KLAS: $('#NO_KLAS').val(),
            PENGARANG: $('#PENGARANG').val(),
            JUDUL: $('#JUDUL').val(),
            ID_JENIS_KOLEKSI: $('#ID_JENIS_KOLEKSI').val(),
            JENIS_KOLEKSI: $( "#ID_JENIS_KOLEKSI option:selected" ).text(),

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
                    // var person = '<tr id="person' + data.data.ID_PINJAM_BUKU + '"><td>' + data.data.NIM + '</td><td>' + data.data.NAMA + '</td><td>' + data.data.PRODI + '</td><td>' + data.data.NO_KLAS + '</td><td>' + data.data.PENGARANG + data.data.JUDUL + '</td><td>' + data.data.KOLEKSI + '</td><td>' + data.data.JENIS_PINJAM + '</td><td>' + data.data.TGL_PINJAM + '</td><td>' + data.data.TGL_KEMBALI + '</td>';
                    var person = '<tr id="person' + data.data.ID_PINJAM_BUKU + '"><td>' + data.data.NIM_PEMINJAM + '</td><td>' + data.data.NAMA_PEMINJAM + '</td><td>' + data.data.UNIT + '</td><td>' + data.data.NO_KLAS + '</td><td><a id="judul-' + data.data.ID_PINJAM_BUKU + '" href="{{ url('detail_pinjam') }}/' + data.data.NIM_PEMINJAM + '/' + data.data.ID_PINJAM_BUKU + '">' + data.data.PENGARANG+', '+ data.data.JUDUL + '</td><td>' + data.data.JENIS_KOLEKSI + '</td><td><span class="label label-warning">' + data.data.Fotocopy + '</span><span class="label label-primary">' + data.data.Membaca + '</span><span class="label label-danger">' + data.data.Pinjam + '</span></td><td>' + data.data.TGL_PINJAM + '</td><td>' + data.data.TGL_KEMBALI + '</td>';

                    person += '<td style="text-align:center;width:15%;"><button class="btn btn-xs bg-green oke" value="' + data.ID_PINJAM_BUKU + '"><i class="glyphicon glyphicon-ok-circle"></i> Kembalikan</button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#person-list').append(person);
                    }else{ 
                        $("#person" + ID_PINJAM_BUKU).replaceWith(person);
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