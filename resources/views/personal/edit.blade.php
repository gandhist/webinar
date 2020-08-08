@extends('templates.header')

@section('content')
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>


<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Edit Personal
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Personal</a></li>
        <li class="active"><a href="#"> Edit</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron" style='padding-top:1px'>
                <h1 style="margin-bottom: 25px;">Data Diri</h1>
                <form method="POST" action="{{ url('personals/update') }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                    <div class="row">
                        {{-- Nama --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('nama')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="nama">Nama</label>
                                <input type="text" name="nama" id="nama"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('nama') ? old('nama') : $personal->nama }}"
                                    class="form-control"
                                    placeholder="Nama Lengkap" required>
                                <div id="nama" class="invalid-feedback text-danger">
                                    {{ $errors->first('nama') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama --}}

                        {{-- NIK --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('nik')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="nik">NIK</label>
                                <input type="text" name="nik" id="nik"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('nik') ? old('nik') : $personal->nik }}"
                                    class="form-control
                                        @if($errors->first('nik'))
                                            has-error
                                        @endif"
                                    placeholder="Nomor Induk Kependudukan" required
                                    maxlength="16">
                                <div id="nik" class="invalid-feedback text-danger">
                                    {{ $errors->first('nik') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir NIK --}}

                    </div>

                    <div class="row">

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('email')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email') ? old('email') : $personal->email}}"
                                    class="form-control"
                                    placeholder="Email" required>
                                <div id="email" class="invalid-feedback text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Email --}}

                        {{-- Nomor Telepon --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('no_hp')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="no_hp">Nomor Telepon</label>
                                <input type="text" name="no_hp" id="no_hp"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('no_hp') ? old('no_hp') : $personal->no_hp }}"
                                    class="form-control
                                        @if($errors->first('no_hp'))
                                            has-error
                                        @endif"
                                    placeholder="Nomor Telepon" required
                                    maxlength="14">
                                <div id="no_hp" class="invalid-feedback text-danger">
                                    {{ $errors->first('no_hp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Telepon --}}

                    </div>

                    <div class="row">


                        {{-- Instansi --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('instansi')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="instansi">Instansi</label>
                                <select required
                                class="form-control" id="instansi" name="instansi">
                                    <option value="" hidden
                                    {{ (old('instansi')) ? '' : 'selected' }}>
                                        -- Instansi --
                                    </option>
                                    @if(old('instansi'))
                                        @forelse($bus as $bu)
                                            <option value="{{ $bu->id }}"
                                           {{ (old('instansi') == $bu->id) ? "selected" : "" }}
                                            >{{ $bu->nama_bu }}</option>
                                        @empty
                                        @endforelse
                                    @else
                                        @forelse($bus as $bu)
                                            <option value="{{ $bu->id }}"
                                            {{ ($personal->instansi == $bu->id) ? "selected" : "" }}
                                            >{{ $bu->nama_bu }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div id="instansi" class="invalid-feedback text-danger">
                                    {{ $errors->first('instansi') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Instansi --}}

                        {{-- Jabatan --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('jabatan')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="jabatan">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{  old('jabatan') ? old('jabatan') : $personal->jabatan }}"
                                    class="form-control"
                                    placeholder="Jabatan" required>
                                <div id="jabatan" class="invalid-feedback text-danger">
                                    {{ $errors->first('jabatan') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Jabatan --}}

                    </div>

                    <div class="row">

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('jenis_kelamin')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="jenis_kelamin">Jenis Kelamin</label>
                                <select required
                                class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="" hidden>
                                        --Pilih Jenis Kelamin--
                                    </option>
                                    @if(old('jenis_kelamin'))
                                        <option value="L"
                                        {{ (old('jenis_kelamin') == 'L') ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="P"
                                        {{ (old('jenis_kelamin') == 'P') ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    @else
                                        <option value="L"
                                        {{ ($personal->jenis_kelamin == 'L') ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="P"
                                        {{ ($personal->jenis_kelamin == 'P') ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    @endif
                                </select>
                                <div id="jenis_kelamin" class="invalid-feedback text-danger">
                                    {{ $errors->first('jenis_kelamin') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Jenis Kelamin --}}

                        {{-- Alamat --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('alamat')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="alamat">Alamat</label>
                                <input type="alamat" name="alamat" id="alamat"
                                    value="{{ old('alamat') ? old('alamat') : $personal->alamat}}"
                                    class="form-control"
                                    placeholder="Alamat" required>
                                <div id="email" class="invalid-feedback text-danger">
                                    {{ $errors->first('alamat') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Alamat --}}

                    </div>

                    <div class="row">

                        {{-- Provinsi --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('provinsi')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="provinsi">Provinsi</label>
                                <select required
                                class="form-control" id="provinsi" name="provinsi">
                                    <option value="" hidden
                                    {{ (old('provinsi')) ? '' : 'selected' }}>
                                        -- Pilih Provinsi --
                                    </option>
                                    @if(old('provinsi'))
                                        @forelse($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}"
                                            {{ (old('provinsi') == $provinsi->id) ? "selected" : "" }}
                                            >{{ $provinsi->nama }}</option>
                                        @empty
                                        @endforelse
                                    @else
                                        @forelse($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}"
                                            {{ ( $personal->provinsi_id == $provinsi->id) ? "selected" : "" }}
                                            >{{ $provinsi->nama }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div id="provinsi" class="invalid-feedback text-danger">
                                    {{ $errors->first('provinsi') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Provinsi --}}

                        {{-- Kota --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('kota')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="kota">Kota</label>
                                <select required
                                class="form-control" id="kota" name="kota">
                                    <option value="" hidden
                                    {{ (old('kota')) ? '' : 'selected' }}>
                                        -- Pilih Kota --
                                    </option>
                                    @if(old('provinsi'))
                                        @foreach($kotas as $kota)
                                            @if($kota->provinsi_id == old('provinsi'))
                                                <option value="{{$kota->id}}"
                                                @if (old('kota') == $kota->id) selected="selected" @endif
                                                >{{$kota->nama}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($kotas as $kota)
                                            @if($kota->provinsi_id == $personal->provinsi_id)
                                                <option value="{{$kota->id}}"
                                                @if ($personal->kota_id == $kota->id) selected="selected" @endif
                                                >{{$kota->nama}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <div id="kota" class="invalid-feedback text-danger">
                                    {{ $errors->first('kota') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Kota --}}

                    </div>


                    <div class="row">

                        {{-- Tempat Lahir --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('temp_lahir')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="temp_lahir">Tempat Lahir</label>
                                <select required
                                class="form-control" id="temp_lahir" name="temp_lahir">
                                    <option value="" hidden
                                    {{ (old('temp_lahir')) ? '' : 'selected' }}>
                                    -- Pilih Tempat Lahir --
                                    </option>
                                    @if(old('kota_id'))
                                        @forelse($kotas as $kota)
                                            <option value="{{ $kota->id }}"
                                            {{ (old('temp_lahir') == $kota->id) ? "selected" : "" }}
                                            >{{ $kota->nama }}</option>
                                        @empty
                                        @endforelse
                                    @else
                                        @forelse($kotas as $kota)
                                            <option value="{{ $kota->id }}"
                                            {{ ($personal->temp_lahir == $kota->id) ? "selected" : "" }}
                                            >{{ $kota->nama }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div id="temp_lahir" class="invalid-feedback text-danger">
                                    {{ $errors->first('temp_lahir') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Tempat Lahir --}}

                        {{-- Tanggal Lahir --}}
                        @php
                            $tgl_lama = explode("-",$personal->tgl_lahir);
                            $tgl_baru = array_reverse($tgl_lama);
                            $tgl_lahir = implode("-",$tgl_baru)
                        @endphp

                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('tgl_lahir')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="tgl_lahir">Tanggal Lahir</label>
                                <input type="text" name="tgl_lahir" id="tgl_lahir"
                                    value="{{ old('tgl_lahir') ? old('tgl_lahir') : $tgl_lahir }}"
                                    class="form-control"
                                    required>
                                <div id="tgl_lahir" class="invalid-feedback text-danger">
                                    {{ $errors->first('tgl_lahir') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Tanggal Lahir --}}
                    </div>






                    <div class="row">

                        {{-- Nomor Rekening --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('no_rek')) ? ' has-error' : '' }}">
                                <label class="label-control" for="no_rek">Nomor Rekening</label>
                                <input type="text" name="no_rek" id="no_rek"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('no_rek') ? old('no_rek') : $personal->no_rek }}"
                                    class="form-control
                                        @if($errors->first('no_rek'))
                                            has-error
                                        @endif"
                                    placeholder="Nomor Rekening"
                                    maxlength="20">
                                <div id="no_rek" class="invalid-feedback text-danger">
                                    {{ $errors->first('no_rek') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Rekening --}}

                        {{-- Bank --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('bank_id')) ? ' has-error' : '' }}">
                                <label class="label-control" for="bank_id">Bank</label>
                                <select
                                class="form-control" id="bank_id" name="bank_id">
                                    <option value="" hidden
                                    {{ (old('bank_id')) ? '' : 'selected' }}>
                                        -- Pilih Bank --
                                    </option>
                                    @if(old('bank_id'))
                                        @forelse($banks as $bank)
                                            <option value="{{ $bank->id_bank }}"
                                            {{ (old('bank_id') == $bank->id_bank) ? "selected" : "" }}
                                            >{{ $bank->Nama_Bank }}</option>
                                        @empty
                                        @endforelse
                                    @else
                                        @forelse($banks as $bank)
                                            <option value="{{ $bank->id_bank }}"
                                            {{ ($personal->id_bank == $bank->id_bank) ? "selected" : "" }}
                                            >{{ $bank->Nama_Bank }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div id="bank_id" class="invalid-feedback text-danger">
                                    {{ $errors->first('bank_id') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Bank --}}

                    </div>


                    <div class="row">

                        {{-- Nama Rekening--}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('nama_rek')) ? ' has-error' : '' }}">
                                <label class="label-control" for="nama_rek">Nama Pada Rekening</label>
                                <input type="text" name="nama_rek" id="nama_rek"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('nama_rek') ? old('nama_rek') : $personal->nama_rek }}"
                                    class="form-control"
                                    placeholder="Nama Rekening">
                                <div id="nama" class="invalid-feedback text-danger">
                                    {{ $errors->first('nama_rek') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Rekening --}}

                        {{-- NPWP --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('npwpClean')) ? ' has-error' : '' }}">
                                <label class="label-control" for="npwp">NPWP</label>
                                <input type="text" name="npwp" id="npwp"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('npwp') ? old('npwp') : $personal->npwp }}"
                                    class="form-control
                                        @if($errors->first('npwpClean'))
                                            has-error
                                        @endif"
                                    placeholder="Nomor Pokok Wajib Pajak"
                                    {{ $errors->first('npwpClean') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir NPWP --}}

                    </div>

                    <div class="row">

                        {{-- Lampiran KTP --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('lampiran_ktp')) ? ' has-error' : '' }}">
                                <div class="custom-file">
                                    <label class="label-control" for="lampiran_ktp">Foto KTP</label>
                                    <div class="custom-file">
                                        <input type="file" id="lampiran_ktp" name="lampiran_ktp" class="custom-file-input" id="lampiran_ktp">
                                        <div id="lampiran_ktp" class="invalid-feedback text-danger">
                                            {{ $errors->first('lampiran_ktp') }}
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                                <small class="form-text text-muted">Format: pdf, jpeg, png, jpg, gif, svg</small>
                            </div>
                        </div>
                        {{-- Akhir Lampiran KTP --}}



                        {{-- Foto Lampiran NPWP --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('lampiran_npwp')) ? ' has-error' : '' }}">
                                <div class="custom-file">
                                    <label class="label-control" for="lampiran_npwp">Foto NPWP</label>
                                    <div class="custom-file">
                                        <input type="file" id="lampiran_npwp" name="lampiran_npwp" class="custom-file-input" id="lampiran_npwp">
                                        <div id="lampiran_npwp" class="invalid-feedback text-danger">
                                            {{ $errors->first('lampiran_npwp') }}
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                                <small class="form-text text-muted">Format: pdf, jpeg, png, jpg, gif, svg</small>
                            </div>
                        </div>
                        {{-- Akhir Lampiran NPWP --}}

                    </div>


                    <div class="row">

                        {{-- Foto Diri --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('foto')) ? ' has-error' : '' }}">
                                <div class="custom-file">
                                    <label class="label-control" for="foto">Foto</label>
                                    <div class="custom-file">
                                        <input type="file" id="foto" name="foto" class="custom-file-input" id="foto">
                                        <div id="foto" class="invalid-feedback text-danger">
                                            {{ $errors->first('foto') }}
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                                <small class="form-text text-muted">Format: jpeg, png, jpg, gif, svg</small>
                            </div>
                        </div>
                        {{-- Akhir Foto Diri --}}

                        {{-- Referensi Pendaftaran --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('reff_p')) ? ' has-error' : '' }}">
                                <label class="label-control" for="reff_p">Referensi Pendaftaran</label>
                                <input type="text" name="reff_p" id="reff_p"
                                    value="{{ old('reff_p') ? old('reff_p') : $personal->reff_p }}"
                                    class="form-control"
                                    placeholder="Referensi Pendaftaran">
                                <div id="reff_p" class="invalid-feedback text-danger">
                                    {{ $errors->first('reff_p') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Referensi Pendaftaran --}}
                        <input type="hidden" name="id" value="{{$id}}">

                    </div>
                    <div class="small text-danger">*) Wajib diisi</div>
                    <button type="submit" class="btn btn-success" style="margin-top:20px;">Edit</button>

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
        $('#provinsi').select2(); // Select2 Provinsi
        $('#instansi').select2(); // Select2 instansi
        $('#kota').select2(); // Select2 Kota
        $('#temp_lahir').select2(); // Select2 Tempat Lahir
        $('#bank_id').select2(); // Select2 Bank
        $('#jenis_kelamin').select2(); // Select2 JK

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
    });
    $('#tgl_lahir').mask("99-99-9999",{placeholder:"HH-BB-TTTT"});

    $('#no_hp').attr('maxlength','15')
    $('#npwp').mask("99.999.999.9-999.999").attr('maxlength','20');

    $('div.form-group').on('change',function(e) {
        $( e ).removeClass( "has-error" )
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
