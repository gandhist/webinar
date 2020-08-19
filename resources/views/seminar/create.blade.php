@extends('templates.header')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
{{-- {{old('tuk') ? dd(old('tuk')) : ''}} --}}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tambahkan Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron" style='padding-top:1px'>
                <h1 style="margin-bottom:50px;">Seminar</h1>
                <form method="POST" action="{{ url('seminar/store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Nama Seminar --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('nama_seminar') ? 'has-error' : '' }}">
                            <label for="nama_seminar" class="label-control required">Nama Seminar</label>
                            <input type="text" id="nama_seminar" class="form-control" name="nama_seminar"
                            placeholder="Nama Seminar" required
                            value="{{ old('nama_seminar') ? old('nama_seminar') : '' }}">
                            <div id="nama_seminar" class="invalid-feedback text-danger">
                                {{ $errors->first('nama_seminar') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Nama Seminar --}}


                    {{-- Klasifikasi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('klasifikasi') ? 'has-error' : '' }}">
                            <label for="klasifikasi" class="label-control required">Klasifikasi</label>
                            {{-- <select name="klasifikasi[]" multiple="multiple"
                            id="klasifikasi" class="form-control"> --}}
                            <select name="klasifikasi"  required
                            id="klasifikasi" class="form-control">
                            <option value="" selected hidden>Pilih Klasifikasi</option>
                            @if(old('klasifikasi'))
                                @foreach($klasifikasi as $key)
                                    <option value="{{ $key->ID_Bidang_Profesi }}"
                                    {{ old('klasifikasi') == $key->ID_Bidang_Profesi? 'selected' : '' }}>
                                            {{$key->Deskripsi}}
                                    </option>
                                @endforeach
                            @else
                                @foreach($klasifikasi as $key)
                                    <option value="{{ $key->ID_Bidang_Profesi}}">{{$key->Deskripsi}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div id="klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('klasifikasi') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Klasifikasi --}}

                    {{-- Sub Klasifikasi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('sub_klasifikasi') ? 'has-error' : '' }}">
                            <label for="sub_klasifikasi" class="label-control required">Sub-klasifikasi</label>
                            {{-- <select name="sub_klasifikasi[]" multiple="multiple"
                            id="sub_klasifikasi" class="form-control"> --}}
                            <select name="sub_klasifikasi"  required
                            id="sub_klasifikasi" class="form-control">
                                @if (old('klasifikasi'))
                                    @foreach ($sub_klasifikasi as $key)
                                        @if ($key->ID_Keahlian == old('klasifikasi'))
                                            <option value="{{$key->ID_Sub_Bidang_Keahlian}}"
                                            {{old('sub_klasifikasi') == $key->ID_Sub_Bidang_Keahlian ? 'selected' : ''}}>
                                                {{$key->Deskripsi}}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <div id="sub_klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('sub_klasifikasi') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Sub Klasifikasi --}}

                </div>

                <div class="row">
                    {{--Tema --}}
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->first('tema') ? 'has-error' : '' }}">
                            <label for="tema" class="label-control required">Tema Seminar</label>
                            <textarea name="tema" class="form-control" id="tema"  required>
                                {{ old('tema') ? old('tema') : ""}}
                            </textarea>
                            <div id="tema" class="invalid-feedback text-danger">
                                {{ $errors->first('tema') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Tema --}}
                </div>

                <div class="row">

                    {{-- Inisiator Penyelengara --}}
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('inisiator') ? 'has-error' : '' }} ">
                            <label for="inisiator" class="label-control required">Inisiator Penyelenggara</label>
                            <select name="inisiator" id="inisiator" class="form-control" multiple  required>
                                <option></option>
                                @if(old('inisiator'))
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}"
                                        {{ $key->id == old('inisiator') ? "selected" : "" }}
                                        >{{ $key->nama }}</option>
                                    @endforeach
                                @else
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div id="inisiator" class="invalid-feedback text-danger">
                                {{ $errors->first('inisiator') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Inisiator Penyelengara --}}

                    {{-- Instansi Penyelengara --}}
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                            <label for="instansi_penyelenggara" class="label-control required">Instansi Penyelengara</label>
                            <select name="instansi_penyelenggara[]" id="instansi_penyelenggara"
                            class="form-control to-pimpinan to-logo" multiple required>
                                @if(old('instansi_penyelenggara'))
                                    @foreach($instansi as $key)
                                        @if(! (collect(old('instansi_pendukung'))->contains($key->id)) )
                                            <option value="{{ $key->id }}"
                                            {{ collect(old('instansi_penyelenggara'))->contains($key->id) ? "selected" : "" }}>
                                            {{ $key->nama_bu }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($instansi as $key)
                                        <option value="{{ $key->id }}">{{ $key->nama_bu }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="small text-muted">Mohon perhatikan urutan, karena akan menentukan urutan pada sertifikat</div>
                            <div id="instansi_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('instansi_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Instansi Penyelengara --}}

                    {{-- Instansi Pendukung --}}
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('instansi_pendukung') ? 'has-error' : '' }} ">
                            <label for="instansi_pendukung" class="label-control required">Instansi Pendukung</label>
                            <select name="instansi_pendukung[]" id="instansi_pendukung"
                            class="form-control to-pimpinan to-logo" multiple required>
                            @if(old('instansi_penyelenggara'))
                                @foreach($instansi as $key)
                                    @if(! (collect(old('instansi_penyelenggara'))->contains($key->id)) )
                                        <option value="{{ $key->id }}"
                                        {{ collect(old('instansi_pendukung'))->contains($key->id) ? "selected" : "" }}>
                                        {{ $key->nama_bu }}</option>
                                    @endif
                                @endforeach
                            @endif
                            </select>
                            <div class="small text-muted">Mohon perhatikan urutan, karena akan menentukan urutan pada sertifikat</div>

                            <div id="instansi_pendukung" class="invalid-feedback text-danger">
                                {{ $errors->first('instansi_pendukung') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Instansi Pendukung --}}

                </div>

                <div class="row">
                    {{-- TTD 1 --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('ttd1') ? 'has-error' : '' }} ">
                            <label for="ttd1" class="label-control required">Penandatangan 1</label>
                            <select name="ttd1" id="ttd1"
                            class="form-control to-ttd" required>
                            @if(old('ttd1'))
                                @foreach($personal as $key)
                                    @if(old('ttd2') != $key->id)
                                        <option value="{{$key->id}}"
                                        {{old('ttd1') == $key->id ? 'selected' : ''}}>{{$key->nama}}</option>
                                    @endif
                                @endforeach
                            @endif
                            </select>
                            <div class="small text-muted">Mohon perhatikan urutan, karena akan menentukan urutan pada sertifikat</div>

                            <div id="ttd1" class="invalid-feedback text-danger">
                                {{ $errors->first('ttd1') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir TTD 1 --}}

                    {{-- Jabatan TTD 1 --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('jab_ttd1') ? 'has-error' : '' }}">
                            <label for="jab_ttd1" class="label-control required">Jabatan Penandatangan 1</label>
                            <input type="text" id="jab_ttd1" class="form-control" name="jab_ttd1"
                            placeholder="Jabatan Penandatangan 1" required
                            value="{{ old('jab_ttd1') ? old('jab_ttd1') : '' }}">
                            <div id="jab_ttd1" class="invalid-feedback text-danger">
                                {{ $errors->first('jab_ttd1') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jabatan TTD 1 --}}

                    {{-- TTD 2 --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('ttd2') ? 'has-error' : '' }} ">
                            <label for="ttd2" class="label-control required">Penandatangan 2</label>
                            <select name="ttd2" id="ttd2"
                            class="form-control to-ttd" required>
                            @if(old('ttd2'))
                                @foreach($personal as $key)
                                    @if(old('ttd1') != $key->id)
                                        <option value="{{$key->id}}"
                                        {{old('ttd2') == $key->id ? 'selected' : ''}}
                                        >{{$key->nama}}</option>
                                    @endif
                                @endforeach
                            @endif
                            </select>
                            <div class="small text-muted">Mohon perhatikan urutan, karena akan menentukan urutan pada sertifikat</div>

                            <div id="ttd2" class="invalid-feedback text-danger">
                                {{ $errors->first('ttd2') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir TTD 2 --}}

                    {{-- Jabatan TTD 2 --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('jab_ttd2') ? 'has-error' : '' }}">
                            <label for="jab_ttd2" class="label-control required">Jabatan Penandatangan 2</label>
                            <input type="text" id="jab_ttd2" class="form-control" name="jab_ttd2"
                            placeholder="Jabatan Penandatangan 2" required
                            value="{{ old('jab_ttd2') ? old('jab_ttd2') : '' }}">
                            <div id="jab_ttd2" class="invalid-feedback text-danger">
                                {{ $errors->first('jab_ttd2') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jabatan TTD 2 --}}
                </div>

                <div class="row">

                    {{-- Logo --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('logo') ? 'has-error' : '' }}">
                            <label for="logo" class="label-control required">Logo pada Sertifikat</label>
                            <select name="logo[]" multiple="multiple" required class="form-control" id="logo">
                                @if(old('instansi_penyelenggara') || old('instansi_pendukung'))
                                    @foreach ($instansi as $key)
                                        @if((collect(old('instansi_penyelenggara'))->contains($key->id)) || (collect(old('instansi_pendukung'))->contains($key->id)))
                                            <option value="{{$key->id}}"
                                                {{(collect(old('logo'))->contains($key->id)) ? 'selected' : ''}}
                                            >{{$key->nama_bu}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <div class="small text-muted">Urutan pilihan tidak berpengaruh pada urutan di sertifikat</div>

                            <div id="logo" class="invalid-feedback text-danger">
                                {{ $errors->first('logo') }}
                            </div>
                        </div>
                    </div>
                    {{-- End Logo --}}

                    {{-- Is Online --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('is_online') ? 'has-error' : '' }} ">
                            <label for="is_online" class="label-control required">Jenis Acara</label>
                            <select name="is_online" id="is_online"  data-minimum-results-for-search="Infinity"
                            class="form-control" required>
                                <option value="" {{ !old('is_online') ? 'selected' : ''}} hidden>Pilih Jenis Seminar</option>
                                <option value="0" {{ old('is_online') == '0' ? 'selected' : ''}}>Offline</option>
                                <option value="1" {{ old('is_online') == '1' ? 'selected' : ''}}>Online (Webinar)</option>
                            </select>

                            <div id="is_online" class="invalid-feedback text-danger">
                                {{ $errors->first('is_online') }}
                            </div>
                        </div>
                    </div>
                    {{-- End is online --}}

                    {{-- Link --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('link') ? 'has-error' : '' }} ">
                            <label for="link" class="label-control required">Link</label>
                            <input type="text" class="form-control" name="link" id="link"
                                value="{{ old('is_online') == '1' ? old('link') : '' }}"
                                placeholder="Hanya untuk Webinar"
                                {{ old('is_online') == "0" ? 'disabled' : '' }}
                                >
                            <div id="link" class="invalid-feedback text-danger">
                                {{ $errors->first('link') }}
                            </div>
                        </div>
                    </div>
                    {{-- End link --}}

                </div>

                <div class="row">
                    {{-- Provinsi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('prov_penyelenggara') ? 'has-error' : '' }}"">
                            <label for="prov_penyelenggara" class="label-control required">Provinsi Penyelengara</label>
                            <select name="prov_penyelenggara" required
                            id="prov_penyelenggara" class="form-control">
                                @if(old('prov_penyelenggara'))
                                    @foreach($provinsi as $key)
                                        <option value="{{ $key->id }}" {{ old('prov_penyelenggara') == $key->id ? "selected" : "" }}
                                            >{{$key->nama}}</option>
                                    @endforeach
                                @else
                                    <option value="" selected hidden></option>
                                    @foreach($provinsi as $key)
                                        <option value="{{ $key->id }}">{{$key->nama}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div id="prov_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('prov_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Provinsi --}}

                    {{-- Kota --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('kota_penyelenggara') ? 'has-error' : '' }} ">
                            <label for="kota_penyelenggara" class="label-control required">Kota Penyelenggara</label>
                            <select name="kota_penyelenggara" required
                            id="kota_penyelenggara" class="form-control">
                                @if(old('prov_penyelenggara'))
                                    @foreach($kota as $key)
                                        @if($key->provinsi_id == old('prov_penyelenggara'))
                                        <option value="{{ $key->id }}"
                                        {{ old('kota_penyelenggara') == $key->id ? "selected" : "" }}
                                            >{{$key->nama}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" selected hidden></option>
                                @endif

                            </select>
                            <div id="kota_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('kota_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Kota --}}

                    {{-- TUK --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('tuk') ? 'has-error' : '' }} ">
                            <label for="tuk" class="label-control required">Tempat Uji Kompetensi (TUK)</label>
                            <select name="tuk" id="tuk"
                            class="form-control" required>
                            @if(old('is_online') == '1')
                                @foreach($tuk as $key)
                                    @if($key->is_online == '1')
                                        <option value="{{$key->id}}" {{old('tuk') == $key->id ? 'selected' : ''}}>
                                            {{$key->nama_tuk}}
                                        </option>
                                    @endif
                                @endforeach
                            @elseif(old('is_online') == '0' && old('kota_penyelenggara'))
                                @foreach($tuk as $key)
                                    @if($key->kota == old('kota_penyelenggara'))
                                        <option value="{{$key->id}}" {{old('tuk') == $key->id ? 'selected' : ''}}>
                                            {{$key->nama_tuk}}
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                            </select>

                            <div id="tuk" class="invalid-feedback text-danger">
                                {{ $errors->first('tuk') }}
                            </div>
                        </div>
                    </div>
                    {{-- End TUK --}}

                    {{-- Alamat --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('lokasi_penyelenggara') ? 'has-error' : '' }}">
                            <label for="lokasi_penyelenggara" class="label-control required">Alamat Penyelenggara</label>
                            <input type="text" id="lokasi_penyelenggara" class="form-control"
                            placeholder="Alamat" name="lokasi_penyelenggara" required
                            value="{{ old('lokasi_penyelenggara') ? old('lokasi_penyelenggara') : '' }}">
                            <div id="lokasi_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('lokasi_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Alamat --}}
                </div>

                <div class="row">
                    {{-- Narasumber --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('narasumber') ? 'has-error' : '' }}">
                            <label for="narasumber" class="label-control required">Narasumber</label>
                            <select name="narasumber[]" multiple="multiple" required class="form-control" id="narasumber">
                                @foreach($personal as $key)
                                    @if( !(collect(old('moderator'))->contains($key->id)) )
                                        <option value="{{$key->id}}"
                                        {{ ( collect(old('narasumber'))->contains($key->id) ) ? "selected" : "" }}>
                                        {{ $key->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="small text-muted">Mohon perhatikan urutan, karena akan menentukan urutan pada sertifikat</div>

                            <div id="narasumber" class="invalid-feedback text-danger">
                                {{ $errors->first('narasumber') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Narasumber --}}

                    {{-- Moderator --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('moderator') ? 'has-error' : '' }}">
                            <label for="moderator" class="label-control required">Moderator</label>
                            <select name="moderator[]" multiple="multiple" required class="form-control" id="moderator">
                                @foreach($personal as $key)
                                    @if(! ( collect(old('narasumber'))->contains($key->id) ) )
                                        <option value="{{$key->id}}"
                                        {{ (collect(old('moderator'))->contains($key->id)) ? "selected" : "" }}>
                                        {{ $key->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="moderator" class="invalid-feedback text-danger">
                                {{ $errors->first('moderator') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Moderator --}}

                </div>

                <div class="row">

                    {{-- Kuota Peserta --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('kuota') ? 'has-error' : '' }} ">
                            <label for="kuota" class="label-control required">Kuota Peserta</label>
                            <input type="text" class="form-control" name="kuota" id="kuota"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('kuota') }}" required
                                placeholder="Kuota Peserta">
                            <div id="kuota" class="invalid-feedback text-danger">
                                {{ $errors->first('kuota') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Kuota Peserta --}}

                    {{-- Nilai SKPK --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('skpk_nilai') ? 'has-error' : '' }} ">
                            <label for="skpk_nilai" class="label-control required">Nilai SKPK</label>
                            <input type="text" class="form-control" name="skpk_nilai" id="skpk_nilai"
                                maxlength="2" required
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('skpk_nilai') }}"
                                placeholder="Nilai SKPK">
                            <div id="skpk_nilai" class="invalid-feedback text-danger">
                                {{ $errors->first('skpk_nilai') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Nilai SKPK --}}

                    {{-- Berbayar --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('is_free') ? 'has-error' : '' }} ">
                            <label for="is-free" class="label-control required">Jenis</label>
                            <select name="is_free" id="is_free" class="form-control"  data-minimum-results-for-search="Infinity">
                                <option value="" selected hidden>Pilih Jenis</option>
                                <option value="0">Gratis</option>
                                <option value="1">Berbayar</option>
                            </select>

                            <div id="is_free" class="invalid-feedback text-danger">
                                {{ $errors->first('is_free') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Berbayar --}}

                    {{-- Biaya --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('biaya') ? 'has-error' : '' }} ">
                            <label for="biaya" class="label-control required">Biaya</label>
                            <input type="text" class="form-control" name="biaya" id="biaya"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('biaya') }}"
                                placeholder="Hanya untuk Seminar Berbayar"
                                {{ old('is_free') == "1" ? '' : 'disabled' }}
                                >
                            <div id="biaya" class="invalid-feedback text-danger">
                                {{ $errors->first('biaya') }}
                            </div>
                        </div>
                    </div>
                    {{-- Biaya --}}

                </div>
                <div class="row">
                    {{-- Tanggal Mulai --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('tgl_awal') ? 'has-error' : '' }} ">
                            <label for="tgl_awal" class="label-control required">Tanggal Awal</label>
                            <input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('tgl_awal') }}" required
                                placeholder=" HH-BB-TTTT">
                            <div id="tgl_awal" class="invalid-feedback text-danger">
                                {{ $errors->first('tgl_awal') }}
                            </div>
                        </div>
                    </div>
                    {{-- Tanggal Mulai --}}

                    {{-- Tanggal Akhir --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('tgl_akhir') ? 'has-error' : '' }} ">
                            <label for="tgl_akhir" class="label-control required">Tanggal Akhir</label>
                            <input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('tgl_akhir') }}" required
                                placeholder=" HH-BB-TTTT">
                            <div id="tgl_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('tgl_akhir') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Tanggal Akhir --}}

                    {{-- Jam Awal --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('jam_awal') ? 'has-error' : '' }} ">
                            <label for="jam_awal" class="label-control required">Jam Awal</label>
                            <input type="text" class="form-control timepicker" name="jam_awal" id="jam_awal"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('jam_awal') }}" required
                                placeholder=" 00:00">
                            <div id="tgl_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('jam_awal') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jam Awal --}}

                    {{-- Jam Awal --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('jam_akhir') ? 'has-error' : '' }} ">
                            <label for="jam_akhir" class="label-control required">Jam Akhir</label>
                            <input type="text" class="form-control timepicker" name="jam_akhir" id="jam_akhir"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('jam_akhir') }}" required
                                placeholder=" 00:00">
                            <div id="jam_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('jam_akhir') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jam Awal --}}

                </div>
                <div class="row">

                    {{-- Brosur --}}
                    <div class="col-md-12">
                        <div class="form-group  {{ ($errors->first('foto')) ? ' has-error' : '' }}">
                            <div class="custom-file">
                                <label class="label-control required" for="foto">Brosur Seminar</label>
                                <div class="custom-file">
                                    <input type="file" id="foto" name="foto" required class="custom-file-input" id="foto" required>
                                    <div id="foto" class="invalid-feedback text-danger">
                                        {{ $errors->first('foto') }}
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                            <small class="form-text text-muted">Format: jpeg, png, jpg, gif, svg</small><br>
                        </div>
                    </div>
                    {{-- Akhir Brosur --}}

                </div>




                <button class="btn btn-success" name="store" value="publish">Publish</button>
                <button class="btn btn-info pull-right" name="store" value="draft">Save</button>
                </form>
            </div> {{-- Jumbotron --}}
        </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
</section>
@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
    let instansi = {!! json_encode($pendukung->toArray()) !!};
    let tema = $('#tema');
    CKEDITOR.replace('tema');

    $(document).ready(function () {
        $("form").children().each(function(){
            this.value=$(this).val().trim();
        }); // trim semua spasi
        $("#is_free").select2();
        $("#is_free").on('change', function() {
            let pilihan = $("#is_free").val();
            if(pilihan == "0") {
                $("#biaya").val("");
                $("#biaya").prop("disabled", true);
                $("#biaya").prop("required", false);
            } else if(pilihan == '1') {
                $("#biaya").prop("disabled", false);
                $("#biaya").prop("required", true);
            } else {
                let skrng = $("#biaya").val();
                $("#biaya").val(skrng);
                $("#biaya").prop("disabled", false);
                $("#biaya").prop("required", true);
            }
        });

        $("#is_online").select2();
        $("#is_online").on('change', function() {
            let pilihan = $("#is_online").val();
            if(pilihan == "0") {

                // to tuk

                kota = $('#kota_penyelenggara').select2('data').map(function(elem){
                    return elem.id
                });

                tuk = @json($tuk);

                $('#tuk').empty();

                $('#tuk').append(new Option('Pilih Tempat Uji Kompetensi', '')).attr('selected',true);

                tuk.forEach(function(key) {

                    if( key.is_online == '0' ){
                        if( kota.includes(key.kota.toString()) ){
                            //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                            $('#tuk').append(new Option(key.nama_tuk, key.id));

                        }
                    }

                });

                $('#tuk').select2({
                    placeholder: " Pilih Tempat Uji Kompetensi",
                });

                // end to tuk

                $("#link").val("");
                $("#link").prop("disabled", true);
                $("#link").prop("required", false);
            } else if(pilihan == '1') {

                // to tuk

                tuk = @json($tuk);

                $('#tuk').empty();

                $('#tuk').append(new Option('Pilih Tempat Uji Kompetensi', '')).attr('selected',true);

                tuk.forEach(function(key) {

                    if( key.is_online == '1' ){
                        //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                        $('#tuk').append(new Option(key.nama_tuk, key.id));

                    }

                });

                $('#tuk').select2({
                    placeholder: " Pilih Tempat Uji Kompetensi",
                });

                // end to tuk

                $("#link").val("https://");
                $("#link").prop("disabled", false);
                $("#link").prop("required", true);
            }  else {
                let skrng = $("#link").val();
                $("#link").val(skrg);
                $("#link").prop("disabled", false);
                $("#link").prop("required", true);
            }
        });

        // onchange kota
        $('#kota_penyelenggara').on('select2:select', function() {
            is_online = $('#is_online').val();

            if(is_online == '0') {

                kota = $('#kota_penyelenggara').select2('data').map(function(elem){
                    return elem.id
                });

                tuk = @json($tuk);

                $('#tuk').empty();

                $('#tuk').append(new Option('Pilih Tempat Uji Kompetensi', '')).attr('selected',true);

                tuk.forEach(function(key) {

                    if( key.is_online == '0' ){
                        if( kota.includes(key.kota.toString()) ){
                            //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                            $('#tuk').append(new Option(key.nama_tuk, key.id));
                        }
                    }
                });
            }
        });
        // end onchange kota

        // onchange tuk
        $('#tuk').on('select2:select', function() {

            tukval = $('#tuk').val();

            tuk = @json($tuk);

            $('#lokasi_penyelenggara').val('');

            tuk.forEach(function(key) {
                if(tukval == key.id) {

                    // console.log(key);
                    if( key.is_online == '0' ){
                        $('#lokasi_penyelenggara').val(key.alamat);
                    }

                    if( key.is_online == '1' ){
                        $('#lokasi_penyelenggara').val(key.nama_tuk);
                    }

                }

            });

            $('#alamat').select2();
        });
        // end tuk



        $('.timepicker').datetimepicker({

            format: 'HH:mm'

        });
        $('body').on('change', '.form-group', function() {
            // Action goes here.
        });
        $('#prov_penyelenggara').select2({
            placeholder: " Pilih Provinsi"
        }); // Select2 Provinsi
        $('#instansi').select2(); // Select2 instansi
        $('#kota_penyelenggara').select2({
            placeholder: " Pilih Kota"
        }); // Select2 Kota
        $('#klasifikasi').select2({
            placeholder: " Pilih Klasifikasi",
        }); // Select2 Klasifikasi
        $('#sub_klasifikasi').select2({
            placeholder: " Pilih Sub-klasifikasi",
        }); // Select2 Sub-Klasifikasi
        $('#inisiator').select2({
            placeholder: " Pilih Inisiator Penyelenggara ",
        }); // Select2 Inisiator Penyelenggara
        $('#instansi_penyelenggara').select2({
            placeholder: " Pilih Instansi Penyelenggara",
            allowClear: true,
            // maximumSelectionLength: 2,
        }); // Select2 Instansi Penyelenggara
        $('#instansi_pendukung').select2({
            placeholder: " Pilih Instansi Pendukung",
            allowClear: true,
            // maximumSelectionLength: 2,
        }); // Select2 Instansi Pendukung
        $('#ttd1').select2({
            placeholder: " Pilih Penandatangan",
        }); // Select2 Provinsi
        $('#ttd2').select2({
            placeholder: " Pilih Penandatangan",
        }); // Select2 Provinsi
        $('#tuk').select2({
            placeholder: " Pilih Tempat Uji Kompetensi",
        }); // Select2 Provinsi
        $('#narasumber').select2({
            placeholder: " Pilih Narasumber",
            allowClear: true,
            // maximumSelectionLength: 2,
        }); // Select2 Instansi Pendukung
        $('#moderator').select2({
            placeholder: " Pilih Moderator",
            allowClear: true,
            // maximumSelectionLength: 2,
        }); // Select2 Instansi Pendukung
        $('#logo').select2({
            placeholder: " Pilih Logo yang Akan Ditampilkan pada Sertifikat",
            allowClear: true,
        }); // Select2

        // to logo
        $('.to-logo').on('select2:select', function() {
            instansi = @json($instansi);
            // console.log(instansi);

            peny = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });
            pend = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });
            // console.log(peny);
            // console.log(pend);

            $('#logo').empty();

            instansi.forEach(function(key) {

                if(peny.includes((key.id).toString()) || pend.includes((key.id).toString())){
                    //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                    $('#logo').append(new Option(key.nama_bu, key.id));

                }
            });

            $('#logo').select2({
                placeholder: " Pilih Logo yang Akan Ditampilkan pada Sertifikat",
            });
        });
        // end to logo

        // Instansi Penyelenggara dan Instansi Pendukung

            // Yang Select Penyelenggara
        $('#instansi_penyelenggara').on('select2:select', function() {
            pendukung = @json($pendukung);

            // console.log(pendukung.hasOwnProperty('33'));
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });

            peny = $('#instansi_penyelenggara').select2('val');
            pend = $('#instansi_pendukung').select2('val');

            // console.log($('#instansi_penyelenggara').select2('val'));
            $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                if(!data.includes(key)){
                    if( ( !!pend ? pend.includes(key) : false ) ) {
                        $('#instansi_pendukung').append(new Option(pendukung[key], key)).prop('selected',true);
                    } else {
                        $('#instansi_pendukung').append(new Option(pendukung[key], key));
                    }
                }
            }

            $('#instansi_pendukung').select2({
                placeholder: " Pilih Instansi Pendukung",
                allowClear: true,
            });
        });
            // END Select Penyelenggara

            // Yang unselect Penyelenggara
        $('#instansi_penyelenggara').on('select2:unselect', function() {
            pendukung = @json($pendukung);

            // console.log(pendukung.hasOwnProperty('33'));
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });
            // console.log(pend);
            $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                if(!data.includes(key)){
                    $('#instansi_pendukung').append(new Option(pendukung[key], key));
                }
            }

            $('#instansi_pendukung').select2({
                placeholder: " Pilih Instansi Pendukung",
                allowClear: true,
            });
        });
            // END unselect Penyelenggara

        // End Instansi Penyelenggara dan Instansi Pendukung

        $('#narasumber').on('change', function() {
            personal = @json($pers);
            nara = $('#narasumber').select2('data').map(function(elem){
                return elem.id
            });
            mode = $('#moderator').select2('data').map(function(elem){
                return elem.id
            });
            // console.log(data.includes('27'));
            $('#moderator').empty();
            for(let key in personal) {
                if(!nara.includes(key)){
                    //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                    $('#moderator').append(new Option(personal[key], key));
                    // console.log(key);
                }
            }

            $('#moderator').select2({
                placeholder: " Pilih Moderator",
                allowClear: true,
                // maximumSelectionLength: 2,
            });
        })


        $('#klasifikasi').on('change', function() {
            sub_klas = @json($sub_klasifikasi);
            data = $('#klasifikasi').select2('data').map(function(elem){
                return elem.id
            });
            // console.log(sub_klas);
            // console.log(data[0]);
            // console.log(data.includes('27'));
            $('#sub_klasifikasi').empty();
            $('#sub_klasifikasi').append(new Option('Pilih Sub-Klasifikasi','')).prop('selected',true).prop('hidden',true);

            for(let key in sub_klas) {// console.log(sub_klas[key].ID_Keahlian);
                if(data[0] == sub_klas[key].ID_Keahlian){
                    //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                    $('#sub_klasifikasi').append(new Option(sub_klas[key].Deskripsi, sub_klas[key].ID_Sub_Bidang_Keahlian));
                    // console.log(sub_klas[key]);
                }
            }

            $('#sub_klasifikasi').select2({
            allowClear: true,
            maximumSelectionLength: 2,});
        })

        $('.to-pimpinan').on('change', function() {
            personal =  @json($personal);
            peny = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });
            pend = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });

            // console.log('pimpinan :', personal);
            // console.log('pendukung :', pend);
            // console.log('penyelenggara :', peny);
            $('#ttd1').empty();
            $('#ttd2').empty();
            $('#ttd1').append(new Option('Pilih Penandatangan', '')).attr('selected',true);
            personal.forEach(function(key) {
                if(peny.includes(key.instansi) || pend.includes(key.instansi)){
                    //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                    $('#ttd1').append(new Option(key.nama, key.id));

                    $('#ttd1').select2();
                }
            });
        })

        $('#ttd1').on('select2:select', function() {
            personal =  @json($personal);
            peny = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });
            pend = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });

            // console.log('pimpinan :', personal);
            // console.log('pendukung :', pend);
            // console.log('penyelenggara :', peny);
            $('#ttd2').empty();
            $('#ttd2').append(new Option('Pilih Penandatangan', '')).attr('selected',true);

            personal.forEach(function(key) {
                if(peny.includes(key.instansi) || pend.includes(key.instansi)){
                    if( !($('#ttd1').val() == key.id) ){
                        //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                        $('#ttd2').append(new Option(key.nama, key.id));

                        $('#ttd2').select2();
                    }
                }
            });
        })

        $(".to-pimpinan").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });


        $(".to-ttd").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        $("#narasumber").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        // Ajax Untuk Kota, Onchange Provinsi
        $('#prov_penyelenggara').on('change', function(e){
            $('select[name="kota_penyelenggara"]').empty();
            var id = e.target.value;
            //
            if(id) {
                $.ajax({
                    url: '/seminar/create/getKota/'+id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="kota_penyelenggara"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kota_penyelenggara"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="kota_penyelenggara"]').empty();
            }

            //
            $('#kota_penyelenggara').select2();
        });

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY'
        });

    });
</script>
@endpush
