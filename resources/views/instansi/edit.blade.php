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
    .input-group-addon::after {
        content: " :";
    }

    .input-group-addon {
        width: 180px;
        border-radius: 4px !important;
        text-align: left;
        font-weight: bold;
    }

    .input-group-addon:after {
        content: " :";
    }

    .input-group {
        width: 100%;
    }

    input {
        height: 28.8px !important;
        border-radius: 4px !important;
        width: 100%;
        /* border-color: #aaaaaa !important; */
    }

    input::placeholder {
        color: #444 !important;
    }

    .bintang {
        color: red;
    }

    .form-control {
        border-color: #aaaaaa;
    }
</style>


<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Ubah Data Badan Usaha P3S - Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Badan Usaha</a></li>
        <li class="active"><a href="#"> Ubah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            <form method="POST" action="{{ url('instansi/update') }}" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
                <div class="row">
                    {{-- Nama Instansi --}}
                    <div class="col-sm-12 {{ $errors->first('nama_bu') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Nama Badan Usaha
                            </div>
                            <input name="nama_bu" id="nama_bu" type="text" class="form-control"
                                placeholder=""
                                value="{{old('nama_bu') ? old('nama_bu') : $data->nama_bu}}">
                        </div>
                        <span id="nama_bu"
                            class="help-block customspan">{{ $errors->first('nama_bu') }}
                        </span>
                        @if(session()->get('nama_bu'))
                        <span id="nama_bu"
                            class="help-block customspan">{{ session()->get('nama_bu') }} </span>
                        @endif
                    </div>
                    {{-- Akhir Nama Instansi --}}
                </div>

                <div class="row">
                    {{-- Singkat Badan Usaha  --}}
                    <div class="col-sm-5 {{ $errors->first('singkat_bu') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Singkat Badan Usaha
                            </div>
                            <input name="singkat_bu" id="singkat_bu" type="text" class="form-control"
                                placeholder="" value="{{$data->singkat_bu}}">
                        </div>
                        <span id="singkat_bu" class="help-block customspan">{{ $errors->first('singkat_bu') }}
                        </span>
                    </div>
                    {{-- Akhir Singkat Badan Usaha  --}}

                    <div class="col-sm-2">

                    </div>

                    {{-- Bentuk Badan Usaha --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('bentuk_bu') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Bentuk BU
                            </div>
                            <select class="form-control select2" name="bentuk_bu" id="bentuk_bu"
                                style="width: 100%;">
                                <option value="" {{empty($data->id_bentuk_usaha) ? 'disabled selected' : ''}}></option>
                                @foreach($bentukusaha as $key)
                                <option value="{{ $key->id }}"
                                    {{ $key->id == $data->id_bentuk_usaha ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="bentuk_bu" class="help-block customspan">{{ $errors->first('bentuk_bu') }}
                        </span>
                    </div>
                    {{-- Akhir Bentuk Badan Usaha --}}
                </div>


                <div class="row">
                    {{--  Status Kantor --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('status_kantor') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Status Badan Usaha
                            </div>
                            <select class="form-control select2" name="status_kantor" id="status_kantor"
                                style="width: 100%;" {{ empty($data->status_kantor) ? '' : 'disabled'}}>
                                <option value="" disabled  {{empty($data->status_kantor) ? 'selected' : ''}}></option>
                                @foreach($statusmodel as $key)
                                <option value="{{ $key->id }}"  urutan="{{ $key->urutan }}"
                                    {{ $key->id == $data->status_kantor ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="status_kantor"
                            class="help-block customspan">{{ $errors->first('status_kantor') }} </span>
                    </div>
                    {{-- Akhir Status Kantor --}}

                    <div class="col-sm-2">
                    </div>

                    {{-- Kantor Atas --}}
                    <div class="col-sm-5 {{ $errors->first('bu_atas') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Badan Usaha Pusat
                            </div>
                            <select class="form-control select2" name="bu_atas" id="bu_atas"
                                style="width: 100%;">
                                <option value="" disabled selected></option>
                                @foreach($bulevelatas as $key)
                                <option value="{{ $key->id }}"
                                    {{ $key->id == $data->level_atas ? 'selected' : '' }}>
                                    {{ $key->nama_bu }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="bu_atas" class="help-block customspan">{{ $errors->first('bu_atas') }}
                        </span>
                    </div>
                    {{-- Akhir Kantor Atas --}}
                </div>


                <div class="row">
                    {{-- Alamat --}}
                    <div class="col-sm-12 {{ $errors->first('alamat') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Alamat
                            </div>
                            <input name="alamat" id="alamat" class="form-control"
                                placeholder="" value="{{old('alamat') ?? $data->alamat}}">
                        </div>
                        <span id="alamat" class="help-block customspan">{{ $errors->first('alamat') }}
                        </span>
                    </div>
                    {{-- Akhir Alamat --}}
                </div>

                <div class="row">
                    {{-- Provinsi --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('id_prop') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Provinsi BU
                            </div>
                            <select class="form-control select2" name="id_prop" id="id_prop"
                                style="width: 100%;">
                                <option value="" disabled></option>
                                @foreach($provinsi as $key)
                                <option value="{{ $key->id }}"
                                    {{ (old('id_prop') ?? $data->id_prop ) == $key->id ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="id_prop" class="help-block customspan">{{ $errors->first('id_prop') }}
                        </span>
                    </div>
                    {{-- Akhir Provinsi --}}

                    <div class="col-sm-2">
                    </div>

                    {{-- Kota --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('id_kota') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Kota BU
                            </div>
                            <select class="form-control select2" name="id_kota" id="id_kota"
                                style="width: 100%;">
                                <option value="" disabled></option>
                                @foreach($kotapil as $key)
                                <option value="{{ $key->id }}" {{ $key->id == (old('kota') ?? $data->id_kota) ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="id_kota" class="help-block customspan">{{ $errors->first('id_kota') }}
                        </span>
                    </div>
                    {{-- Akhir Kota --}}
                </div>

                <div class="row">
                    {{-- No Telp --}}
                    <div class="col-sm-5 {{ $errors->first('telp') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> No Tlp
                            </div>
                            <input name="telp" id="telp" type="text" class="form-control"
                                placeholder="" value="{{old('telp') ?? $data->telp}}">
                        </div>
                        <span id="telp" class="help-block customspan">{{ $errors->first('telp') }}
                        </span>
                    </div>
                    {{-- Akhir No Telp --}}

                    <div class="col-sm-2">

                    </div>

                    {{-- Email --}}
                    <div class="col-sm-5 {{ $errors->first('email') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Email
                            </div>
                            <input name="email" id="email" type="email" class="form-control"
                                placeholder="" value="{{old('email') ?? $data->email}}">
                        </div>
                        <span id="email" class="help-block customspan">{{ $errors->first('email') }} </span>
                    </div>
                    {{-- Akhir Email --}}
                </div>

                <div class="row">
                    {{-- Instansi Reff --}}
                    <div class="col-sm-5 {{ $errors->first('instansi_reff') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Instansi Reff
                            </div>
                            <input name="instansi_reff" id="instansi_reff" type="text" class="form-control"
                                placeholder="" value="{{old('instansi_reff') ?? $data->instansi_reff}}">
                        </div>
                        <span id="instansi_reff" class="help-block customspan">{{ $errors->first('instansi_reff') }}
                        </span>
                    </div>
                    {{-- Akhir Instansi Reff --}}

                    <div class="col-sm-2">

                    </div>

                    {{-- Web --}}
                    <div class="col-sm-5 {{ $errors->first('web') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Web
                            </div>
                            <input name="web" id="web" type="text" class="form-control" placeholder=""
                                value="{{old('web') ?? $data->web}}">
                        </div>
                        <span id="web" class="help-block customspan">{{ $errors->first('web') }} </span>
                    </div>
                    {{-- Akhir Web --}}
                </div>


            <div class="row">
                {{-- Nama Pimpinan --}}
                <div class="col-sm-5  {{ $errors->first('nama_pimp_text') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Pimpinan
                        </div>
                        <select name="nama_pimp_select" id="nama_pimp_select" type="text" class="form-control select2"
                        placeholder="" value="{{old('nama_pimp')}}">
                            <option value="" disabled {{ !(old('nama_pimp') ?? $data->id_personal_pimp) ? 'selected' : ''}}></option>
                            @foreach($personal as $key)
                            <option value="{{ $key->id }}" {{ $key->id == (old('nama_pimp') ?? $data->id_personal_pimp) ? 'selected' : '' }}>
                                {{ $key->nama }} </option>
                            @endforeach
                        </select>
                        <input name="nama_pimp_text" id="nama_pimp_text" type="text" class="form-control"
                        placeholder="" value="{{(null !== old('isi_manual')) ? '' : old('nama_pimp_text')}}" style="display:none">
                    </div>
                    <span id="nama_pimp" class="help-block customspan">{{ $errors->first('nama_pimp_text') }} </span>
                </div>
                {{-- Akhir Nama Pimpinan --}}

                <div class="col-sm-2">
                    <label for="isi_manual">
                        <input type="checkbox" name="isi_manual" id="isi_manual"> <span>Isi manual</span>
                    </label>
                </div>

                {{-- Jabatan Pimpinan --}}
                <div class="col-sm-5  {{ $errors->first('jab_pimp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Jabatan Pimpinan
                        </div>
                        <input name="jab_pimp" id="jab_pimp" type="text" class="form-control"
                        placeholder="" value="{{old('isi_manual') ?? $data->jab_pimp}}" readonly >
                    </div>
                    <span id="jab_pimp" class="help-block customspan">{{ $errors->first('jab_pimp') }} </span>
                </div>
                {{-- Akhir Jabatan Pimpinan --}}
            </div>


            <div class="row">
                {{-- No Hp Pimpinan --}}
                <div class="col-sm-5  {{ $errors->first('hp_pimp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            No Hp Pimpinan
                        </div>
                        <input name="hp_pimp" id="hp_pimp" type="text" class="form-control"
                        placeholder="" value="{{old('hp_pimp') ?? $data->hp_pimp}}" readonly
                        onkeypress="return /[0-9]/i.test(event.key)">
                    </div>
                    <span id="hp_pimp" class="help-block customspan">{{ $errors->first('hp_pimp') }} </span>
                </div>
                {{-- Akhir No Hp Pimpinan --}}

                <div class="col-sm-2">
                </div>

                {{-- Email Pimpinan --}}
                <div class="col-sm-5  {{ $errors->first('email_pimp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email Pimpinan
                        </div>
                        <input name="email_pimp" id="email_pimp" type="email" class="form-control"
                        placeholder="" value="{{old('email_pimp') ?? $data->email_pimp}}" readonly >
                    </div>
                    <span id="email_pimp" class="help-block customspan">{{ $errors->first('email_pimp') }}
                    </span>
                </div>
                {{-- Akhir Email Pimpinan --}}
            </div>


            <div class="row">
                {{-- Nama Kontak Person --}}
                <div class="col-sm-5 {{ $errors->first('kontak_p') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Nama Kontak Person
                        </div>
                        <input name="kontak_p" id="kontak_p" type="text" class="form-control"
                            placeholder="" value="{{old('kontak_p') ?? $data->kontak_p}}">
                    </div>
                    <span id="kontak_p" class="help-block customspan">{{ $errors->first('kontak_p') }}
                    </span>
                </div>
                {{-- Akhir Nama Kontak Person --}}

                <div class="col-sm-2">

                </div>

                {{-- Jabatan Kontak Person --}}
                <div class="col-sm-5 {{ $errors->first('jab_kontak_p') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Jabatan Kontak Person
                        </div>
                        <input name="jab_kontak_p" id="jab_kontak_p" type="text" class="form-control"
                            placeholder="" value="{{old('jab_kontak_p') ?? $data->jab_kontak_p}}">
                    </div>
                    <span id="jab_kontak_p" class="help-block customspan">{{ $errors->first('jab_kontak_p') }} </span>
                </div>
                {{-- Akhir Jabatan Kontak Person --}}
            </div>

            <div class="row">
                {{-- No Hp Kontak Person --}}
                <div class="col-sm-5 {{ $errors->first('no_kontak_p') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> No HP Kontak Person
                        </div>
                        <input name="no_kontak_p" id="no_kontak_p" type="text" class="form-control"
                            placeholder="" value="{{old('no_kontak_p') ?? $data->no_kontak_p}}">
                    </div>
                    <span id="no_kontak_p" class="help-block customspan">{{ $errors->first('no_kontak_p') }} </span>
                </div>
                {{-- Akhir No Hp Kontak Person --}}

                <div class="col-sm-2">

                </div>

                {{-- Email Kontak Person --}}
                <div class="col-sm-5 {{ $errors->first('email_kontak_p') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email Kontak Person
                        </div>
                        <input name="email_kontak_p" id="email_kontak_p" type="email" class="form-control"
                            placeholder="" value="{{old('email_kontak_p') ?? $data->email_kontak_p}}">
                    </div>
                    <span id="email_kontak_p" class="help-block customspan">{{ $errors->first('email_kontak_p') }}
                    </span>
                </div>
                {{-- Akhir Email Kontak Person --}}
            </div>

            <div class="row">
                {{-- No NPWP --}}
                <div class="col-sm-5 {{ $errors->first('npwpClean') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> No NPWP
                        </div>
                        <input type="text" data-inputmask="'mask': ['99.999.999.9-999.999']" data-mask=""
                            id="npwp" name="npwp" class="form-control" placeholder=""
                            value="{{preg_replace("/[\.-]/", "",  (old('npwp') ?? $data->npwp)) ?? ''}}">
                    </div>
                    <span id="npwp" class="help-block customspan">{{ $errors->first('npwpClean') }} </span>
                </div>
                {{-- Akhir No NPWP --}}

                <div class="col-sm-2">

                </div>

                {{-- File NPWP --}}
                <div class="col-sm-4 {{ $errors->first('npwp_pdf') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon" style="vertical-align:top;">
                            File NPWP
                        </div>
                        <input style="padding:2px" type="file" class="form-control" id="npwp_pdf"
                            name="npwp_pdf" placeholder="">
                        <span id="npwp_pdf"
                            class="help-block customspan">{{ $errors->first('npwp_pdf') }}</span>
                        <span style="color: #737373;">Format : pdf</span>
                    </div>
                </div>
                <div class="col-sm-1" style="text-align:right">
                    @if($data->npwp_pdf)
                    <button type="button" id="btnKtpPdf" id="btn-npwp"
                        onclick='tampilLampiran("{{asset($data->npwp_pdf)}}","NPWP")'
                        class="btn btn-primary btn-sm">
                        <i class="fa fa-file-pdf-o"></i> NPWP</button>
                    @endif
                </div>
                {{-- Akhir File NPWP --}}
            </div>


            <div class="row">
                {{-- Nama Rekening Bank --}}
                <div class="col-sm-5 {{ $errors->first('no_rek') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            No Rekening Bank
                        </div>
                        <input name="no_rek" id="no_rek" type="text" class="form-control"
                            placeholder="" value="{{old('no_rek') ?? $data->no_rek}}">
                    </div>
                    <span id="no_rek" class="help-block customspan">{{ $errors->first('no_rek') }}
                    </span>
                </div>

                <div class="col-sm-2">

                </div>

                <div class="col-sm-5 {{ $errors->first('nama_rek') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Rekening Bank
                        </div>
                        <input name="nama_rek" id="nama_rek" type="text" class="form-control"
                            placeholder="" value="{{old('nama_rek') ?? $data->nama_rek}}">
                    </div>
                    <span id="nama_rek"
                        class="help-block customspan">{{ $errors->first('nama_rek') }}
                    </span>
                </div>
                {{-- Akhir Nama Rekening Bank --}}
            </div>

            <div class="row">
                {{-- Nama Bank --}}
                <div class="col-sm-12 {{ $errors->first('id_bank') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Bank
                        </div>
                        <select class="form-control select2" name="id_bank" id="id_bank"
                            style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($bank as $key)
                            <option value="{{ $key->id_bank }}"
                                {{ $key->id_bank == (old('id_bank') ?? $data->id_bank )? 'selected' : '' }}> {{ $key->Nama_Bank }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <span id="id_bank" class="help-block customspan">{{ $errors->first('id_bank') }}
                    </span>
                </div>
                {{-- Akhir Nama Bank --}}
            </div>

            <div class="row">
                {{-- Logo --}}
                <div class="col-sm-4 {{ $errors->first('logo') ? 'has-error' : '' }}"
                    style="margin-bottom: -15px;">
                    <div class="input-group">
                        <div class="input-group-addon" style="vertical-align:top;">
                            Logo
                        </div>
                        <input style="padding:2px" type="file" class="form-control" id="logo" name="logo"
                            placeholder="">
                        <span id="logo" class="help-block customspan">{{ $errors->first('logo') }}</span>
                        <span style="color: #737373;">Format : jpg,jpeg,png</span>
                    </div>
                </div>

                <div class="col-sm-1" style="text-align:right">
                    @if($data->logo)
                    <button type="button" id="btnLogo"
                        onclick='tampilLampiran("{{asset($data->logo)}}","Logo")'
                        class="btn btn-primary btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Logo</button>
                    @endif
                </div>
                {{-- Akhir Logo --}}
            </div>
            <input type="hidden" name="id" value="{{$id}}">

            <div class="row" style="text-align:right">
                <div class="col-sm-12">
                    <span class="bintang"><b>*</b></span> Wajib Diisi
                </div>
            </div>

            <div class="box-footer" style="text-align:center">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                            Simpan</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" onclick="goBack()" class="btn btn-md btn-default"><i
                                class="fa fa-times-circle"></i>
                            Batal</button>
                    </div>
                </div>
            </div>

            </form>

        </div> {{-- Jumbotron --}}
    </div> {{-- Container-fluid --}}
</section>


{{-- Modal Foto --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Foto Diri</h4>
        </div>
        <div class="modal-body">
            <center>
            <img src="{{ isset($instansi->logo) ? url($instansi->logo) : '/'}}" alt="Foto Diri">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- Akhir Modal Foto --}}
@endsection

    <!-- modal lampiran -->
    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="lampiranTitle"></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <iframe src="" id="iframeLampiran" width="100%" height="500px" frameborder="0"
                                allowtransparency="true"></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
    <!-- end of modal lampiran -->

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">

$('.select2').select2();

var personal = @json($personal);
    $("#isi_manual").prop("checked", false);
    $(document).ready(function () {
        $('#isi_manual').change(function() {
            if($(this).is(":checked")) {
                $('#nama_pimp_select').next(".select2-container").hide();
                $('#nama_pimp_text').show();
                $('#jab_pimp').prop('readonly', false);
                $('#email_pimp').prop('readonly', false);
                $('#hp_pimp').prop('readonly', false);
                $('#jab_pimp').val('');
                $('#email_pimp').val('');
                $('#hp_pimp').val('');

            } else {
                $('#nama_pimp_select').next(".select2-container").show();
                $('#nama_pimp_text').hide();
                $('#jab_pimp').prop('readonly', true);
                $('#email_pimp').prop('readonly', true);
                $('#hp_pimp').prop('readonly', true);
                $('#jab_pimp').val('');
                $('#email_pimp').val('');
                $('#hp_pimp').val('');
                isi_om_jin()
            }
        });

        $('#nama_pimp_select').on('select2:select', function() {
            isi_om_jin()
        });

        function isi_om_jin() {
            var isi = $('#nama_pimp_select').val();
            // var coba = mana_nih(isi, personal);
            var coba = personal.filter( obj => {
                return obj.id == isi
            })
            coba = coba[0]

            $('#jab_pimp').val(coba.jabatan);
            $('#email_pimp').val(coba.email);
            $('#hp_pimp').val(coba.no_hp);
        }

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

        $('#status_kantor').on('select2:select', function () {
            changelevelatas($(this).val());
        });

        function changelevelatas(value) {

            var url = "{{ url('instansi/changelevelatas') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_status: value
                },
                success: function (response) {
                    console.log(response['data']);

                    if (response['level'] != 1 && response['data'].length <= 0) {
                        $('#status_kantor').val("").trigger('change.select2');

                        alert('Level atas belum terdaftar');
                        $('#bu_atas').val("").trigger('change.select2');
                        $("#bu_atas").html(
                            "<option value='' disabled selected></option>"
                        );

                    } else {
                        $("#bu_atas").html(
                            "<option value='' disabled></option>");
                        $("#bu_atas").select2({
                            data: response['data']
                        }).val(null).trigger('change');
                        $('#bu_atas').val($('#bu_atas option:eq(1)').val()).trigger(
                            'change.select2');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }
    });






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


        // format input
        $('[data-mask]').inputmask()
        // $('#npwp').mask("99.999.999.9-999.999",{placeholder:""}).attr('maxlength','20');
    });
</script>
@endpush
