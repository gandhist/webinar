@extends('frontend.main')

@section('content')
<div class="container">
  <h2>Registrasi Peserta Seminar P3SM</h2>
    <main role="main" class="container">
      @if(session()->get('success'))
        <div class="alert alert-success">
        {{ session()->get('success') }}  
        </div>
        <br />
      @endif
        <form action="{{ url('registrasi/store') }}" class="form-horizontal" id="formRegist" name="formRegist"
                method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="nama">Nama Lengkap*</label>
              <input oninvalid="this.setCustomValidity('Masukkan Nama Lengkap')" oninput="setCustomValidity('')" value="{{ old('nama') }}" id="nama" name="nama" type="text" required class="form-control" placeholder="Nama Lengkap">
              <span id="nama" class="invalid-feedback">{{ $errors->first('nama') }}</span>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="email">Email*</label>
              <input oninvalid="this.setCustomValidity('Masukkan Email ')" oninput="setCustomValidity('')" value="{{ old('email') }}" id="email" name="email" type="email" required class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Alamat Email">
              <span id="email" class="invalid-feedback">{{ $errors->first('email') }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="no_hp">No Handphone*</label>
              <input oninvalid="this.setCustomValidity('Masukkan No HP')" oninput="setCustomValidity('')" value="{{ old('no_hp') }}" id="no_hp" name="no_hp" type="number" required class="form-control {{ $errors->first('no_hp') ? 'is-invalid' : '' }}" placeholder="No Handphone">
              <span id="no_hp" class="invalid-feedback">{{ $errors->first('no_hp') }}</span>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="pekerjaan">Pekerjaan*</label>
              <input oninvalid="this.setCustomValidity('Masukkan Nama Pekerjaan')" oninput="setCustomValidity('')" value="{{ old('pekerjaan') }}" id="pekerjaan" name="pekerjaan" type="text" required class="form-control" placeholder="Pekerjaan">
              <span id="pekerjaan" class="invalid-feedback">{{ $errors->first('pekerjaan') }}</span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="instansi">Instansi*</label>
              <input oninvalid="this.setCustomValidity('Masukkan Nama Instansi')" oninput="setCustomValidity('')" value="{{ old('instansi') }}" id="instansi" name="instansi" type="text" required class="form-control" placeholder="Instansi (tempat kerja/sekolah)">
              <div id="instansi" class="invalid-feedback">{{ $errors->first('instansi') }}</div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="custom-file">
              <label for="instansi">Foto*</label>
              <div class="custom-file">
                <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto" class="custom-file-input {{ $errors->first('foto') ? 'is-invalid' : '' }}" id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div id="foto" class="invalid-feedback">{{ $errors->first('foto') }}</div>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-outline-info pull-center">Daftar</button>
        <a href="{{ url('registrasi') }}" class="btn btn-outline-info">Batal</a>
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