@extends('templates.header')

@section('content')
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
    .horizontal-line {
        width:30%;
        height:0px;
        border-top:
        1px solid gray;
        margin:45px auto;
    }
</style>

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Tambahkan Instansi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Instansi</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron"  style='padding-top:1px'>

                <form method="POST" action="{{ url('instansi/store') }}" enctype="multipart/form-data">
                @csrf

                    <h1 style="margin-bottom:50px;">Data Instansi</h1>

                    <div class="row">

                        {{-- Nama Instansi --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('nama_bu')) ? ' has-error' : '' }}">
                                <label for="nama_bu" class="label-control required">Nama Instansi</label>
                                <input type="text" name="nama_bu" id="nama_bu"
                                    {{-- onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)" --}}
                                    value="{{ old('nama_bu') }}"
                                    class="form-control"
                                    placeholder="Nama Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('nama_bu') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Instansi --}}

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('email')) ? ' has-error' : '' }}">
                                <label for="email" class="label-control required">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder="Email Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Email --}}

                    </div>

                    <div class="row">

                        {{-- Nomor Telepon --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('telp')) ? ' has-error' : '' }}">
                                <label for="telp" class="label-control required">Nomor Telepon</label>
                                <input type="phone" name="telp" id="telp"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('telp') }}"
                                    class="form-control"
                                    placeholder="Nomor Telepon Instansi"
                                    maxlength="20"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('telp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Telepon --}}

                        {{-- Website Instansi --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('web')) ? ' has-error' : '' }}">
                                <label for="web" class="label-control required">Website</label>
                                <input type="url" name="web" id="web"
                                    value="{{ old('web') ? old('web') : 'https://' }}"
                                    class="form-control"
                                    placeholder="Website Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('web') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Instansi --}}
                    </div>

                    <div class="row">

                        {{-- Alamat --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('alamat')) ? ' has-error' : '' }}">
                                <label for="alamat" class="label-control required">Alamat</label>
                                <input type="text" name="alamat" id="alamat"
                                    value="{{ old('alamat') }}"
                                    class="form-control"
                                    placeholder="Alamat Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('alamat') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Alamat --}}

                        {{-- Negara --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('id_negara')) ? ' has-error' : '' }}">
                                <label for="id_negara" class="label-control required">Negara</label>
                                <select class="form-control" required disabled
                                id="id_negara" name="id_negara">
                                    <option value="102">Indonesia</option>
                                    {{--
                                        @forelse($negara as $key)
                                            <option value="{{$key->country_code}}"
                                            {{ old('id_negara' ? old('id_negara') : "selected")}}
                                            >
                                                {{$key->country_name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    --}}
                                </select>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('id_negara') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Negara --}}

                    </div>

                    <div class="row">

                    {{-- Provinsi --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('id_prop')) ? ' has-error' : '' }}">
                                <label for="id_prop" class="label-control required">Provinsi</label>
                                <select class="form-control" required
                                id="id_prop" name="id_prop">
                                    @if(old('id_prop'))
                                        @forelse($provinsi as $key)
                                            <option value="{{ $key->id }}"
                                                {{ old('id_prop') ? old('id_prop') : "selected" }}
                                            >
                                                {{ $key->nama }}
                                            </option>
                                        @empty
                                        @endforelse
                                    @else
                                        <option value="" selected hidden> -- Pilih Provinsi -- </option>
                                        @forelse($provinsi as $key)
                                            <option value="{{ $key->id }}">
                                                {{ $key->nama }}
                                            </option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('id_prop') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Provinsi --}}

                        {{-- Kota --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('id_kota')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="id_kota">Kota</label>
                                <select  class="form-control"
                                required id="id_kota" name="id_kota">
                                    @if(old('id_prop'))
                                        @foreach($kota as $key)
                                            @if($key->provinsi_id == old('id_prop'))
                                                <option value="{{$key->id}}"
                                                {{ (old('id_kota') == $key->id) ? "selected" : "" }}
                                                >{{$key->nama}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="" hidden> -- Pilih Kota -- </option>
                                        @foreach($kota as $key)
                                            @if($key->provinsi_id == old('id_prop'))
                                                <option value="{{$key->id}}"
                                                {{ (old('id_kota') == $key->id) ? "selected" : "" }}
                                                >{{$key->nama}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <div id="id_kota" class="invalid-feedback text-danger">
                                    {{ $errors->first('id_kota') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Kota --}}


                    </div>

                    <div class="row">

                        {{-- Nama Singkat --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('singkat_bu')) ? ' has-error' : '' }}">
                                <label for="singkat_bu" class="label-control required">Nama Singkat</label>
                                <input type="text" name="singkat_bu" id="singkat_bu"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('singkat_bu') }}"
                                    class="form-control"
                                    placeholder="Nama Singkat Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('singkat_bu') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Instansi --}}

                        <div class="col-md-6"></div>

                    </div>

                    <div class="horizontal-line"></div>

                    <div class="row">

                        {{-- Nama Pimpinan --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('nama_pimp')) ? ' has-error' : '' }}">
                                <label for="nama_pimp" class="label-control required">Nama Pimpinan</label>
                                <input type="text" name="nama_pimp" id="nama_pimp"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('nama_pimp') }}"
                                    class="form-control"
                                    placeholder="Nama Pimpinan"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('nama_pimp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Pimpinan --}}

                        {{-- Jabatan Pimpinan --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('jab_pimp')) ? ' has-error' : '' }}">
                                <label for="jab_pimp" class="label-control required">Jabatan Pimpinan</label>
                                <input type="text" name="jab_pimp" id="jab_pimp"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('jab_pimp') }}"
                                    class="form-control"
                                    placeholder="Jabatan Pimpinan"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('jab_pimp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Jabatan Pimpinan --}}

                    </div>

                    <div class="row">

                        {{-- Email Pimpinan --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('email_pimp')) ? ' has-error' : '' }}">
                                <label for="email_pimp" class="label-control required">Email Pimpinan</label>
                                <input type="email" name="email_pimp" id="email_pimp"
                                    value="{{ old('email_pimp') }}"
                                    class="form-control"
                                    placeholder="Email Pimpinan"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('email_pimp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Email Pimpinan--}}

                        {{-- Nomor Telepon Pimpinan --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('hp_pimp')) ? ' has-error' : '' }}">
                                <label for="hp_pimp" class="label-control required">Nomor Telepon Pimpinan</label>
                                <input type="phone" name="hp_pimp" id="hp_pimp"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('hp_pimp') }}"
                                    class="form-control"
                                    placeholder="Nomor Telepon Pimpinan"
                                    maxlength="20"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('hp_pimp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Telepon Pimpinan --}}

                    </div>

                    <div class="horizontal-line"></div>

                    <div class="row">

                        {{-- Contact Person --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('kontak_p')) ? ' has-error' : '' }}">
                                <label for="kontak_p" class="label-control required">Contact Person</label>
                                <input type="text" name="kontak_p" id="kontak_p"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('kontak_p') }}"
                                    class="form-control"
                                    placeholder="Contact Person Instansi"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('kontak_p') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Contact Person --}}

                        {{-- Jabatan Contact Person --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('jab_kontak_p')) ? ' has-error' : '' }}">
                                <label for="jab_kontak_p" class="label-control required">Jabatan Contact Person</label>
                                <input type="text" name="jab_kontak_p" id="jab_kontak_p"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('jab_kontak_p') }}"
                                    class="form-control"
                                    placeholder="Jabatan Contact Person"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('jab_kontak_p') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Jabatan Contact Person --}}

                    </div>

                    <div class="row">

                        {{-- Email Contact Person--}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('email_kontak_p')) ? ' has-error' : '' }}">
                                <label for="email_kontak_p" class="label-control required">Email Contact Person</label>
                                <input type="email" name="email_kontak_p" id="email_kontak_p"
                                    value="{{ old('email_kontak_p') }}"
                                    class="form-control"
                                    placeholder="Email Contact Person"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('email_kontak_p') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Email Contact Person--}}

                        {{-- Nomor Telepon Contact Person --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('no_kontak_p')) ? ' has-error' : '' }}">
                                <label for="no_kontak_p" class="label-control required">Nomor Telepon Contact Person</label>
                                <input type="phone" name="no_kontak_p" id="no_kontak_p"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('no_kontak_p') }}"
                                    class="form-control"
                                    placeholder="Nomor Telepon Contact Person"
                                    maxlength="20"
                                    required>
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('no_kontak_p') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Telepon Contact Person--}}

                    </div>

                    <div class="horizontal-line"></div>

                    <div class="row">

                        {{-- Nomor Rekening --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('no_rek')) ? ' has-error' : '' }}">
                                <label for="no_rek" class="label-control">Nomor Rekening</label>
                                <input type="text" name="no_rek" id="no_rek"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('no_rek') }}"
                                    class="form-control"
                                    placeholder="Nomor Rekening Instansi"
                                    maxlength="20"
                                >
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('no_rek') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Rekening --}}

                        {{-- Bank --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('id_bank')) ? ' has-error' : '' }}">
                                <label class="label-control" for="id_bank">Bank</label>
                                <select
                                class="form-control" id="id_bank" name="id_bank">
                                    @if(old('id_bank'))
                                        @forelse($bank as $key)
                                            <option value="{{ $key->id_bank }}"
                                            {{ (old('id_bank') == $key->id_bank) ? "selected" : "" }}
                                            >{{ $key->Nama_Bank }}</option>
                                        @empty
                                        @endforelse
                                    @else
                                        <option value="" hidden 'selected' }}>
                                            -- Pilih Bank --
                                        </option>
                                        @forelse($bank as $key)
                                            <option value="{{ $key->id_bank }}"
                                            {{ (old('id_bank') == $key->id_bank) ? "selected" : "" }}
                                            >{{ $key->Nama_Bank }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                                <div id="id_bank" class="invalid-feedback text-danger">
                                    {{ $errors->first('id_bank') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Bank --}}

                    </div>

                    <div class="row">

                        {{-- Nama Rekening --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('nama_rek')) ? ' has-error' : '' }}">
                                <label for="nama_rek" class="label-control">Nama pada Rekening</label>
                                <input type="text" name="nama_rek" id="nama_rek"
                                    onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)"
                                    value="{{ old('nama_rek') }}"
                                    class="form-control"
                                    placeholder="Nama pada Rekening"
                                >
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('nama_rek') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Rekening --}}

                        {{-- NPWP --}}
                        <div class="col-md-6">
                            <div class="form-group {{ ($errors->first('npwpClean')) ? ' has-error' : '' }}">
                                <label for="npwp" class="label-control">NPWP</label>
                                <input type="text" name="npwp" id="npwp"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    value="{{ old('npwp') }}"
                                    class="form-control"
                                    placeholder="Nomor Pokok Wajib Pajak"
                                >
                                <div class="invalid-feedback text-danger">
                                    {{ $errors->first('npwpClean') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir NPWP --}}

                    </div>

                    <div class="row">

                        {{-- Foto Lampiran NPWP --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('npwp_pdf')) ? ' has-error' : '' }}">
                                <div class="custom-file">
                                    <label class="label-control" for="npwp_pdf">Foto NPWP</label>
                                    <div class="custom-file">
                                        <input type="file" id="npwp_pdf" name="npwp_pdf" class="custom-file-input" id="npwp_pdf">
                                        <div id="npwp_pdf" class="invalid-feedback text-danger">
                                            {{ $errors->first('npwp_pdf') }}
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                                <small class="form-text text-muted">Format: pdf, jpeg, png, jpg, gif, svg</small>
                            </div>
                        </div>
                        {{-- Akhir Lampiran NPWP --}}

                        {{-- Logo Perusahaan --}}
                        <div class="col-md-6">
                            <div class="form-group  {{ ($errors->first('logo')) ? ' has-error' : '' }}">
                                <div class="custom-file">
                                    <label class="label-control required" for="logo">Logo Instansi</label>
                                    <div class="custom-file">
                                        <input type="file" id="logo" name="logo" class="custom-file-input" id="logo" required>
                                        <div id="logo" class="invalid-feedback text-danger">
                                            {{ $errors->first('logo') }}
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                                <small class="form-text text-muted">Format: jpeg, png, jpg, gif, svg</small>
                            </div>
                        </div>
                        {{-- Akhir Logo Perusahaan --}}

                    </div>

                    <br style="margin:20px;">

                    <div class="small text-danger pull-right">*) Wajib diisi</div>

                    <br style="margin:10px;">

                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">Registrasi</button>
                    </div>

                </form>
            </div> {{-- Jumbotron --}}
        </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>

    $(document).ready(function () {
        $('body').on('change', '.form-group', function() {
            // Action goes here.
        });
        $('#id_prop').select2(); // Select2
        $('#id_kota').select2(); // Select2
        $('#id_negara').select2(); // Select2
        $('#id_bank').select2(); // Select2 Bank


        // Ajax Untuk Kota, Onchange Provinsi
        $('#id_prop').on('change', function(e){
            $('select[name="id_kota"]').empty();
            var id = e.target.value;
            //
            if(id) {
                $.ajax({
                    url: '/instansi/create/getKota/'+id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="id_kota"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="id_kota"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="id_kota"]').empty();
            }
            //
            $('#id_kota').select2();
        });


        $('#npwp').mask("99.999.999.9-999.999",{placeholder:"Nomor Pokok Wajib Pajak"}).attr('maxlength','20');
    });
</script>
@endpush
