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
                            <input value="{{ old('no_hp') }}" id="no_hp" name="no_hp" 
                            onkeypress="return /[0-9]/i.test(event.key)"
                            type="text" required class="form-control" placeholder="No Handphone">
                            <span id="no_hp" class="invalid-feedback">{{ $errors->first('no_hp') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="provinsi">Provinsi*</label>
                                <select required value="{{ old('provinsi') }}" class="form-control" id="provinsi" name="provinsi">
                                    <option value="" selected hidden>-- Pilih Provinsi --</option>
                                    @forelse($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}"
                                        @if (old('provinsi') == $provinsi->id) selected="selected" @endif
                                        >{{ $provinsi->nama }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <span id="nik" class="invalid-feedback">{{ $errors->first('provinsi') }}</span>
                            </div>
                        </div>
                        

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="alamat">Alamat*</label>
                            <input value="{{ old('alamat') }}" id="alamat" name="alamat" type="text" required class="form-control" placeholder="Alamat">
                            <div id="alamat" class="invalid-feedback">{{ $errors->first('alamat') }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kota">Kota / Kabupaten*</label>
                                <select required value="{{ old('kota') }}" class="form-control" id="kota" name="kota">
                                    <option value="" selected hidden>-- Pilih Kota / Kabupaten --</option>
                                    @if(old('provinsi') != NULL)
                                        @foreach($kotas as $kota)
                                            @if($kota->provinsi_id == old('provinsi'))
                                                <option value="{{$kota->id}}"
                                                @if (old('kota') == $kota->id) selected="selected" @endif
                                                >{{$kota->nama}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <span id="nik" class="invalid-feedback">{{ $errors->first('kota') }}</span>
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
                                <select required value="{{ old('instansi') }}" class="form-control" id="instansi" name="instansi">
                                    <option value="" selected hidden>-- Pilih Instansi --</option>
                                    @forelse($bus as $bu)
                                        <option value="{{ $bu->id }}"
                                        @if (old('instansi') == $bu->id) selected="selected" @endif
                                        >{{ $bu->nama_bu }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <span id="instansi" class="invalid-feedback">{{ $errors->first('instansi') }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="nik">NIK* (Nomor Induk Kependudukan)</label>
                            <input value="{{ old('nik') }}" id="nik" name="nik" type="text" 
                            onkeypress="return /[0-9]/i.test(event.key)"
                            required class="form-control" maxlength="16">
                            <span id="nik" class="invalid-feedback">{{ $errors->first('nik') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="npwp">NPWP*</label>
                            <input value="{{ old('npwp') }}" id="npwp" name="npwp" type="text"
                            onkeypress="return /[0-9]/i.test(event.key)"
                            required class="form-control">
                            <div id="npwp" class="invalid-feedback">{{ $errors->first('npwp') }}</div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir*</label>
                            <input value="{{ old('tgl_lahir') }}" id="tgl_lahir" name="tgl_lahir" type="text" 
                            onkeypress="return /[0-9\-]/i.test(event.key)"
                            required class="form-control">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>

  $(document).ready(function () {
        $("#foto").change(function(){
            readURL(this);
        });
        $('#instansi').select2();
        $('#provinsi').select2();
        $('#provinsi').on('change', function(e){
            $('select[name="kota"]').empty();
            var id = e.target.value;
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
            $('#kota').select2();
        });
  });
  
    $('#tgl_lahir').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        minDate: '+0D',
    });
    $('#tgl_lahir').mask("99-99-9999",{placeholder:"HH-BB-TTTT"});

    $('#no_hp').attr('maxlength','15')
    $('#npwp').mask("99.999.999.9-999.999").attr('maxlength','20');

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