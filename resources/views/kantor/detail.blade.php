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
        Tambah Kantor PJS_LPJK - Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Kantor</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-content">
        <div class="box-body">
            <div class="container" style="min-height: 90vh">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <form method="POST" action="{{ url('kantor/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                {{-- Nama Kantor --}}
                                <div class="form-group {{ ($errors->first('nama_kantor')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="nama_kantor">Nama Kantor</label>
                                    <input type="text" name="nama_kantor" id="nama_kantor"
                                        {{-- onkeypress="return /[a-zA-Z\.\,\'\-\s]/i.test(event.key)" --}}
                                        value="{{ old('nama_kantor') }}"
                                        class="form-control"
                                        placeholder="Nama Kantor" required>
                                    <div id="nama_kantor" class="invalid-feedback text-danger">
                                        {{ $errors->first('nama_kantor') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Nama Singkat --}}
                                <div class="form-group {{ ($errors->first('nama_singkat')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="nama_singkat">Nama Singkat</label>
                                    <input type="text" name="nama_singkat" id="nama_singkat"
                                        value="{{ old('nama_singkat') }}"
                                        class="form-control"
                                        placeholder="Nama Singkat" required>
                                    <div id="nama_singkat" class="invalid-feedback text-danger">
                                        {{ $errors->first('nama_singkat') }}
                                    </div>
                                </div>
                                {{-- Akhir Nama Singkat --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Level --}}
                                <div class="form-group {{ ($errors->first('level')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="level">Level Kantor</label>
                                    <input type="text" name="level" id="level"
                                        value="{{ old('level') }}"
                                        class="form-control"
                                        placeholder="Level Kantor">
                                    <div id="level" class="invalid-feedback text-danger">
                                        {{ $errors->first('level') }}
                                    </div>
                                </div>
                                {{-- Akhir Level --}}
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                {{-- Level Kantor Di atasnya --}}
                                <div class="form-group {{ ($errors->first('level_atas')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="level_atas">Level Kantor di Atasnya</label>
                                    <input type="text" name="level_atas" id="level_atas"
                                        value="{{ old('level_atas') }}"
                                        class="form-control"
                                        placeholder="Level Kantor di Atasnya">
                                    <small class="text-muted">Hanya untuk selain level pusat</small>
                                    <div id="level_atas" class="invalid-feedback text-danger">
                                        {{ $errors->first('level_atas') }}
                                    </div>
                                </div>
                                {{-- Akhir Level Kantor Di atasnya --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            {{-- Alamat --}}
                            <div class="form-group {{ ($errors->first('alamat')) ? ' has-error' : '' }}">
                                <label class="label-control required" for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat"
                                    value="{{ old('alamat') }}"
                                    class="form-control"
                                    placeholder="Alamat" required>
                                <div id="email" class="invalid-feedback text-danger">
                                    {{ $errors->first('alamat') }}
                                </div>
                            </div>
                            {{-- Akhir Alamat --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Provinsi --}}
                                <div class="form-group {{ ($errors->first('alamat')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="prop">Provinsi</label>
                                    <input type="text" name="prop" id="prop"
                                        value="{{ old('prop') }}"
                                        class="form-control"
                                        placeholder="Alamat" required>
                                    <div id="prop" class="invalid-feedback text-danger">
                                        {{ $errors->first('prop') }}
                                    </div>
                                </div>
                                {{-- Akhir Provinsi --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kota --}}
                                <div class="form-group {{ ($errors->first('kota')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="kota">Kota</label>
                                    <input type="text" name="kota" id="kota"
                                        value="{{ old('kota') }}"
                                        class="form-control"
                                        placeholder="kota" required>
                                    <div id="kota" class="invalid-feedback text-danger">
                                        {{ $errors->first('kota') }}
                                    </div>
                                </div>
                                {{-- Akhir Kota --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- No Telp --}}
                                <div class="form-group {{ ($errors->first('no_tlp')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="no_tlp">Nomor Telepon</label>
                                    <input type="text" name="no_tlp" id="no_tlp"
                                        onkeypress="return /[0-9]/i.test(event.key)"
                                        value="{{ old('no_tlp') }}"
                                        class="form-control"
                                        placeholder="Nomor Telepon" required
                                        maxlength="14">
                                    <div id="no_tlp" class="invalid-feedback text-danger">
                                        {{ $errors->first('no_tlp') }}
                                    </div>
                                </div>
                                {{-- Akhir No Telp --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Email --}}
                                <div class="form-group {{ ($errors->first('email')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="email">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email') }}"
                                        class="form-control"
                                        placeholder="Email" required>
                                    <div id="email" class="invalid-feedback text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                </div>
                                {{-- Akhir Email --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Instansi Reff --}}
                                <div class="form-group {{ ($errors->first('instansi_reff')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="instansi_reff">Instansi Reff</label>
                                    <input type="text" name="instansi_reff" id="instansi_reff"
                                        value="{{ old('instansi_reff') }}"
                                        class="form-control"
                                        placeholder="Instansi Reff">
                                    <div id="instansi_reff" class="invalid-feedback text-danger">
                                        {{ $errors->first('instansi_reff') }}
                                    </div>
                                </div>
                                {{-- Akhir Instansi Reff --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Website --}}
                                <div class="form-group {{ ($errors->first('web')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="web">Website</label>
                                    <input type="text" name="web" id="web"
                                        value="{{ old('web') }}"
                                        class="form-control"
                                        placeholder="Website">
                                    <div id="web" class="invalid-feedback text-danger">
                                        {{ $errors->first('web') }}
                                    </div>
                                </div>
                                {{-- Akhir Website --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Nama Pimpinan --}}
                                <div class="form-group {{ ($errors->first('nama_pimp')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="nama_pimp">Nama Pimpinan</label>
                                    <input type="text" name="nama_pimp" id="nama_pimp"
                                        value="{{ old('nama_pimp') }}"
                                        class="form-control"
                                        placeholder="Nama Pimpinan">
                                    <div id="nama_pimp" class="invalid-feedback text-danger">
                                        {{ $errors->first('nama_pimp') }}
                                    </div>
                                </div>
                                {{-- Akhir Nama Pimpinan --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Jabatan Pimpinan --}}
                                <div class="form-group {{ ($errors->first('jab_pimp')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="jab_pimp">Jabatan Pimpinan</label>
                                    <input type="text" name="jab_pimp" id="jab_pimp"
                                        value="{{ old('jab_pimp') }}"
                                        class="form-control"
                                        placeholder="Jabatan Pimpinan">
                                    <div id="jab_pimp" class="invalid-feedback text-danger">
                                        {{ $errors->first('jab_pimp') }}
                                    </div>
                                </div>
                                {{-- Akhir Jabatan Pimpinan --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Nomor Telepon Pimpinan --}}
                                <div class="form-group {{ ($errors->first('hp_pimp')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="hp_pimp">Nomor Telepon Pimpinan</label>
                                    <input type="text" name="hp_pimp" id="hp_pimp"
                                        onkeypress="return /[0-9]/i.test(event.key)"
                                        value="{{ old('hp_pimp') }}"
                                        class="form-control"
                                        placeholder="Nomor Telepon Pimpinan">
                                    <div id="hp_pimp" class="invalid-feedback text-danger">
                                        {{ $errors->first('hp_pimp') }}
                                    </div>
                                </div>
                                {{-- Akhir Nomor Telepon Pimpinan --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Email Pimpinan --}}
                                <div class="form-group {{ ($errors->first('email_pimp')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="alamat">Email Pimpinan</label>
                                    <input type="email" name="email_pimp" id="email_pimp"
                                        value="{{ old('email_pimp') }}"
                                        class="form-control"
                                        placeholder="Email Pimpinan">
                                    <div id="email_pimp" class="invalid-feedback text-danger">
                                        {{ $errors->first('email_pimp') }}
                                    </div>
                                </div>
                                {{-- Akhir Email Pimpinan --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Nama Kontak Person --}}
                                <div class="form-group {{ ($errors->first('kontak_p')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="kontak_p">Nama Kontak Person</label>
                                    <input type="text" name="kontak_p" id="kontak_p"
                                        value="{{ old('kontak_p') }}"
                                        class="form-control"
                                        placeholder="Nama Kontak Person" required>
                                    <div id="kontak_p" class="invalid-feedback text-danger">
                                        {{ $errors->first('kontak_p') }}
                                    </div>
                                </div>
                                {{-- Akhir Nama Kontak Person --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Jabatan Kontak Person --}}
                                <div class="form-group {{ ($errors->first('jab_kontak_p')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="jab_kontak_p">Jabatan Kontak Person</label>
                                    <input type="text" name="jab_kontak_p" id="jab_kontak_p"
                                        value="{{ old('jab_kontak_p') }}"
                                        class="form-control"
                                        placeholder="Jabatan Kontak Person">
                                    <div id="jab_kontak_p" class="invalid-feedback text-danger">
                                        {{ $errors->first('jab_kontak_p') }}
                                    </div>
                                </div>
                                {{-- Akhir Jabatan Kontak Person --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {{-- Nomor Telepon Kontak Person --}}
                                <div class="form-group {{ ($errors->first('no_kontak_p')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="no_kontak_p">Nomor Telepon Kontak Person</label>
                                    <input type="text" name="no_kontak_p" id="no_kontak_p"
                                        onkeypress="return /[0-9]/i.test(event.key)"
                                        value="{{ old('no_kontak_p') }}"
                                        class="form-control"
                                        placeholder="Nomor Telepon Kontak Person" required>
                                    <div id="no_kontak_p" class="invalid-feedback text-danger">
                                        {{ $errors->first('no_kontak_p') }}
                                    </div>
                                </div>
                                {{-- Akhir Nomor Telepon Kontak Person --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Kozong --}}
                            </div>
                            <div class="col-md-4">
                                {{-- Email Kontak Person --}}
                                <div class="form-group {{ ($errors->first('email_kontak_p')) ? ' has-error' : '' }}">
                                    <label class="label-control required" for="email_kontak_p">Email Kontak Person</label>
                                    <input type="email" name="email_kontak_p" id="email_kontak_p"
                                        value="{{ old('email_kontak_p') }}"
                                        class="form-control"
                                        placeholder="Email Kontak Person" required>
                                    <div id="email_kontak_p" class="invalid-feedback text-danger">
                                        {{ $errors->first('email_kontak_p') }}
                                    </div>
                                </div>
                                {{-- Akhir Email Kontak Person --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{-- Keterangan --}}
                                <div class="form-group {{ ($errors->first('keterangan')) ? ' has-error' : '' }}">
                                    <label class="label-control" for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan"
                                        value="{{ old('keterangan') }}"
                                        class="form-control"
                                        placeholder="keterangan">
                                    <div id="keterangan" class="invalid-feedback text-danger">
                                        {{ $errors->first('keterangan') }}
                                    </div>
                                </div>
                                {{-- Akhir Keterangan --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="small text-danger">*) Wajib diisi</div>
                                <button type="submit" class="btn btn-success" style="margin-top:20px;">Simpan</button>
                            </div>
                        </div>
    
                        {{-- <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">

                            </div>
                        </div> --}}
                        </form>
                    </div>
                </div>
            </div> {{-- Container  --}}
        </div> {{-- Box Body --}}
    </div> {{-- Box Content --}}
</section>

@endsection
