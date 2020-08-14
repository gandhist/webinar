<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="P3SM, Sertifikat, Seminar, Jakarta, Indonesia, Seminar">
    <meta name="description" content="Sertifikat P3SM adalah Halaman Web untuk melakukan pendaftaran seminar yang diselenggarakan oleh P3SM"/>

    <title>SERTIFIKAT P3SM</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/style5.css') }}">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        td, th { 
            padding: 6px; 
            border: 0px solid #ccc; 
            text-align: left; 
        }

        @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr { 
                display: block; 
            }
            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr { 
                border: 1px solid #ccc; 
            }
            td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
            }  
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            input[type=file] {
                width: 100%;
                padding: 12px 70px;
                margin: 8px 0;
                box-sizing: border-box;
            }

            table.dataTable>tbody>tr.child {
                padding: 0px 0px;
            }
        }
      </style>
</head>

<body>
    <div class="wrapper">
        
        <!-- Sidebar Holder -->
        {{-- <nav id="sidebar">
            <div class="sidebar-header">
                <h3>P3SM</h3>
            </div>

            <ul class="list-unstyled components">
                @if(!Auth::user())
                <li class="active">
                    <a href="{{ route('login') }}">Login</a>
                </li>
                @else
                <li class="active">
                    <a href="{{ route('infoseminar') }}">Seminar</a>
                    <a href="{{ route('profile.edit') }}">User Profile</a>
                </li>
                @endif
            </ul>    
        </nav> --}}

        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #b7d0ed;">
                
                <div class="container-fluid">
                    <h4>P3SM</h4>
                    {{-- <button type="button" id="sidebarCollapse" class="navbar-btn active">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button> --}}
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
                                {{-- <form method="post" action="{{ url('logout') }}" style="display: inline">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary" type="submit">Sign Out</button>
                                  </form> --}}
                            </li>
                        </ul>
                    </div>
                    <!-- Default dropleft button -->
                    {{-- <div class="btn-group dropleft">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            {{ \Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu">
                        <form method="post" action="{{ url('logout') }}" style="display: inline">
                            {{ csrf_field() }}
                            <button class="btn btn-default" type="submit">Sign Out</button>
                          </form>
                        </div>
                    </div> --}}
                    @endif
                </div>
            </nav>
            {{-- content goes here --}}
            @yield('content')
            {{-- content end here --}}

        </div>
              
    </div>

    <!-- Footer Section Start -->
    <footer>
        <!-- Footer Area Start -->
        <section class="footer-Content">
        {{-- <div class="container">
        
        </div> --}}
        <!-- Copyright Start  -->
        <div class="copyright">
            <div class="container">
                <div class="row" align="center">
                    <div class="col-md-12">
                        <div class="site-info">
                            &copy; {{ \Carbon\Carbon::now()->isoFormat('YYYY') }} - All Rights Reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->
        </section>
        <!-- Footer area End -->
        
    </footer>
     <!-- Footer Section End --> 


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // $('#sidebar').toggleClass('active');
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
    @stack('script')
</body>
</html>