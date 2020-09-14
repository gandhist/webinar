@if(!Auth::user())
<!-- jika belum ada session login -->
<script type="text/javascript">
    window.location.replace("{{ route('login') }}");
</script>
@else
<!-- jika sudah login -->
<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('/dashboard') }}" class="logo" style="display:inline-block; min-height:100%; background-color: #48a2d7">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini" style="display:inline-block; min-height:100%; "><img src="{{ url('p3sm_a.png') }}" alt="logo" class="img-responsive" width="100px" style="display:inline-block;  vertical-align: middle"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg" style="display:inline-block; min-height:100%;"><img src="{{ url('p3sm_a.png') }}" alt="logo" class="img-responsive" width="100px" style="display:inline-block;  vertical-align: middle"></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
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
            <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{\Auth::user()->name}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div>
                <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                <form method="post" action="{{ url('logout') }}" style="display: inline">
                  {{ csrf_field() }}
                  <button class="btn btn-default" type="submit">Sign Out</button>
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{\Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      {{-- <li class="header">MAIN NAVIGATION</li> --}}

      <li class="treeview">
        <a href="{{ url('/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      @if(Auth::user()->role_id==1 || Auth::user()->role_id==5 )

      <li class="treeview">
        <a href="{{ url('seminar') }}">
          <i class="fa fa-dashboard"></i> <span>Seminar</span>
        </a>
      </li>

      <li class="treeview">
        <a href="{{ url('statistik') }}">
            <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Statistik</span>
        </a>
      </li>

      <li class="treeview">
        <a href="{{ url('instansi') }}">
        <i class="fa fa-building-o" aria-hidden="true"></i></i> <span>Instansi</span>
        </a>
      </li>

      <li class="treeview">
        <a href="{{ url('tuk') }}">
        <i class="fa fa-map-marker" aria-hidden="true"></i></i> <span>TUK</span>
        </a>
      </li>

      <li class="treeview">
        <a href="{{ url('personals') }}">
          <i class="fa fa-user"></i> <span>Personal</span>
        </a>
      </li>

      <li class="treeview">
        <a href="{{ url('pesertas') }}">
          <i class="fa fa-user"></i> <span>Peserta</span>
        </a>
      </li>
      @endif
      @if(Auth::user()->role_id==1 )

      <li class="treeview">
        <a href="{{ url('isos') }}">
          <i class="fa fa-certificate"></i> <span>ISO</span>
        </a>
      </li>
      <li class="treeview">
        <a href="{{ url('laporan') }}">
          <i class="fa fa-bookmark-o"></i> <span>Laporan</span>
        </a>
      </li>
      @endif

      @if(Auth::user()->role_id==1)

      <li class="treeview {{Request::is('user*') ? 'active' : ''}}">
        <a href="#">
          <i class="fa fa-users"></i> <span>Kelola Admin</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{Request::is('users') ? 'active' : ''}}">
            <a href="{{ url('users') }}">
              <i class="fa fa-user"></i> <span>Admin</span>
            </a>
          </li>
          <li class="{{Request::is('user_role') ? 'active' : ''}}">
            <a href="{{ url('user_role') }}">
              <i class="fa fa-user"></i> <span>Role</span>
            </a>
          </li>
        </ul>
      </li>
      @endif

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
@endif
