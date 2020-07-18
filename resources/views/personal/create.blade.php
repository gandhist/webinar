@extends('templates.header')

@section('content')

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Tambahkan Personal
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Personal</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron">
                <h1>Data Diri</h1>
                <form method="POST" action="{{ url('personals/store') }}" enctype="multipart/form-data">
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
                                <label for="provinsi">Provinsi*</label>
                                <select required value="{{ old('provinsi') }}" class="form-control" id="provinsi" name="provinsi">
                                    <option value="" selected hidden>-- Pilih Provinsi --</option>
                                    @forelse($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="alamat">Alamat*</label>
                            <input value="{{ old('alamat') }}" id="alamat" name="almat" type="text" required class="form-control" placeholder="Alamat">
                            <div id="alamat" class="invalid-feedback">{{ $errors->first('alamat') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kota">Kota / Kabupaten*</label>
                                <select required value="{{ old('kota') }}" class="form-control" id="kota" name="kota">
                                    <option value="" selected hidden>-- Pilih Kota / Kabupaten --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="pekerjaan">Pekerjaan*</label>
                            <input value="{{ old('pekerjaan') }}" id="pekerjaan" name="pekerjaan" type="text" required class="form-control" placeholder="Pekerjaan">
                            <span id="pekerjaan" class="invalid-feedback">{{ $errors->first('pekerjaan') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="instansi">Instansi*</label>
                            <input value="{{ old('instansi') }}" id="instansi" name="instansi" type="text" required class="form-control" placeholder="Instansi (tempat kerja/sekolah)">
                            <div id="instansi" class="invalid-feedback">{{ $errors->first('instansi') }}</div>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir*</label>
                            <input value="{{ old('tgl_lahir') }}" id="tgl_lahir" name="tgl_lahir" type="text" required class="form-control">
                            <div id="tgl_lahir" class="invalid-feedback">{{ $errors->first('tgl_lahir') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="custom-file">
                            <label for="instansi">Foto*</label>
                            <div class="custom-file">
                                <input type="file" id="foto" name="foto" class="custom-file-input {{ $errors->first('foto') ? 'is-invalid' : '' }}" id="validatedCustomFile" required>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div id="foto" class="invalid-feedback">{{ $errors->first('foto') }}</div>
                            </div>
                            </div>
                            <small class="form-text text-muted">Upload Max: 2MB</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <img id="blah" src="#" class="rounded hidden">
                            </div>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-info" style="margin-top:20px;">Registrasi</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
@push('script')
<script>
  $(document).ready(function () {
        $("#foto").change(function(){
            readURL(this);
        });

        $('#provinsi').on('change', function(e){
            var id = e.target.value;
            console.log(id);
            //
            if(id) {
                $.ajax({
                    url: '/personals/create/getKota/'+id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data)
                        $('select[name="kota"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kota"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="kota"]').empty();
            }
            //
        });
  });
  
    $('#tgl_lahir').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  };

</script>
@endpush