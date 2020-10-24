@extends('templates.header')

@section('content')
<style>
    form label.required:after {
        color: red;
        content: " *";
    }

    .input-group-addon {
        width: 180px;
        border-radius: 4px !important;
        text-align: left;
        font-weight: bold;
    }

    .input-group-addon::after {
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

    .form-control {
        border-color: #aaaaaa;
    }

    .bintang {
        color: red;
    }

</style>


<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Ubah Data Personal
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Personal</a></li>
        <li class="active"><a href="#"> Ubah Data</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            <form method="POST" action="{{ url('personals/update') }}" enctype="multipart/form-data">
            @method('PATCH')
            @csrf

                <div class="row">
                    {{-- Nama --}}
                    <div class="col-sm-12">
                        <div class="input-group {{ $errors->first('nama') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Nama Personil
                            </div>
                            <input name="nama" id="nama" type="text" class="form-control "
                                placeholder="*Nama Personil" value="{{old('nama') ? old('nama') : $data->nama}}">
                        </div>
                        <span id="nama"
                            class="help-block customspan">{{ $errors->first('nama') }}
                        </span>
                    </div>
                    {{-- Akhir Nama --}}
                </div>

                <div class="row">
                    {{-- Akhir Referensi --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('reff_p') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Refferensi
                            </div>
                            <input name="reff_p" id="reff_p" type="text" class="form-control "
                                placeholder="*Refferensi" value="{{old('reff_p') ? old('reff_p') : $data->reff_p}}">
                        </div>
                        <span id="reff_p" class="help-block customspan">{{ $errors->first('reff_p') }}</span>
                    </div>
                    {{-- Akhir Referensi --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Status --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('status_p') ? 'has-error-select has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Status
                            </div>
                            <select class="form-control select2" name="status_p" id="status_p"
                                placeholder="*Status" style="width: 100%;">
                                <option value="" disabled selected>*Status</option>
                                <option value="1" {{ (old('status_p') ? old('status_p') : $data->status_p) == '1' ? 'selected' : '' }}>Internal</option>
                                <option value="2" {{ (old('status_p') ? old('status_p') : $data->status_p) == '2' ? 'selected' : '' }}>External</option>
                            </select>
                        </div>
                        <span id="status_p" class="help-block customspan">{{ $errors->first('status_p') }}</span>
                    </div>
                    {{-- Akhir Status --}}
                </div>

                <div class="row">
                    {{-- Jenis Kelamin --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('jenis_kelamin') ? 'has-error-select has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Jenis Kelamin
                            </div>
                            <select class="form-control select2" name="jenis_kelamin" id="jenis_kelamin"
                                placeholder="*Jenis Kelamin" style="width: 100%;" value="{{old('jenis_kelamin')}}">
                                <option value="" disabled selected>*Jenis Kelamin</option>
                                <option value="L" {{ (old('jenis_kelamin') ? old('jenis_kelamin') : $data->jenis_kelamin ) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ (old('jenis_kelamin') ? old('jenis_kelamin') : $data->jenis_kelamin ) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <span id="jenis_kelamin" class="help-block customspan">{{ $errors->first('jenis_kelamin') }}</span>
                    </div>
                    {{-- Akhir Jenis Kelamin --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Foto Diri --}}
                    <div class="col-sm-4">
                        <div
                            class="input-group {{ $errors->first('foto') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> File Foto
                            </div>
                            <input style="padding:2px" class="form-control " accept=".pdf,.jpeg,.jpg"
                                name="foto" id="foto" type="file" placeholder="Pas Foto"
                                value="{{old('foto')}}" />
                            <span class="text-muted">Ukuran 3 x 4</span>
                        </div>
                        <span id="foto"
                            class="help-block customspan">{{ $errors->first('foto') }}</span>
                    </div>

                    <div class="col-sm-1" style="text-align:right;margin-left: -45px;">
                        @if($data->lampiran_foto)
                        <button type="button" id="btnFoto"
                            onclick='tampilLampiran("{{url($data->lampiran_foto)}}","Foto")'
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-file-pdf-o"></i> Foto</button>
                        @endif
                    </div>

                    {{-- Akhir Foto Diri --}}
                </div>

                <div class="row">
                    {{-- NIK --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('nik') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> NIK
                            </div>
                            <input name="nik" id="nik" type="text" class="form-control " placeholder="*NIK"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{old('nik') ?? $data->nik}}" maxlength="16">
                        </div>
                        <span id="nik" class="help-block customspan">{{ $errors->first('nik') }} </span>
                    </div>
                    {{-- Akhir NIK --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- File KTP --}}
                    <div class="col-sm-4">
                        <div
                            class="input-group {{ $errors->first('lampiran_ktp') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> File KTP
                            </div>
                            <input style="padding:2px" class="form-control " accept=".pdf,.jpeg,.jpg"
                                name="lampiran_ktp" id="lampiran_ktp" type="file" placeholder="KTP"
                                value="{{old('lampiran_ktp')}}" />
                        </div>
                        <span id="lampiran_ktp"
                            class="help-block customspan">{{ $errors->first('lampiran_ktp') }}</span>
                    </div>
                    <div class="col-sm-1" style="text-align:right;margin-left: -45px;">
                        @if($data->lampiran_ktp)
                        <button type="button" id="btnKtpPdf"
                            onclick='tampilLampiran("{{url($data->lampiran_ktp)}}","KTP")'
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-file-pdf-o"></i> KTP</button>
                        @endif
                    </div>
                    {{-- Akhir File KTP --}}
                </div>


                <div class="row">
                    {{-- Alamat KTP --}}
                    <div class="col-sm-12">
                        <div class="input-group {{ $errors->first('alamat_ktp') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Alamat (KTP)
                            </div>
                            <input name="alamat_ktp" id="alamat_ktp" type="text" class="form-control "
                                placeholder="*Alamat Jalan, Kelurahan, Kecamatan Kota (KTP)" value="{{old('alamat_ktp') ?? $data->alamat_ktp}}">
                        </div>
                        <span id="alamat_ktp" class="help-block customspan">{{ $errors->first('alamat_ktp') }}</span>
                    </div>
                    {{-- Akhir Alamat KTP --}}
                </div>

                <div class="row">
                    {{-- Provinsi KTP --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('provinsi_ktp') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Provinsi (KTP)
                            </div>
                            <select class="form-control select2" name="provinsi_ktp" id="provinsi_ktp" style="width: 100%;"
                                placeholder="*Provinsi Alamat (KTP)">
                                <option value="" disabled selected>*Provinsi (KTP)</option>
                                @foreach($provinsis as $key)
                                <option value="{{ $key->id }}" {{ (old('provinsi_ktp') ? ( $key->id == old('provinsi_ktp') ) : ( $key->id == $data->provinsi_id_ktp ) ) ? 'selected' : '' }}> {{-- Nested If macam apa ini--}}
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="provinsi_ktp" class="help-block customspan">{{ $errors->first('provinsi_ktp') }}</span>
                    </div>
                    {{-- Akhir Provinsi KTP --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Kota KTP --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('kota_ktp') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Kota (KTP)
                            </div>
                            <select class="form-control select2" name="kota_ktp" id="kota_ktp" style="width: 100%;">
                                <option value="" disabled selected>*Kota (KTP)</option>
                                @foreach($kotapil2 as $key)
                                <option value="{{ $key->id }}" {{ (old('kota_ktp') ? ( $key->id == old('kota_ktp') ) : ( $key->id == $data->kota_id_ktp ) ) ? 'selected' : '' }}>
                                {{ $key->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span id="kota_ktp" class="help-block customspan">{{ $errors->first('kota_ktp') }}</span>
                    </div>
                    {{-- Akhir Kota KTP --}}
                </div>

                <div class="row">
                    {{-- Alamat --}}
                    <div class="col-sm-12">
                        <div class="input-group {{ $errors->first('alamat') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Alamat (domisili)
                            </div>
                            <input name="alamat" id="alamat" type="text" class="form-control "
                                placeholder="*Alamat Jalan, Kelurahan, Kecamatan" value="{{old('alamat') ?? $data->alamat}}">
                        </div>
                        <span id="alamat" class="help-block customspan">{{ $errors->first('alamat') }}</span>
                    </div>
                    {{-- Akhir Alamat --}}
                </div>

                <div class="row">
                    {{-- Provinsi --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('provinsi') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Provinsi (domisili)
                            </div>
                            <select class="form-control select2" name="provinsi" id="provinsi" style="width: 100%;"
                                placeholder="*Provinsi Alamat">
                                <option value="" disabled selected>*Provinsi (domisili)</option>
                                @foreach($provinsis as $key)
                                <option value="{{ $key->id }}" {{ (old('provinsi') ? ( $key->id == old('provinsi') ) : ( $key->id == $data->provinsi_id ) ) ? 'selected' : '' }}> {{-- Nested If macam apa ini--}}
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="provinsi" class="help-block customspan">{{ $errors->first('provinsi') }}</span>
                    </div>
                    {{-- Akhir Provinsi --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Kota --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('kota') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Kota (domisili)
                            </div>
                            <select class="form-control select2" name="kota" id="kota" style="width: 100%;">
                                <option value="" disabled selected>*Kota (domisili)</option>
                                @foreach($kotapil as $key)
                                <option value="{{ $key->id }}" {{ (old('kota') ? ( $key->id == old('kota') ) : ( $key->id == $data->kota_id ) ) ? 'selected' : '' }}>
                                {{ $key->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span id="kota" class="help-block customspan">{{ $errors->first('kota') }}</span>
                    </div>
                    {{-- Akhir Kota --}}
                </div>

                <div class="row">
                    {{-- No Hp --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('no_hp') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> No HP
                            </div>
                            <input name="no_hp" id="no_hp" type="text" class="form-control "
                            onkeypress="return /[0-9]/i.test(event.key)"
                                placeholder="*No HP" value="{{old('no_hp') ?? $data->no_hp}}">
                        </div>
                        <span id="no_hp"
                            class="help-block customspan">{{ $errors->first('no_hp') }}</span>
                    </div>
                    {{-- Akhir No Hp --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Email --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('email') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Email
                            </div>
                            <input name="email" id="email" type="email" class="form-control "
                                placeholder="*Email" value="{{old('email') ?? $data->email}}">
                        </div>
                        <span id="email" class="help-block customspan">{{ $errors->first('email') }}</span>
                    </div>
                    {{-- Akhir Email --}}
                </div>

                <div class="row">
                    {{-- Tempat Lahir --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('temp_lahir') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Tempat Lahir
                            </div>
                            <select class="form-control select2" name="temp_lahir" id="temp_lahir"
                                style="width: 100%;" placeholder="*Tempat Lahir">
                                <option value="" disabled selected>*Tempat Lahir</option>
                                @foreach($kotas as $key)
                                <option value="{{ $key->id }}"
                                    {{ (old('temp_lahir') ? ( $key->id == old('temp_lahir') ) : ( $key->id == $data->temp_lahir ) ) ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="temp_lahir"
                            class="help-block customspan">{{ $errors->first('temp_lahir') }}</span>
                    </div>
                    {{-- Akhir Tempat Lahir --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Tanggal Lahir --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('tgl_lahir') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Tanggal Lahir
                            </div>
                            <input autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                type="text" class="form-control " id="tgl_lahir" name="tgl_lahir"
                                placeholder="*Tanggal Lahir ( dd/mm/yyyy )" value="{{\Carbon\Carbon::parse(old('tgl_lahir') ?? $data->tgl_lahir)->format('d-m-Y')}}">
                        </div>
                        <span id="tgl_lahir"
                            class="help-block customspan">{{ $errors->first('tgl_lahir') }}</span>
                    </div>
                    {{-- Akhir Tanggal Lahir --}}
                </div>


                <div class="row">
                    {{-- Agama --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('agama') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                Agama
                            </div>
                            <select class="form-control select2" name="agama" id="agama" style="width: 100%;"
                                placeholder="Agama">
                                <option value="" disabled>Agama</option>
                                <option {{ (old('agama') ?? $data->agama) == "islam" ? "selected" : "" }}      value="islam" >Islam</option>
                                <option {{ (old('agama') ?? $data->agama) == "protestan" ? "selected" : "" }}  value="protestan" >Protestan</option>
                                <option {{ (old('agama') ?? $data->agama) == "katolik" ? "selected" : "" }}    value="katolik" >Katolik</option>
                                <option {{ (old('agama') ?? $data->agama) == "hindu" ? "selected" : "" }}      value="hindu" >Hindu</option>
                                <option {{ (old('agama') ?? $data->agama) == "buddha" ? "selected" : "" }}     value="buddha" >Buddha</option>
                                <option {{ (old('agama') ?? $data->agama) == "khonghucu" ? "selected" : "" }}  value="khonghucu" >Khonghucu</option>
                            </select>
                        </div>
                        <span id="agama" class="help-block customspan">{{ $errors->first('agama') }}</span>
                    </div>
                    {{-- Akhir Agama --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Status Pajak --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('status_pajak') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                Status Pajak
                            </div>
                            <select class="form-control select2" name="status_pajak" id="status_pajak" style="width: 100%;"
                                placeholder="Status Pajak">
                                <option value="" disabled selected>Status Pajak (PTKP)</option>
                                @foreach($ptkp as $key)
                                <option value="{{ $key->id }}"
                                    {{ (old('status_pajak') ? ( $key->id == old('status_pajak') ) : ( $key->id == $data->id_ptkp ) ) ? 'selected' : '' }}>
                                    {{ $key->nama_ptkp }} ({{$key->remarks}}) </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="status_pajak"
                            class="help-block customspan">{{ $errors->first('status_pajak') }}</span>
                    </div>
                    {{-- Akhir Status Pajak --}}
                </div>

                <div class="row">
                    {{-- Status Pernikahan --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('status_perni') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                Status Pernikahan
                            </div>
                            <select class="form-control select2" name="status_perni" id="status_perni" style="width: 100%;"
                                placeholder="Status Pernikahan">
                                <option value="" disabled>Status Pernikahan</option>
                                <option {{ (old('status_perni') ?? $data->status_pernikahan) == "BK" ? "selected" : "" }} value="BK" >Belum Kawin</option>
                                <option {{ (old('status_perni') ?? $data->status_pernikahan) == "K" ? "selected" : "" }}  value="K" >Kawin</option>
                                <option {{ (old('status_perni') ?? $data->status_pernikahan) == "CH" ? "selected" : "" }} value="CH" >Cerai Hidup</option>
                                <option {{ (old('status_perni') ?? $data->status_pernikahan) == "CM" ? "selected" : "" }} value="CM" >Cerai Mati</option>
                            </select>
                        </div>
                        <span id="status_perni" class="help-block customspan">{{ $errors->first('status_perni') }}</span>
                    </div>
                    {{-- Akhir Status Pernikahan --}}
                </div>


                <div class="row">
                    {{-- No BPJS --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('bpjs_no') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                No BPJS Kesehatan
                            </div>
                            <input type="text"
                            onkeypress="return /[0-9]/i.test(event.key)"
                                maxlength="13"
                                id="bpjs_no" name="bpjs_no" class="form-control " placeholder="No BPJS Kesehatan"
                                value="{{old('bpjs_no') ?? $data->bpjs}}" data-toggle="tooltip" data-placement="bottom"
                                title="Kosongkan Jika Tidak Ada No BPJS Kesehatan">
                        </div>
                        <span id="bpjs_no" class="help-block customspan">{{ $errors->first('bpjs_no') }} </span>
                    </div>
                    {{-- Akhir No BPJS --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Lampiran BPJS --}}
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                File BPJS Kesehatan
                            </div>
                            <input style="padding: 2px;" class="form-control" accept=".pdf,.jpeg,.jpg,.png"
                                name="lampiran_bpjs" id="lampiran_bpjs" type="file" placeholder="No BPJS Kesehatan"
                                value="{{old('lampiran_bpjs')}}" />
                        </div>
                        <span id="lampiran_bpjs"
                            class="help-block customspan">{{ $errors->first('lampiran_bpjs') }}</span>
                    </div>
                    <div class="col-sm-1" style="text-align:right;margin-left: -45px;">
                        @if($data->lampiran_bpjs)
                        <button type="button" id="btnBpjs"
                            onclick='tampilLampiran("{{url($data->lampiran_bpjs)}}","BPJS")'
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-file-pdf-o"></i> BPJS</button>
                        @endif
                    </div>
                    {{-- Akhir Lampiran BPJS --}}
                </div>

                <div class="row">
                    {{-- NPWP --}}
                    <div class="col-sm-5">
                        <div class="input-group {{ $errors->first('npwpClean') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                NPWP
                            </div>
                            <input type="text"
                                id="npwp" name="npwp" class="form-control " placeholder="*NPWP"
                                value="{{old('npwp') ?? $data->npwp}}" data-toggle="tooltip" data-placement="bottom"
                                title="Kosongkan Jika Tidak Ada NPWP">
                        </div>
                        <span id="npwp" class="help-block customspan">{{ $errors->first('npwpClean') }} </span>
                    </div>
                    {{-- Akhir NPWP --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Lampiran NPWP --}}
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                File NPWP
                            </div>
                            <input style="padding: 2px;" class="form-control" accept=".pdf,.jpeg,.jpg"
                                name="lampiran_npwp" id="lampiran_npwp" type="file" placeholder="NPWP"
                                value="{{old('lampiran_npwp')}}" />
                        </div>
                        <span id="lampiran_npwp"
                            class="help-block customspan">{{ $errors->first('lampiran_npwp') }}</span>
                    </div>
                    <div class="col-sm-1" style="text-align:right;margin-left: -45px;">
                        @if($data->lampiran_npwp)
                        <button type="button" id="btnKtpPdf" id="btn-npwp"
                            onclick='tampilLampiran("{{url($data->lampiran_npwp)}}","NPWP")'
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-file-pdf-o"></i> NPWP</button>
                        @endif
                    </div>
                    {{-- Akhir Lampiran NPWP --}}
                </div>

                <div class="row">
                    {{-- Nomor Rekening --}}
                    <div class="col-sm-5">
                        <div class="input-group">
                            <div class="input-group-addon">
                                No Rekening Bank
                            </div>
                            <input name="no_rek" id="no_rek" type="text" class="form-control "
                                onkeypress="return /[0-9]/i.test(event.key)"
                                placeholder="No Rekening Bank" value="{{old('no_rek') ?? $data->no_rek}}">
                        </div>
                        <span id="no_rek"
                            class="help-block customspan">{{ $errors->first('no_rek') }}</span>
                    </div>
                    {{-- Akhir Nomor Rekening --}}
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Nama Rekening Bank
                            </div>
                            <input name="nama_rek" id="nama_rek" type="text" class="form-control "
                                placeholder="Nama Rekening Bank" value="{{old('nama_rek') ?? $data->nama_rek}}">
                        </div>
                        <span id="nama_rek"
                            class="help-block customspan">{{ $errors->first('nama_rek') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Nama Bank
                            </div>
                            <select class="form-control select2" name="bank_id" id="bank_id"
                                style="width: 100%;" placeholder="Nama Bank">
                                <option value="" disabled selected>Nama Bank</option>
                                @foreach($banks as $key)
                                <option value="{{ $key->id_bank }}"
                                    {{ (old('bank_id') ? ( $key->id_bank == old('bank_id') ) : ( $key->id_bank == $data->id_bank ) )  ? 'selected' : '' }}>
                                    {{ $key->Nama_Bank }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <span id="bank_id"
                            class="help-block customspan">{{ $errors->first('bank_id') }}</span>
                    </div>
                </div>

                <div class="row" style="text-align:right">
                    <div class="col-sm-12">
                        <span class="bintang"><b>*</b></span> Wajib Diisi
                    </div>
                </div>

                <br>
                <div class="btn-group btn-lg pull-right">
                    <button id="addRow" type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Baris</button>
                </div>

                <div class="box-body">
                    <table id="data-sekolah" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                        <thead>
                            <tr role="row">
                                <th>No</th>
                                <th style="width:6%;">Jenjang_Pddk</th>
                                <th style="width:19%;">Nama_Sklh</th>
                                <th style="width:7%;">Negara_Sklh</th>
                                <th style="width:10%;">Prov_Sklh</th>
                                <th style="width:5%;">Kota_Sklh</th>
                                <th style="width:10%;">Prodi</th>
                                <th style="width:6%;">Tahun_Tamat</th>
                                <th style="width:11%;">No_Ijasah</th>
                                <th style="width:7%;">Tgl_Ijasah</th>
                                <th style="width:5%;">Default</th>
                                <th style="width:5%;">Pdf_Ijs</th>
                                <th style="width:4%;">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail_sekolah as $key)
                            <tr>
                                <input type="hidden" name='type_detail_{{$loop->iteration}}' id='type_detail_{{$loop->iteration}}' value='{{$key->id}}'>

                                <td style="text-align:center;">{{$loop->iteration}}</td>
                                <td>
                                    <select class="form-control select2" name="id_jp_{{$loop->iteration}}" id="id_jp_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="" disabled selected></option>
                                        @foreach($jenjang_pendidikan as $select)
                                        <option value="{{ $select->id_jenjang }}" {{ $select->id_jenjang == $key->id_jenjang ? "selected" : "1" }} > {{ $select->deskripsi }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                 <input type="text" class="form-control " placeholder="Nama Sekolah"
                                        name="id_namasekolah_{{$loop->iteration}}" id="id_namasekolah_{{$loop->iteration}}"
                                        value="{{$key->nama_sekolah}}"></td>
                                </td>
                                <td>
                                    <select class="form-control select2 negara_sekolah" idprov_sekolah="id_provsekolah_{{$loop->iteration}}" name="id_negarasekolah_{{$loop->iteration}}" id="id_negarasekolah_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="" disabled selected></option>
                                        @foreach($negara as $select)
                                        <option value="{{ $select->id }}" {{ $select->id == $key->negara ? "selected" : "" }} > {{ $select->country_name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2 prov_sekolah" idkota_sekolah="id_kotasekolah_{{$loop->iteration}}" name="id_provsekolah_{{$loop->iteration}}" id="id_provsekolah_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="" disabled selected></option>
                                        @foreach($prov as $select)
                                        <option value="{{ $select->id }}" {{ $select->id == $key->prop_sekolah ? "selected" : "" }} > {{ $select->nama }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="id_kotasekolah_{{$loop->iteration}}" id="id_kotasekolah_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="" disabled selected></option>
                                        @foreach($kota as $select)
                                        <option value="{{ $select->id }}" {{ $select->id == $key->kota_sekolah ? "selected" : "" }} > {{ $select->nama }} </option>
                                        @endforeach
                                    </select>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control "
                                        name="id_prodi_{{$loop->iteration}}" id="id_prodi_{{$loop->iteration}}"
                                        value="{{$key->jurusan}}">
                                </td>
                                <td>
                                    <input onkeypress="return isNumberKey(event)" type="text" class="form-control " placeholder="Tahun Tamat"
                                        name="id_tahuntamat_{{$loop->iteration}}" id="id_tahuntamat_{{$loop->iteration}}"
                                        value="{{$key->tahun}}" maxlength="4">
                                </td>
                                <td>
                                    <input type="text" class="form-control " placeholder="No Ijasah"
                                        name="id_noijasah_{{$loop->iteration}}" id="id_noijasah_{{$loop->iteration}}"
                                        value="{{$key->no_ijazah}}">
                                </td>
                                <td>
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyyy" type="text"
                                        class="form-control " id="id_tglijasah_{{$loop->iteration}}" name="id_tglijasah_{{$loop->iteration}}" value="{{isset ($key->tgl_ijasah) ? date('d/m/Y', strtotime($key->tgl_ijasah)) : ''}}">
                                </td>
                                <td>
                                    <select class="form-control select2 selectdefault" nomor="{{$loop->iteration}}" name="id_default_{{$loop->iteration}}" id="id_default_{{$loop->iteration}}" style="width: 100%;">
                                    @if ($key->default == 1)
                                        <option value="0">-- Pilih Default --</option>
                                        <option value="1" selected>Default</option>
                                    @else
                                    <option value="0" selected>-- Pilih Default --</option>
                                        <option value="1" >Default</option>
                                    @endif
                                    </select>
                                </td>
                                <td class="image-upload">
                                    <input accept=".pdf,.jpeg,.jpg" class="cstmfile" type="file" idi="#i_pdfijasah_{{$loop->iteration}}" name="id_pdfijasah_{{$loop->iteration}}" id="id_pdfijasah_{{$loop->iteration}}">
                                    <label for="id_pdfijasah_{{$loop->iteration}}">
                                        <i id="i_pdfijasah_{{$loop->iteration}}" class="fa fa-upload" style="padding-top:7px;color:grey">  Upload</i>
                                    </label>
                                    @if($key->pdf_ijasah!="")
                                            <button type="button" id="btnKtpPdf" id="btn-npwp"
                                                onclick='tampilLampiran("{{asset($key->pdf_ijasah)}}","Ijasah")'
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-file-pdf-o"></i></button>
                                            @endif
                                </td>
                                {{-- <td style="border-left:0px !important;padding-top:8px">
                                    <button type="button" id="btnIjsPdf" onclick='tampilLampiran("{{ asset("uploads/$key->pdf_ijasah") }}","Ijasah")' class="btn btn-primary btn-xs">
                                        <i class="fa fa-file-pdf-o" ></i></button>

                                </td> --}}
                                <td style="padding-top:7px">
                                    <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="{{$loop->iteration}}" onclick=""><span
                                            class="fa fa-trash"></span></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <input type="hidden" name='id_detail_sekolah' id='id_detail_sekolah' value=''>
                <input type="hidden" name='id' value='{{$id}}'>

                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6" >
                            <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-sm-6" >
                            <button type="button" onclick="goBack()" class="btn btn-md btn-default"><i
                                class="fa fa-times-circle"></i>
                            Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<!-- Modal Lampiran -->
<div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title" id="lampiranTitle"></h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                  <iframe src="" id="iframeLampiran" width="100%" height="500px" frameborder="0" allowtransparency="true"></iframe>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>

      </div>
    </div>
  </div>
  <!-- End of Modal Lampiran -->
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    $('.select2').select2();

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


        // Ajax Untuk Kota, Onchange Provinsi
        $('#provinsi_ktp').on('change', function(e){
            $('select[name="kota_ktp"]').empty();
            var id = e.target.value;
            //
            if(id) {
                $.ajax({
                    url: '/personals/create/getKota/'+id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="kota_ktp"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kota_ktp"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="kota_ktp"]').empty();
            }
            //
            $('#kota_ktp').select2();
        });


        // Tambah Baris Data Sekolah
        function add_Row(no){
            if (no == 1) {
                a = `<option value="0">-- Pilih Default --</option>
                     <option value="1" selected>Default</option>`;
            } else {
                a = `<option value="0" selected>-- Pilih Default --</option>
                     <option value="1">Default</option>`;
            }
            $('#data-sekolah > tbody:last').append(`
                <tr class"odd" role="row">
                    <input type="hidden" name="type_detail_` + no + `" id="type_detail_` + no + `" value="">
                    <td style="text-align:center;">` + no + `</td>
                    <td>
                        <select required class="form-control select2" name="id_jp_` + no + `" id="id_jp_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($jenjang_pendidikan as $key)
                            <option value="{{ $key->id_jenjang }}"> {{ $key->deskripsi }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input required name="id_namasekolah_` + no + `" id="id_namasekolah_` + no + `" type="text" class="form-control" placeholder=""></td>
                    <td>
                        <select required class="form-control select2 negarasekolah" idprov="id_provsekolah_` + no + `" name="id_negarasekolah_` + no + `" id="id_negarasekolah_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($negara as $key)
                            <option value="{{ $key->id }}"> {{ $key->country_name }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 provsekolah" idkota="id_kotasekolah_` + no + `" name="id_provsekolah_` + no + `" id="id_provsekolah_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($prov as $key)
                            <option value="{{ $key->id }}"> {{ $key->nama }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2" name="id_kotasekolah_` + no + `" id="id_kotasekolah_` + no + `" style="width: 100%;">
                            <option value="" selected></option>
                        </select>
                    </td>
                    <td><input required name="id_prodi_` + no + `" id="id_prodi_` + no + `" type="text" class="form-control" placeholder=""></td>
                    <td><input required onkeypress="return isNumberKey(event)" name="id_tahuntamat_` + no + `" id="id_tahuntamat_` + no + `" type="text" class="form-control" placeholder=""></td>
                    <td><input required name="id_noijasah_` + no + `" id="id_noijasah_` + no + `" type="text" class="form-control" placeholder=""></td>
                    <td>
                        <input required autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                        class="form-control" id="id_tglijasah_` + no + `" name="id_tglijasah_` + no + `" placeholder="dd/mm/yyyy">
                    </td>
                    <td>
                        <select required class="form-control select2 selectdefault" nomor="` + no +`" name="id_default_` + no + `" id="id_default_` + no + `" style="width: 100%;">
                          `+ a +`
                        </select>
                    </td>

                    <td style="border-right:0px !important; width:2%" class="image-upload">
                        <input class="cstmfile" accept=".pdf,.jpeg,.jpg" type="file" idi="#i_pdfijasah_` + no + `" name="id_pdfijasah_` + no + `" id="id_pdfijasah_` + no + `">
                        <label for="id_pdfijasah_` + no + `">
                            <i id="i_pdfijasah_` + no + `" class="fa fa-upload" style="padding-top:7px;color:grey">  Upload</i>
                        </label>
                    </td>

                    <td style="padding-top:7px;">
                        <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor=" ` + no + `" onclick="">
                        <span class="fa fa-trash"></span></button>
                    </td
                </tr>
            `);
        }

        // Tambah Baris Data Sekolah
        var no = 1;
        var id_detail = [];
        var jumlah_detail = "{{ $jumlahdetail }}";

        for (index = 1; index <= jumlah_detail; index++) {
            id_detail.push(no);
            $('#id_detail_sekolah').val(id_detail);
            no++;
        }
        $('#addRow').on('click', function () {
            add_Row(no);
            id_detail.push(no);
            $('#id_detail_sekolah').val(id_detail);
            $('.select2').select2();
            no++;
        });

        $(document).on('change', '.selectdefault', function (e) {
            x = $(this).val();
            nomor = $(this).attr('nomor');
            if (x == 1) {
                id_detail.forEach(function (entry) {
                    if (nomor == entry) {

                    } else {
                        $('#id_default_' + entry).html(
                            '<option value="0" selected>-- Pilih Default --</option><option value="1">Default</option>'
                        );
                    }
                    // console.log(entry);
                });
            } else {
                alert('Data Sekolah harus memiliki 1 default');
                $(this).val('1');
                $(this).trigger('change');
            }
        });

        // Hapus Baris Data Sekolah
        $(document).on('click', '.btn-detail-hapus', function (e) {
            nomor = $(this).attr('nomor');
            var removeItem = nomor;
            id_detail = jQuery.grep(id_detail, function (value) {
                return value != removeItem;
            });
            $('#id_detail_sekolah').val(id_detail);
            $(this).closest('tr').remove();
        });

        // Filter provinsi sekolah berdasarkan negara sekolah
        $(document).on('change', '.negarasekolah', function (e) {
            idnegara = $(this).attr('id');
            idprov = $(this).attr('idprov');

            var url = `{{ url('chainnegara') }}/` + idnegara;
            chainedNegara(url, idnegara, idprov, "*Prov Sekolah");
        });

        // Filter kota sekolah berdasarkan provinsi sekolah
        $(document).on('change', '.provsekolah', function (e) {
            idprov = $(this).attr('id');
            idkota = $(this).attr('idkota');

            var url = `{{ url('personals/chain') }}`;
            chainedProvinsi(url, idprov, idkota, "*Kota Sekolah");
        });

</script>
@endpush
