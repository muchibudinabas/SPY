<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yudisium | Fakultas Sains Teknologi Universitas Airlangga</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{$url = asset('private/resources/assets/AdminLTE/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{$url = asset('private/resources/assets/AdminLTE/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{$url = asset('private/resources/assets/AdminLTE/dist/css/skins/_all-skins.min.css')}}">


    <!-- DataTables -->
    <link rel="stylesheet" href="{{$url = asset('private/resources/assets/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">
    


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{$url = asset('private/resources/assets/AdminLTE/index2.html')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b class="fa fa-mortar-board text-white"></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b class="fa fa-mortar-board text-white"> Yudisium </b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    @foreach ($profile as $profilee)
                  @if (is_null($profilee->IMAGE))
                  <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/avatar5.jpg')}}" class="user-image" alt="User Image">
                  @else
                  <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/'.$profilee->IMAGE)}}" class="user-image" alt="User Image">
                  @endif


                  <span class="hidden-xs">{{$profilee->NAMA_PEGAWAI}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    @if (is_null($profilee->IMAGE))
                    <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/avatar5.jpg')}}" class="img-circle" alt="User Image">
                    @else
                    <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/'.$profilee->IMAGE)}}" class="img-circle" alt="User Image">
                    @endif

                    <p>
                      {{$profilee->NAMA_PEGAWAI}}
                    @endforeach
                      <small>Member since Nov. 2016</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              @foreach ($profile as $profilee)
              @if (is_null($profilee->IMAGE))
              <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/avatar5.jpg')}}" class="img-circle" alt="User Image">
              @else
              <img src="{{$url = asset('private/resources/assets/AdminLTE/dist/img/'.$profilee->IMAGE)}}" class="img-circle" alt="User Image">
              @endif
            </div>
            <div class="pull-left info">
              <p>{{$profilee->NAMA_PEGAWAI}}</p>
              @endforeach
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style="font-size: 13px;">MAIN NAVIGATION</li>
            <!-- <li class="treeview" class="active"> -->
            <li class="{{ Request::segment(1) === 'home' ? 'active' : null }}">
              <a href="{{ url('home') }}">
                <i class="fa fa-home "></i> <span> Home </span>
              </a>
            </li>
            <li class="header" style="font-size: 13px;">WISUDA</li> 
            <li class="{{ Request::segment(1) === 'inputskp' ? 'active' : null }}">
              <!-- <a href="#"> -->
              <a href="{{ url('inputskp') }}">
                <i class="fa fa-pencil "></i> <span> Input SKP </span>
              </a>
            </li>
            <li class="{{ Request::segment(1) === 'dataskpmahasiswa' ? 'active' : null }}">
              <!-- <a href="#"> -->
              <a href="{{ url('dataskpmahasiswa') }}">
                <i class="fa fa-edit "></i> <span> Data SKP Mahasiswa </span>
              </a>
            </li>
            <li class="{{ Request::segment(1) === 'datawisudawankm' ? 'active' : null }}">
              <a href="{{ url('datawisudawankm') }}">
                <i class="fa fa-mortar-board"></i>
                <span> Data SKP Wisudawan </span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        


        @yield('content')



      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Developed by</b> <a target="_blank" href="https://www.facebook.com/muchibudinabas14"><strong>Muchi</strong></a>
        </div>
        <strong>Copyright &copy; 2016 <a target="_blank" href="http://unair.ac.id">Universitas Airlangga</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            
          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/dist/js/demo.js')}}"></script>
    
    <!-- DataTables -->
    <script src="{{$url = asset('private/resources/assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{$url = asset('private/resources/assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>


    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>

    <!-- bootbox code -->
    <script src="{{$url = asset('private/resources/bootbox/bootbox.min.js')}}"></script>
    <script src="{{$url = asset('private/resources/bootbox/bootbox.js')}}"></script>


  </body>
</html>
