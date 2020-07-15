<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Sertifikat P3SM</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="#">P3SM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('seminar') }}">Seminar <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('sertifikat/cari') }}">Cari Sertifikat</a>
              </li>
          </ul>
          
          @if(!Auth::check())
          <form class="form-inline mt-2 mt-md-0">
            <a href={{ route('login') }} class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</a>
          </form>
          
          @else
          <p class="text-light bg-dark"> Logged as : {{\Auth::user()->name}}</p>
          <form method="post" action="{{ url('logout') }}" style="display: inline">
            {{ csrf_field() }}
            <button class="btn btn-default" type="submit">Sign Out</button>
          </form>
          <div class="dropdown show">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown link
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div>
          @endif
        </div>
      </nav>
  
      <main role="main" class="container">
        <div class="jumbotron">
          <h1>SERTIFIKAT P3SM</h1>
          <p class="lead">
              {{ $data->nama_seminar }} <br>
              j{{ $data->tema }}
          </p>
          <a class="btn btn-lg btn-primary" href="{{ url('sertifikat/cari') }}" role="button">Cari Sertifikat &raquo;</a>
          <a target="_blank" class="btn btn-lg btn-outline-success my-2 my-sm-0" href="{{ url('kirim_email') }}" role="button">Send Bulk Email</a>
        </div>
      </main>

      <div class="container">
        <h3>Daftar Seminar P3SM</h3>
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>No Sertifikat</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->peserta as $key)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $key->nama }}</td>
                        <td>{{ $key->status }}</td>
                        <td>{{ $key->no_sertifikat }}</td>
                        <td>{{ $key->email }}</td>
                        <td>
                          @if($data->id == 2)
                            <a target="_blank" href="{{ url('sertifikat_v1', [$key->no_sertifikat, $key->email]) }}" class="btn btn-outline-success my-2 my-sm-0"> Cetak Sertifikat</a>
                          @else
                            <a target="_blank" href="{{ url('sertifikat', [$key->no_sertifikat, $key->email]) }}" class="btn btn-outline-success my-2 my-sm-0"> Cetak Sertifikat</a>
                          @endif
                          <a target="_blank" href="{{ url('send_email', $key->id) }}" class="btn btn-outline-primary my-2 my-sm-0"> Kirim Email</a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
    <script >
$(document).ready(function() {
    $('#example').DataTable();
} );
    </script>



  </body>
</html>