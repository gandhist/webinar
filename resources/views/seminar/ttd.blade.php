<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>{{ $nama->nama }}</title>
    <style>
      body{
        margin: 30px auto;
      }
      .p3sm-image {
            background-image: url("../p3sm1.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size:250px;
            position: relative;
        }

    </style>
  </head>
  <body>
    <div align=center>
    <div class="card mb-3" style="max-width: 800px;">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="{{ url($nama->lampiran_foto) }}" class="card-img" alt="Foto">
          </div>
          <div class="col-md-8">
            <div class="p3sm-image">
            <div class="card-body">
              <h5 class="card-title"> {{ $nama->nama }}</h5>
              <p class="card-text">Dokumen Sertifikat Seminar {{ $seminar->nama_seminar }}<br>
              dengan tema:<br>
              <span style="color:red; font-weight: bold; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">{{ strip_tags(html_entity_decode($seminar->tema)) }}</span></p>
              <p class="card-text"><small class="text-muted">Adalah sah, dan telah ditandatangani oleh<br>
                <strong>{{ $nama->nama }}</strong> selaku {{ $ttd->jabatan }}<br>
                dan tercatat dalam database <strong>P3SM</strong><br>
                Jl. Pluit Raya, Kav 12, Blok A5, Penjaringan, Jakarta Utara</small></p>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>



