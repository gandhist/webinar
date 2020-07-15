<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
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
            <li class="nav-item">
              <a class="nav-link" href="{{ url('sertifikat') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="{{ url('sertifikat/cari') }}">Cari Sertifikat</a>
            </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <a href={{ route('login') }} class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</a>
          </form>
        </div>
      </nav>
  
      <main role="main" class="container">
        @if(session('status'))
        <div class="alert alert-danger" role="alert"> {{ session('status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          </div>
        @endif
        
        <div class="jumbotron">
            
          <h1>Cari Sertifikat</h1>
          <p class="lead">
              Cari Sertifikat anda dengan meng-inputkan no sertifikat dan email saat melakukan pendaftaraan seminar
          </p>
          
        </div>
      </main>

      <div class="container">
        <form method="get" action="{{ url('sertifikat/cari/') }}" target="_blank">
            <div class="form-group">
              <label for="exampleInputEmail1">No. Sertifikat</label>
              <input type="text" class="form-control" id="no_sertifikat" name="no_sertifikat" required placeholder="No Sertifikat">
              {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" required aria-describedby="emailHelp" class="form-control" id="email" name="email" placeholder="email">
            </div>
           
            <button type="submit" class="btn btn-primary">Cari</button>
          </form>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>