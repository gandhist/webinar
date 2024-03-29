<div id="navbar">
   <nav class="navbar navbar-expand-lg navbar-light">

        <div class="container-fluid">
            @if(!Auth::user())
            {{-- <a class="home" href="{{ url('') }}"><h3>P<sub>3</sub>SM</h3></a> --}}
            <div id="logo" class="pull-left">
                <a class="home" href="{{ url('') }}"><img src="{{ url('p3sm_a.png') }}" alt="logo" class="img-responsive" height="33px" ></a>
            </div>
            @else
            {{-- <a class="home" href="{{ url('infoseminar') }}"><h3>P<sub>3</sub>SM</h3></a> --}}
            <div id="logo" class="pull-left">
                <a class="home" href="{{ url('infoseminar') }}"><img src="{{ url('p3sm_a.png') }}" class="img-responsive" alt="logo" height="33px"></a>
            </div>
            @endif

            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-align-justify"></i>
            </button>

            @if(!Auth::user())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('') }}"><strong>Beranda</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('infoseminar') }}"><strong>Seminar</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('registrasi') }}"><strong>Bergabung</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('berita') }}"><strong>Berita</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('galeri') }}"><strong>Galeri</strong></a>
                    </li>
                    <li style="padding-left: 10px;">
                        <a class="btn btn-success" href="{{ url('login') }}"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                </ul>
            </div>
            @else
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('infoseminar') }}"><strong>Seminar</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ route('kegiatan.index') }}"><strong>Kegiatan</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('pembayaran') }}"><strong>Pembayaran</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('berita') }}"><strong>Berita</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href= "{{ url('galeri') }}"><strong>Galeri</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}"><strong>User Profile</strong></a>
                    </li>
                    <li style="padding-left: 10px;">
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i>
                                {{ \Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <!-- Dropdown menu links -->
                                <form method="post" action="{{ url('logout') }}" style="display: inline">
                                {{ csrf_field() }}
                                <button class="btn btn-default" type="submit">Logout</button>
                                </form>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </nav>
</div>
