@extends('frontend.main')

@section('content')
<div class="container">
  <h2>Halaman Registrasi Peserta Seminar P3SM</h2>
    <main role="main" class="container">
      <form method="POST" action="{{ url('registrasi/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">

          <div class="col-lg-6">
            <div class="form-group">
              <label for="nama">Nama Lengkap*</label>
              <input value="{{ old('nama') }}" id="nama" name="nama" type="text" required class="form-control" placeholder="Nama Lengkap">
              <span id="nama" class="invalid-feedback">{{ $errors->first('nama') }}</span>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="email">Email*</label>
              <input value="{{ old('email') }}" id="email" name="email" type="email" required class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Alamat Email">
              <span id="email" class="invalid-feedback">{{ $errors->first('email') }}</span>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="form-group">
              <label for="no_hp">No Handphone*</label>
              <input value="{{ old('no_hp') }}" id="no_hp" name="no_hp" type="number" required class="form-control" placeholder="No Handphone">
              <span id="no_hp" class="invalid-feedback">{{ $errors->first('no_hp') }}</span>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="pekerjaan">Pekerjaan*</label>
              <input value="{{ old('pekerjaan') }}" id="pekerjaan" name="pekerjaan" type="text" required class="form-control" placeholder="Pekerjaan">
              <span id="pekerjaan" class="invalid-feedback">{{ $errors->first('pekerjaan') }}</span>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="form-group">
              <label for="instansi">Instansi*</label>
              <input value="{{ old('instansi') }}" id="instansi" name="instansi" type="text" required class="form-control" placeholder="Instansi (tempat kerja/sekolah)">
              <div id="instansi" class="invalid-feedback">aa{{ $errors->first('instansi') }}</div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="custom-file">
              <label for="instansi">Foto*</label>
              <div class="custom-file">
                <input type="file" id="foto" name="foto" class="custom-file-input {{ $errors->first('foto') ? 'is-invalid' : '' }}" id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div id="foto" class="invalid-feedback">{{ $errors->first('foto') }}</div>
              </div>
            </div>
              {{-- <small class="form-text text-muted">Upload Max:5MB, Format (.JPG)</small> --}}
          </div>
          <div class="col-lg-2">
            <div class="text-center">
              <img id="blah" src="#" class="rounded">
            </div>
          </div>

        </div>

        <button type="submit" class="btn btn-outline-info">Registrasi</button>

      </form>
    </main>
        
</div>

@endsection
@push('script')
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