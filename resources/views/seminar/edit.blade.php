@extends('templates.header')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
{{-- {{dd($klasifikasi)}} --}}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Edit</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron"  style='padding-top:1px'>
                <h1 style="margin-bottom:50px;">Seminar</h1>
                <form method="POST" action="{{ url('seminar/'.$id.'/update') }}" enctype="multipart/form-data">
                @method('patch')
                @csrf

                <div class="row">

                    {{-- Nama Seminar --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('nama_seminar') ? 'has-error' : '' }}">
                            <label for="nama_seminar" class="label-control required">Nama Seminar</label>
                            <input type="text" id="nama_seminar" class="form-control" name="nama_seminar"
                            placeholder="Nama Seminar"
                            value="{{ old('nama_seminar') ? old('nama_seminar') : $seminar->nama_seminar }}">
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
                            <select name="klasifikasi"
                            id="klasifikasi" class="form-control">
                            @if (old('klasifikasi'))
                                @foreach ($klasifikasi as $key)
                                    <option value="{{$key->ID_Bidang_Profesi}}"
                                    {{$key->ID_Bidang_Profesi == old('klasifikasi') ? 'selected' : ''}}
                                    >
                                        {{$key->Deskripsi}}
                                    </option>
                                @endforeach
                            @else
                                <option value="" selected hidden>Pilih Klasifikasi</option>
                                @foreach ($klasifikasi as $key)
                                    <option value="{{$key->ID_Bidang_Profesi}}"
                                        @if (isset($seminar->klasifikasi))
                                            {{$seminar->klasifikasi == $key->ID_Bidang_Profesi ? 'selected' : ''}}
                                        @endif
                                    >{{$key->Deskripsi}}</option>
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
                            <select name="sub_klasifikasi"
                            id="sub_klasifikasi" class="form-control">
                            @if (old('klasifikasi'))
                                @foreach ($sub_klasifikasi as $key)
                                    @if ($key->ID_Keahlian == old('klasifikasi'))
                                        <option value="{{$key->ID_Sub_Bidang_Keahlian}}"
                                            @if(old('sub_klasifikasi'))
                                                {{$key->ID_Sub_Bidang_Keahlian == old('sub_klasifikasi') ? 'selected' : ''}}
                                            @endif
                                        >
                                            {{$key->Deskripsi}}
                                        </option>
                                    @endif
                                @endforeach
                            @elseif(isset($seminar->klasifikasi))
                                <option value="">Pilih Sub-klasifikasi</option>
                                @foreach ($sub_klasifikasi as $key)
                                    @if ($key->ID_Keahlian == $seminar->klasifikasi)
                                        <option value="{{$key->ID_Sub_Bidang_Keahlian}}"
                                        {{$key->ID_Sub_Bidang_Keahlian == $seminar->sub_klasifikasi ? 'selected' : ''}}>
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
                            <textarea name="tema" class="form-control" id="tema">
                                {{ old('tema') ? old('tema') : $seminar->tema}}
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
                            <select name="inisiator" id="inisiator" class="form-control" multiple>
                                <option></option>
                                @if(old('inisiator'))
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}"
                                        {{ $key->id == old('inisiator') ? "selected" : "" }}
                                        >{{ $key->nama }}</option>
                                    @endforeach
                                @else
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}"
                                            selected
                                            >{{ $key->nama }}</option>
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
                            class="form-control to-pimpinan to-logo" multiple>
                                @if(old('instansi_penyelenggara'))
                                    @foreach($instansi as $key)
                                        <option value="{{ $key->id }}"
                                        {{ collect(old('instansi_penyelenggara'))->contains($key->id) ? "selected" : "" }}
                                        {{ collect(old('instansi_pendukung'))->contains($key->id) ? "disabled" : "" }}
                                        >{{ $key->nama_bu }}</option>
                                    @endforeach
                                @else
                                    @foreach($instansi as $key)
                                        @if($penyelenggara->contains('id_instansi',$key->id))
                                            <option value="{{ $key->id }}" selected>{{ $key->nama_bu }}</option>
                                        @elseif($pendukung->contains('id_instansi',$key->id))
                                            <option value="{{ $key->id }}" disabled>{{ $key->nama_bu }}</option>
                                        @else
                                            <option value="{{ $key->id }}">{{ $key->nama_bu }}</option>
                                        @endif
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
                            class="form-control to-pimpinan to-logo" multiple>
                                @if(old('instansi_pendukung'))
                                    @foreach($instansi as $key)
                                        <option value="{{ $key->id }}"
                                        {{ collect(old('instansi_pendukung'))->contains($key->id) ? "selected" : "" }}
                                        {{ collect(old('instansi_penyelenggara'))->contains($key->id) ? "disabled" : "" }}
                                        >{{ $key->nama_bu }}</option>
                                    @endforeach
                                @else
                                    @foreach($instansi as $key)
                                        @if($pendukung->contains('id_instansi',$key->id))
                                            <option value="{{ $key->id }}" selected>{{ $key->nama_bu }}</option>
                                        @elseif($penyelenggara->contains('id_instansi',$key->id))
                                            <option value="{{ $key->id }}" disabled>{{ $key->nama_bu }}</option>
                                        @else
                                            <option value="{{ $key->id }}">{{ $key->nama_bu }}</option>
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
                            class="form-control to-ttd">
                            @if(old('ttd1'))
                                @foreach($personal as $key)
                                    @if(old('ttd2') != $key->id)
                                        <option value="{{$key->id}}"
                                        {{old('ttd1') == $key->id ? 'selected' : ''}}>{{$key->nama}}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach($personal as $key)
                                    @if(isset($ttd[1]['id_personal']) ? ($ttd[1]['id_personal'] != $key->id) : '')
                                        <option value="{{$key->id}}"
                                        {{$ttd[0]['id_personal'] == $key->id ? 'selected' : ''}}>{{$key->nama}}</option>
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
                            placeholder="Jabatan Penandatangan 1"
                            value="{{ old('jab_ttd1') ? old('jab_ttd1') : (isset($ttd[0]['jabatan']) ? $ttd[0]['jabatan'] : '') }}">
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
                            class="form-control to-ttd">
                            @if(old('ttd2'))
                                @foreach($personal as $key)
                                    @if(old('ttd1') != $key->id)
                                        <option value="{{$key->id}}"
                                        {{old('ttd2') == $key->id ? 'selected' : ''}}
                                        >{{$key->nama}}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach($personal as $key)
                                    @if(isset($ttd[0]['id_personal']) ? ($ttd[0]['id_personal'] != $key->id) : '')
                                        <option value="{{$key->id}}"
                                        {{ $ttd[1]['id_personal'] == $key->id ? 'selected' : ''}}>{{$key->nama}}</option>
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
                            placeholder="Jabatan Penandatangan 2"
                            value="{{ old('jab_ttd2') ? old('jab_ttd2') : (isset($ttd[1]['jabatan']) ? $ttd[1]['jabatan'] : '') }}">
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
                                @if(old('logo'))
                                    @if(old('instansi_penyelenggara') || old('instansi_pendukung'))
                                        @foreach ($instansi as $key)
                                            @if((collect(old('instansi_penyelenggara'))->contains($key->id)) || (collect(old('instansi_pendukung'))->contains($key->id)))
                                                <option value="{{$key->id}}"
                                                    {{(collect(old('logo'))->contains($key->id)) ? 'selected' : ''}}
                                                >{{$key->nama_bu}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @elseif($pendukung || $penyelenggara)
                                    @foreach ($logo as $key)
                                        <option value="{{$key->id_instansi}}"
                                            {{$key->is_tampil == '1' ? 'selected' : ''}}
                                        >
                                        {{$pendukungArr[$key->id_instansi]}}</option>
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
                            class="form-control" disabled >
                                <option value="" {{ !isset($seminar->is_online) ? 'selected' : ''}}>Pilih Jenis Seminar</option>
                                <option value="0" {{ $seminar->is_online == '0' ? 'selected' : ''}}>Offline</option>
                                <option value="1" {{ $seminar->is_online == '1' ? 'selected' : ''}}>Online (Webinar)</option>
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
                                value="{{ $seminar->is_online == '1' ? (old('link') ? old('link') : $seminar->url ) : '' }}"
                                placeholder="Hanya untuk Webinar"
                                {{ $seminar->is_online == "1" ? '' : 'disabled' }}
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
                                        <option value="{{ $key->id }}"
                                            {{ $key->id == $seminar->prov_penyelenggara ? 'selected=true' : '' }}
                                            >{{$key->nama}}</option>
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
                                @elseif($seminar->prov_penyelenggara)
                                    @foreach($kota as $key)
                                        @if($key->provinsi_id == $seminar->prov_penyelenggara)
                                        <option value="{{ $key->id }}"
                                        {{ $seminar->kota_penyelenggara == $key->id ? "selected" : "" }}
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
                            @if(old('tuk'))
                                @if($seminar->is_online == '1')
                                    @foreach($tuk as $key)
                                        @if($key->is_online == '1')
                                            <option value="{{$key->id}}" {{old('tuk') == $key->id ? 'selected' : ''}}>
                                                {{$key->nama_tuk}}
                                            </option>
                                        @endif
                                    @endforeach
                                @elseif($seminar->is_online == '0' && old('kota_penyelenggara'))
                                    @foreach($tuk as $key)
                                        @if($key->kota == old('kota_penyelenggara'))
                                            <option value="{{$key->id}}" {{old('tuk') == $key->id ? 'selected' : ''}}>
                                                {{$key->nama_tuk}}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            @elseif($seminar->is_online == '1')
                                <option value="" {{isset($seminar->tuk) ? '' : 'selected'}} hidden>Pilih Tempat Uji Kompetensi</option>
                                @foreach ($tuk as $key)
                                    @if ($key->is_online == '1')
                                        <option value="{{$key->id}}"
                                            {{($seminar->tuk ==$key->id) ? 'selected' : ''}}
                                        >
                                        {{$key->nama_tuk}}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="" {{isset($seminar->tuk) ? '' : 'selected'}} hidden>Pilih Tempat Uji Kompetensi</option>
                                @foreach ($tuk as $key)
                                    @if ($key->kota == $seminar->kota_penyelenggara)
                                        <option value="{{$key->id}}"
                                            {{($seminar->tuk ==$key->id) ? 'selected' : ''}}
                                        >
                                        {{$key->nama_tuk}}</option>
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
                            placeholder="Alamat" name="lokasi_penyelenggara"
                            value="{{ old('lokasi_penyelenggara') ? old('lokasi_penyelenggara') : $seminar->lokasi_penyelenggara }}">
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
                            <select name="narasumber[]" multiple="multiple" class="form-control" id="narasumber">
                                @if(old('narasumber'))
                                    @foreach($personal as $key)
                                        <option value="{{$key->id}}"
                                        {{ ( collect(old('narasumber'))->contains($key->id) ) ? "selected" : "" }}
                                        {{ ( collect(old('moderator'))->contains($key->id) ) ? "disabled" : "" }}>
                                        {{ $key->nama }}</option>
                                    @endforeach
                                @else
                                    @foreach($personal as $key)
                                        <option value="{{$key->id}}"
                                        {{ $narasumber->contains('id_personal',$key->id)  ? "selected" : "" }}
                                        {{ $moderator->contains('id_personal',$key->id) ? "disabled" : "" }}
                                        >
                                        {{ $key->nama }}</option>
                                    @endforeach
                                @endif
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
                            <select name="moderator[]" multiple="multiple" class="form-control" id="moderator">
                                @if(old('narasumber') || old('moderator'))
                                    @foreach($personal as $key)
                                        <option value="{{$key->id}}"
                                        {{ ( collect(old('narasumber'))->contains($key->id) ) ? "disabled" : "" }}
                                        {{ ( collect(old('moderator'))->contains($key->id) ) ? "selected" : "" }}>
                                        {{ $key->nama }}</option>
                                    @endforeach
                                @else
                                    @foreach($personal as $key)
                                        <option value="{{$key->id}}"
                                        {{ $narasumber->contains('id_personal',$key->id)  ? "disabled" : "" }}
                                        {{ $moderator->contains('id_personal',$key->id) ? "selected" : "" }}
                                        >
                                        {{ $key->nama }}</option>
                                    @endforeach
                                @endif
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
                                value="{{ old('kuota') ? old('kuota') : $seminar->kuota }}"
                                placeholder="Kuota Peserta"  disabled>
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
                                maxlength="2"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('skpk_nilai') ? old('skpk_nilai') : $seminar->skpk_nilai }}"
                                placeholder="Nilai SKPK" disabled>
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
                            <select class="form-control" id="is_free" id="is_free" disabled>
                                <option value="0"
                                {{old('is_free') ? (old('is_free') == '0' ? 'selected' : '') : ($seminar->is_free == '0' ? 'selected' : '') }}
                                >Gratis</option>
                                <option value="1"
                                {{old('is_free') ? (old('is_free') == '1' ? 'selected' : '') : ($seminar->is_free == '1' ? 'selected' : '') }}
                                >Berbayar</option>
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
                                value="{{ $seminar->is_free == "1" ? trim($seminar->biaya,'\s') : "Gratis" }}"
                                placeholder="Biaya" disabled
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
                                value="{{ (\Carbon\Carbon::parse($seminar->tgl_awal)->format('j-m-Y')) }}"
                                placeholder=" HH-BB-TTTT" disabled>
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
                                value="@if(old('tgl_akhir')) {{old('tgl_akhir')}}
                                @else {{ $seminar->tgl_akhir ? (\Carbon\Carbon::parse($seminar->tgl_akhir)->format('j-m-Y')) : '' }}
                                @endif"
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
                                value="@if(old('jam_awal')) {{old('jam_awal')}}
                                @else {{ $seminar->jam_awal ? \Carbon\Carbon::parse($seminar->jam_awal)->format( 'H:i' ) : '' }}
                                @endif"
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
                                value="@if(old('jam_akhir')) {{old('jam_akhir')}}
                                @else {{ $seminar->jam_akhir ? \Carbon\Carbon::parse($seminar->jam_akhir)->format( 'H:i' ) : '' }}
                                @endif"
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
                    <div class="col-md-4">
                        <div class="form-group  {{ ($errors->first('foto')) ? ' has-error' : '' }}">
                            <div class="custom-file">
                                <label class="label-control" for="foto">Brosur Seminar</label>
                                <div class="custom-file">
                                    <input type="file" id="foto" name="foto" class="custom-file-input" id="foto">
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


                <button class="btn btn-success" name="store" value="publish">Save</button>
                {{--<button class="btn btn-info pull-right" name="store" value="draft">Save</button>--}}
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
        }) // trim semua spasi

        $("#is_free").select2();
        $("#tuk").select2();
        $("#is_online").select2();

        $('#logo').select2({
            placeholder: " Pilih Logo yang Akan Ditampilkan pada Sertifikat",
            allowClear: true,
        }); // Select2


        // onchange kota
        $('#kota_penyelenggara').on('select2:select', function() {
            is_online = {{$seminar->is_online}};

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


        $("#biaya").each(function(){
            //this.value=$(this).val().trim();
            $(this).val($.trim($(this).val()));
            // console.log(this.textContent,' trimmed');
        }) // trim semua spasi
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
            placeholder: " Pilih Penandatangan ",
        }); // Select2 Inisiator Penyelenggara
        $('#ttd2').select2({
            placeholder: " Pilih Penandatangan ",
        }); // Select2 Inisiator Penyelenggara
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

            instansi.forEach(function(key) {

                if(peny.includes((key.id).toString()) || pend.includes((key.id).toString())){
                    // console.log(key);
                    cari = $("#logo").find('option[value='+key.id+']');
                    if(cari.length == 0) {
                        // console.log('bisa');
                        // console.log(cari.length);
                        $('#logo').append(new Option(key.nama_bu, key.id));
                    }
                }
            });

        });


        $('.to-logo').on('select2:unselect', function() {
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

            // $('#logo').empty();

            instansi.forEach(function(key) {

                if(!( peny.includes((key.id).toString()) ) && !( pend.includes((key.id).toString()) ) ){
                    // console.log(key);
                    cari = $("#logo").find('option[value='+key.id+']');
                    if(cari.length > 0) {
                        // console.log('remove');
                        // console.log(cari);
                        cari.remove();
                    }
                }

            });

        });
        // end to logo

        // Instansi Penyelenggara dan Instansi Pendukung

            // Yang Select Penyelenggara
        $('#instansi_penyelenggara').on('select2:select', function() {
            pendukung = @json($ins);

            // console.log(pendukung);
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });

            data2 = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });


            peny = $('#instansi_penyelenggara').select2('val');
            pend = $('#instansi_pendukung').select2('val');


            for(let key in pendukung) {
                if(data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                cari = $("#instansi_pendukung").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#instansi_pendukung').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
            }
        });
            // END Select Penyelenggara

            // Yang unselect Penyelenggara
        $('#instansi_penyelenggara').on('select2:unselect', function() {
            pendukung = @json($ins);

            // console.log(e.currentTarget.value);
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });

            data2 = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });


            peny = $('#instansi_penyelenggara').select2('val');
            pend = $('#instansi_pendukung').select2('val');


            for(let key in pendukung) {
                if(data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');
                    //$('#instansi_penyelenggara').append( (new Option(pendukung[key], key)).setAttribute('disabled','') );
                }
                if(!data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                cari = $("#instansi_pendukung").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#instansi_pendukung').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
                if(!data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

        });
            // END unselect Penyelenggara

            // Instansi Pendukung

        $('#instansi_pendukung').on('select2:select', function() {
            pendukung = @json($ins);

            // console.log(e.currentTarget.value);
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });

            data2 = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });


            peny = $('#instansi_penyelenggara').select2('val');
            pend = $('#instansi_pendukung').select2('val');


            for(let key in pendukung) {
                if(data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');
                    //$('#instansi_penyelenggara').append( (new Option(pendukung[key], key)).setAttribute('disabled','') );
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                cari = $("#instansi_pendukung").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#instansi_pendukung').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
            }

        });
            // END Instansi Pendukung

            // Pendukung unselect

        $('#instansi_pendukung').on('select2:unselect', function() {
            pendukung = @json($ins);

            // console.log(e.currentTarget.value);
            data = $('#instansi_penyelenggara').select2('data').map(function(elem){
                return elem.id
            });

            data2 = $('#instansi_pendukung').select2('data').map(function(elem){
                return elem.id
            });


            peny = $('#instansi_penyelenggara').select2('val');
            pend = $('#instansi_pendukung').select2('val');


            for(let key in pendukung) {
                if(data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');}
                if(!data2.includes(key)){
                    el = $("#instansi_penyelenggara").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in pendukung) {
                cari = $("#instansi_pendukung").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#instansi_pendukung').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
                if(!data.includes(key)){
                    el = $("#instansi_pendukung").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

        });

            // End pendukung unselect

        // End Instansi Penyelenggara dan Instansi Pendukung

        $('#narasumber').on('select2:select', function() {
            personal = @json($pers);
            data = $('#narasumber').select2('data').map(function(elem){
                return elem.id
            });
            data2 = $('#moderator').select2('data').map(function(elem){
                return elem.id
            });

            nara = $('narasumber').select2('val');
            mode = $('moderator').select2('val');


            for(let key in personal) {
                if(data2.includes(key)){
                    el = $("#narasumber").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');}
            }

            // Instansi Pendukung
            for(let key in personal) {
                cari = $("#moderator").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#moderator').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
            }

        });

        $('#narasumber').on('select2:unselect', function() {
            personal = @json($pers);
            data = $('#narasumber').select2('data').map(function(elem){
                return elem.id
            });
            data2 = $('#moderator').select2('data').map(function(elem){
                return elem.id
            });

            nara = $('narasumber').select2('val');
            mode = $('moderator').select2('val');

            for(let key in personal) {
                if(data2.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');
                    //$('#instansi_penyelenggara').append( (new Option(pendukung[key], key)).setAttribute('disabled','') );
                }
                if(!data2.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in personal) {
                cari = $("#moderator").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#moderator').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
                if(!data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

        });

        $('#moderator').on('select2:select', function() {
            personal = @json($pers);
            data = $('#narasumber').select2('data').map(function(elem){
                return elem.id
            });
            data2 = $('#moderator').select2('data').map(function(elem){
                return elem.id
            });

            nara = $('narasumber').select2('val');
            mode = $('moderator').select2('val');

            for(let key in personal) {
                if(data2.includes(key)){
                    el = $("#narasumber").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');
                    //$('#instansi_penyelenggara').append( (new Option(pendukung[key], key)).setAttribute('disabled','') );
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in personal) {
                cari = $("#moderator").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#moderator').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
            }

        });

        $('#moderator').on('select2:unselect', function() {
            personal = @json($pers);
            data = $('#narasumber').select2('data').map(function(elem){
                return elem.id
            });
            data2 = $('#moderator').select2('data').map(function(elem){
                return elem.id
            });

            nara = $('narasumber').select2('val');
            mode = $('moderator').select2('val');



            for(let key in personal) {
                if(data2.includes(key)){
                    el = $("#narasumber").find('option[value='+key+']')[0];
                    // console.log(el)
                    el.setAttribute('disabled','');}
                if(!data2.includes(key)){
                    el = $("#narasumber").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }

            // Instansi Pendukung
            // $('#instansi_pendukung').empty();
            for(let key in personal) {
                cari = $("#moderator").find('option[value='+key+']');
                if(cari.length == 0) {
                    $('#moderator').append(new Option(pendukung[key], key));
                }
                if(data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    el.setAttribute('disabled','');
                }
                if(!data.includes(key)){
                    el = $("#moderator").find('option[value='+key+']')[0];
                    // console.log(el);
                    if(el.disabled){
                        el.removeAttribute('disabled');
                    }
                }
            }
        });

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

            for(let key in sub_klas) {
                // console.log(sub_klas[key].ID_Keahlian);
                if(data[0] == sub_klas[key].ID_Keahlian){
                    //$('select[name="instansi_pendukung"]').append('<option value="'+ key +'">'+ key +'</option>');
                    $('#sub_klasifikasi').append(new Option(sub_klas[key].Deskripsi, sub_klas[key].ID_Sub_Bidang_Keahlian));
                    // console.log(sub_klas[key]);
                }
            }

            $('#sub_klasifikasi').select2({
            allowClear: true,
            maximumSelectionLength: 2,});
        });
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
