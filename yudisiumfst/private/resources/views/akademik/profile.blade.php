

@extends('templateakademik')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User Profile
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
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          @foreach ($profile as $profilee)
          @if ($profilee->IMAGE == null)
          <img class="profile-user-img img-responsive img-circle" src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/avatar5.jpg')}}" alt="User profile picture">
          @endif
          @if ($profilee->IMAGE != null)
          <img class="profile-user-img img-responsive img-circle" src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/'.$profilee->IMAGE)}}" alt="User profile picture">
          @endif
          <h3 class="profile-username text-center">{{$profilee->NAMA_PEGAWAI}}</h3>
          <p class="text-muted text-center">{{$profilee->USERNAME}}</p>
          @endforeach
 

          <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
        </div><!-- /.box-body -->
      </div><!-- /.box -->


    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <!-- <li ><a href="#profile" data-toggle="tab">Profile</a></li> -->
          <!-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
          <li class="active"><a href="#ubah_password" data-toggle="tab">Ubah Password</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="profile">
            <form class="form-horizontal">
            @foreach ($profile as $profilee)
              <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                <label class=" control-label"> : &nbsp;&nbsp;&nbsp;{{$profilee->USERNAME}}</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                <label class=" control-label"> : &nbsp;&nbsp;&nbsp;{{$profilee->NAMA}}</label>
                </div>
              </div>
            @endforeach
            </form>
          </div><!-- /.tab-pane -->
          
          <div class="active tab-pane" id="ubah_password">
          
          <span class="error" style="color:blue;">
            <?php if(Session::has('warning')): ?>

              <div class="alert alert-warning alert-dismissible" role="alert" style="border-radius: 0px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                <?php echo Session::get('warning') ?>
              </div>
            <?php endif; ?>
            <?php if(Session::has('success')): ?>

              <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 0px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=""><span aria-hidden="true">&times;</span></button>
                <?php echo Session::get('success') ?>
              </div>

            <?php endif; ?>
          </span>


            <form class="form-horizontal" method="POST" action="{{ url('ubahPassword') }}">
                {!! csrf_field() !!}
            @foreach ($profile as $profilee)
              <div class="form-group">
                <label for="Username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="USERNAME" name="USERNAME" placeholder="{{$profilee->USERNAME}}" disabled="">
                </div>
              </div>
<!--               <div class="form-group">
                <label for="Nama" class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="NAMA" name="NAMA" placeholder="Nama" required>
                </div>
              </div> -->
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Password Lama</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="Password Lama" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="PASSWORD_BARU" name="PASSWORD_BARU" placeholder="Password Baru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Konfirmasi Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="PASSWORD_CONFIRMATION" name="PASSWORD_CONFIRMATION" placeholder="Konfirmasi Password" onfocus="passwordConfirm(document.getElementById('PASSWORD_BARU'), this);" oninput="validatePass(document.getElementById('PASSWORD_BARU'), this);" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-danger">Submit</button>
                </div>
              </div>
            @endforeach

          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->

</section><!-- /.content -->
<script type="text/javascript">
  function passwordConfirm(PASSWORD_BARU, PASSWORD_CONFIRMATION) {
    if (PASSWORD_BARU.value != PASSWORD_CONFIRMATION.value) {
        PASSWORD_CONFIRMATION.setCustomValidity("Passwords Don't Match");
    } else {
        PASSWORD_CONFIRMATION.setCustomValidity('');
    }
}
</script>
@endsection
