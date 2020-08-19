<div id="navbar">
   <nav class="navbar navbar-expand-lg navbar-light">
                
        <div class="container-fluid">
            <h3>P3SM</h3>
            {{-- <div id="logo" class="pull-left">
                <img src="{{ url('p3sm.jpeg') }}" alt="logo" width="100px" height="60px">
            </div> --}}
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>
            
            @if(!Auth::user())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('') }}">Beranda</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href= "{{ url('infoseminar') }}">Seminar</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('registrasi') }}">Bergabung</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('login') }}">Login</a>
                    </li>
                </ul>
            </div>
            @else
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href= "{{ url('infoseminar') }}">Seminar</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('profile.edit') }}">User Profile</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="javascript:void" onclick="$('#logout-form').submit();">
                            Sign Out
                        </a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </nav>            
</div>             
