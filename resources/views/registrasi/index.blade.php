@extends('frontend.main')

@section('content')

<style>
  form label.required:after {
      color: red;
      content: " *";
  }
  p {
      color: red;
  }
  .form-group{
      padding-top:10px;
  }


  .button-flash {
  background-color: #004A7F;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: Arial;
  font-size: 20px;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;
  }
  @-webkit-keyframes glowing {
  0% { background-color: #141414; -webkit-box-shadow: 0 0 3px #141414; }
  50% { background-color: #343a40; -webkit-box-shadow: 0 0 40px #343a40; }
  100% { background-color: #141414; -webkit-box-shadow: 0 0 3px #141414; }
  }

  @-moz-keyframes glowing {
  0% { background-color: #141414; -moz-box-shadow: 0 0 3px #141414; }
  50% { background-color: #343a40; -moz-box-shadow: 0 0 40px #343a40; }
  100% { background-color: #141414; -moz-box-shadow: 0 0 3px #141414; }
  }

  @-o-keyframes glowing {
  0% { background-color: #141414; box-shadow: 0 0 3px #141414; }
  50% { background-color: #343a40; box-shadow: 0 0 40px #343a40; }
  100% { background-color: #141414; box-shadow: 0 0 3px #141414; }
  }

  @keyframes glowing {
  0% { background-color: #141414; box-shadow: 0 0 3px #141414; }
  50% { background-color: #343a40; box-shadow: 0 0 40px #343a40; }
  100% { background-color: #141414; box-shadow: 0 0 3px #141414; }
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<script>
    FontAwesomeConfig = { autoReplaceSvg: false }
</script>
<div class="container" id="content">

    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-8">
            @if(session()->get('success'))
            <div class="alert alert-success">{{ session()->get('success') }}
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            @if(session()->get('pesan'))
              <div class="alert alert-warning">{!! session()->get('pesan') !!}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              </div>
            @endif

            <h2 style="margin-top: -15px;">Registrasi Akun App PPKB Online P3S Mandiri</h2>
            <hr>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <main role="main" class="container">
      <form action="{{ url('registrasi/store') }}" class="form-horizontal" id="formRegist" name="formRegist"
              method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="nama" class="label-control required"><b>Nama dan Gelar Akademik</b></label>
                      <input oninvalid="this.setCustomValidity('Masukkan Nama Lengkap')" oninput="setCustomValidity('')" value="{{ old('nama') }}" id="nama" name="nama" type="text" required class="form-control" placeholder="Nama Lengkap">
                      <span id="nama" class="invalid-feedback">{{ $errors->first('nama') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="email" class="label-control required"><b>Email</b></label>
                      <input oninvalid="this.setCustomValidity('Masukkan Email ')" oninput="setCustomValidity('')" value="{{ old('email') }}" id="email" name="email" type="email" required class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Alamat Email">
                      <span id="email" class="invalid-feedback">{{ $errors->first('email') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="no_hp" class="label-control required"><b>Nomor Handphone (Whatsapp)</b></label>
                      <input oninvalid="this.setCustomValidity('Masukkan No HP')" oninput="setCustomValidity('')" value="{{ old('no_hp') }}" id="no_hp" name="no_hp" type="number" required class="form-control {{ $errors->first('no_hp') ? 'is-invalid' : '' }}" placeholder="No Handphone">
                      <span id="no_hp" class="invalid-feedback">{{ $errors->first('no_hp') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="instansi" class="label-control required"><b>Institusi</b></label>
                      <input oninvalid="this.setCustomValidity('Masukkan Nama Institusi')" oninput="setCustomValidity('')" value="{{ old('instansi') }}" id="instansi" name="instansi" type="text" required class="form-control" placeholder="Tempat Kerja atau Tempat Studi (spesifik)">
                      <span id="instansi" class="invalid-feedback">{{ $errors->first('instansi') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
              <div class="col-lg-12">
                  <div class="form-group">
                      <label for="pekerjaan" class="label-control required"><b>Jabatan pada institusi terkait</b></label>
                      <input oninvalid="this.setCustomValidity('Masukkan Nama Jabatan')" oninput="setCustomValidity('')" value="{{ old('pekerjaan') }}" id="pekerjaan" name="pekerjaan" type="text" required class="form-control" placeholder="Jabatan">
                      <span id="pekerjaan" class="invalid-feedback">{{ $errors->first('pekerjaan') }}</span>
                  </div>
              </div>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      <br>
      {{-- <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="foto" class="label-control required"><b>Foto</b></label>
                    <div class="custom-file">
                      <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto" class="custom-file-input {{ $errors->first('foto') ? 'is-invalid' : '' }}" id="validatedCustomFile" required>
                      <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                      <div id="foto" class="invalid-feedback">{{ $errors->first('foto') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
        </div>
      </div>
      <br> --}}
      <div class="row">
          <div class="col-lg-2">
            @if(session()->get('magic_link'))
            <input type="hidden" name="magic_link" value="{{ session()->get('magic_link') }}">
            @endif
          </div>
          <div class="col-lg-8" style="width: 100%;">
              <button type="submit" class="btn button-flash btn-block">SUBMIT</button>
          </div>
          <div class="col-lg-2">
          </div>
      </div>
      </form>
  </main>

</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>
  $(document).ready(function () {
    $("#foto").change(function(){
        readURL(this);
    });
  })

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

</script>
@endpush
