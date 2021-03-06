

@extends('templeteruangbacabaru')

@section('content')
        <section class="content-header">
          <h1>
            Home
            <!-- <small>Fakultas Sains Teknologi Universitas Airlangga</small> -->
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

          <!-- Default box -->
          <div class="box">
            <!-- <div class="box-header with-border"> -->
            <!-- <center><h3 class="box-title">Biodata Mahasiswa</h3></center> -->
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
            <!-- </div> -->

            <div class="box-body">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-red">
                            <div class="inner">
                              @foreach ($data2 as $dataa2)
                              <h3>{{ $dataa2->nim_count }}</h3>
                              @endforeach
                              <p>Anggota Ruang Baca</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ url('daftaranggota') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-green">
                            <div class="inner">
                              @foreach ($data3 as $dataa3)
                              <h3>{{ $dataa3->pinjam_count }}</h3>
                              @endforeach
                              <p>Pinjam Buku</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ url('pinjambuku') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                          </div>
                        </div><!-- ./col -->
                        
                      </div>
            </div><!-- /.box-body -->
            <!-- <div class="box-footer"> -->
            <!-- Footer -->
            <!-- </div> /.box-footer -->
          </div><!-- /.box -->

        </section><!-- /.content -->

@endsection