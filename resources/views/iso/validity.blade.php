<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Validity - {{ $data->nama_bu }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/dist/css/skins/_all-skins.min.css') }}">

  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/plugins/datatables/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/css/fileinput.css') }}">

  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/css/fileinput-rtl.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

  <!-- FONT AWESOME -->
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor') }}/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('global.css') }}">
  
  @stack('style')
@push('style')
<style>

.footer--light {
 background:#e7e8ed
}

.footer-menu {
 padding-left:48px
}
.footer-menu ul li a {
 font-size:15px;
 line-height:32px;
 -webkit-transition:.3s;
 -o-transition:.3s;
 transition:.3s
}
.footer-menu ul li a:hover {
 color:#5867dd
}
.footer-menu--1 {
 width:100%
}
.footer-widget-title {
 line-height:42px;
 margin-bottom:10px;
 font-size:18px
}
.mini-footer {
 background:#192027;
 text-align:center;
 padding:32px 0
}
.mini-footer p {
 margin:0;
 line-height:26px;
 font-size:15px;
 color:#999
}
.mini-footer p a {
 color:#5867dd
}
.mini-footer p a:hover {
 color:#34bfa3
}
    </style>
@endpush
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
 
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style="padding: 30px">
    {{-- <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ISO</a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      <br><br><br> --}}
  
      <div class="container">
            
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <div class="widget-user-image">
                    <div class="text-center">
                        <img class="img-thumbnail img-fluid" style="height: 150px; width:200px" src="{{ asset('iso/images/logoheader.png') }}" alt="Logo Mandiri Certification">
                    </div>
                </div>
              {{-- <h3 class="widget-user-username">Alexander Pierce</h3>
              <h5 class="widget-user-desc">Founder &amp; CEO</h5> --}}
            </div>
            
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-header text-center">
                            <h1 >{{ $data->nama_bu }}</h1>
                        </div>
                    </div>
                </div>
              <div class="row">
                <div class="col-sm-4 border-right text-center">
                    <h4>Scope Of Sertification :</h4>
                  <div class="description-block">
                    <h5 class="description-header">
                        @if($data->lap_r)
                            @foreach($data->lap_r->scope_r as $key)
                                {{-- {{ $key->scope_r->nama_en }},  --}}
                                @if($loop->last)
                                    {{ $key->scope_r->nama_en }}
                                @else
                                    {{ $key->scope_r->nama_en }}, 
                                @endif
                            @endforeach
                        @endif
                    </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right text-center">
                    <h4>Standard : </h4> <div class="description-block"> <h5 class="description-header"> {{  $data->iso_r->kode  }} </h5> </div>
                    <h4>Certificate Number : </h4> <div class="description-block"> <h5 class="description-header"> {{  $data->no_sert  }} </h5> </div>                  
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-center">
                    <h4>Address : </h4>
                  <div class="description-block">
                    <h5 class="description-header">{{ $data->alamat }}</h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>

            <div class="box-footer">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading text-center text-bold">
                        CERTIFICATE STATUS
                    </div>
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                
                                <tr>
                                    <td class="bg-aqua-active">Main Assesment Date</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tgl_sert)->isoFormat('DD MMMM YYYY') }}</td>
                                    <td class="bg-aqua-active">Certificate Status</td>
                                    <td class="text-center"><button type="button" class="btn btn-block btn-success">Valid</button></td>
                                </tr>
                                <tr>
                                    <td class="bg-aqua-active">Effective Date</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tgl_sert)->isoFormat('DD MMMM YYYY') }}</td>
                                    <td class="bg-aqua-active">Expired Date</td>
                                    <td class="text-center"><p> {{ \Carbon\Carbon::parse($data->valid_date)->isoFormat('DD MMMM YYYY') }}</p></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading text-center text-bold">
                        SURVEILANCE STATUS
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive">
                            
                            <tr>
                                <td class="bg-aqua-active">1<sup>st</sup> Surveilance</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($data->first_surv)->isoFormat('DD MMMM YYYY') }}</td>
                                <td class="bg-aqua-active">1<sup>st</sup> Surveilance Status</td>
                                <td class="text-center"><button type="button" class="btn btn-block btn-success">Valid</button></td>
                            </tr>
                            <tr>
                                <td class="bg-aqua-active">2<sup>nd</sup> Surveilance</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($data->second_surv)->isoFormat('DD MMMM YYYY') }}</td>
                                <td class="bg-aqua-active">2<sup>nd</sup> Surveilance Status</td>
                                <td class="text-center"><button type="button" class="btn btn-block btn-success">Valid</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

          </div>
  
      </div><!-- /.container -->
</body>
<footer class="footer-area footer--light">
    <div class="mini-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="copyright-text text-center">
              <p>© {{ \Carbon\Carbon::now()->isoFormat("YYYY") }}
                <a href="{{ url('/') }}">Mandiri Certification</a>. All rights reserved.
              </p>
            </div>
  
            <div class="go_top">
              <span class="icon-arrow-up"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
@include('templates.footer')
