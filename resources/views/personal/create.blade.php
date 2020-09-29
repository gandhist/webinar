@extends('templates.header')

@section('content')
<style>
    /* .form-control {
        height: 29px;
        border-radius: 4px;
        border-color: #aaaaaa;
    } */

    .btn {
        border-radius: 4px !important;
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
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
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
        <div class="box-body">

            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            <form method="POST" action="{{ url('personals/store') }}" enctype="multipart/form-data">
            @csrf

                <div class="row">
                    {{-- Nama --}}
                    <div class="col-sm-12">
                        <div class="input-group {{ $errors->first('nama') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Nama Personil
                            </div>
                            <input name="nama" id="nama" type="text" class="form-control "
                                placeholder="*Nama Personil" value="{{old('nama')}}">
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
                                placeholder="*Refferensi" value="{{old('reff_p')}}">
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
                                <option value="1" {{ old('status_p') == '1' ? 'selected' : '' }}>Internal</option>
                                <option value="2" {{ old('status_p') == '2' ? 'selected' : '' }}>External</option>
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
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <span id="jenis_kelamin" class="help-block customspan">{{ $errors->first('jenis_kelamin') }}</span>
                    </div>
                    {{-- Akhir Jenis Kelamin --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Foto Diri --}}
                    <div class="col-sm-5">
                        <div
                            class="input-group {{ $errors->first('foto') ? 'has-error has-error-select' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> File Foto
                            </div>
                            <input style="padding:2px" class="form-control " accept=".pdf,.jpeg,.jpg"
                                name="foto" id="foto" type="file" placeholder="Pas Foto"
                                value="{{old('foto')}}" />
                            <span class="text-danger">Ukuran 3 x 4</span>
                        </div>
                        <span id="foto"
                            class="help-block customspan">{{ $errors->first('foto') }}</span>
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
                                value="{{old('nik')}}" maxlength="16">
                        </div>
                        <span id="nik" class="help-block customspan">{{ $errors->first('nik') }} </span>
                    </div>
                    {{-- Akhir NIK --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- File KTP --}}
                    <div class="col-sm-5">
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
                    {{-- Akhir File KTP --}}
                </div>

                <div class="row">
                    {{-- Alamat --}}
                    <div class="col-sm-12">
                        <div class="input-group {{ $errors->first('alamat') ? 'has-error' : '' }}">
                            <div class="input-group-addon">
                                <span class="bintang">*</span> Alamat
                            </div>
                            <input name="alamat" id="alamat" type="text" class="form-control "
                                placeholder="*Alamat Jalan, Kelurahan, Kecamatan" value="{{old('alamat')}}">
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
                                <span class="bintang">*</span> Provinsi
                            </div>
                            <select class="form-control select2" name="provinsi" id="provinsi" style="width: 100%;"
                                placeholder="*Provinsi Alamat">
                                <option value="" disabled selected>*Provinsi</option>
                                @foreach($provinsis as $key)
                                <option value="{{ $key->id }}" {{ $key->id == old('provinsi') ? 'selected' : '' }}>
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
                                <span class="bintang">*</span> Kota
                            </div>
                            <select class="form-control select2" name="kota" id="kota" style="width: 100%;">
                                <option value="" disabled selected>*Kota</option>
                                {{-- @foreach($kota as $key)
                                <option value="{{ $key->id }}" {{ $key->id == old('kota') ? 'selected' : '' }}>
                                {{ $key->nama }}</option>
                                @endforeach --}}
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
                                placeholder="*No HP" value="{{old('no_hp')}}">
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
                                placeholder="*Email" value="{{old('email')}}">
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
                                    {{ $key->id == old('temp_lahir') ? 'selected' : '' }}>
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
                                placeholder="*Tanggal Lahir ( dd/mm/yyyy )" value="{{old('tgl_lahir')}}">
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
                                <option value="" disabled selected>Agama</option>
                                <option value="islam" >Islam</option>
                                <option value="protestan" >Protestan</option>
                                <option value="katolik" >Katolik</option>
                                <option value="hindu" >Hindu</option>
                                <option value="buddha" >Buddha</option>
                                <option value="khonghucu" >Khonghucu</option>
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
                                <option value="islam" disabled selected>Status Pajak (PTKP)</option>
                                @foreach($ptkp as $key)
                                <option value="{{ $key->id }}"
                                    {{ $key->id == old('status_pajak') ? 'selected' : '' }}>
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
                                <option value="" disabled selected>Status Pernikahan</option>
                                <option value="BK" >Belum Kawin</option>
                                <option value="K" >Kawin</option>
                                <option value="CH" >Cerai Hidup</option>
                                <option value="CM" >Cerai Mati</option>
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
                                value="{{old('bpjs_no')}}" data-toggle="tooltip" data-placement="bottom"
                                title="Kosongkan Jika Tidak Ada No BPJS Kesehatan">
                        </div>
                        <span id="bpjs_no" class="help-block customspan">{{ $errors->first('bpjs_no') }} </span>
                    </div>
                    {{-- Akhir No BPJS --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Lampiran BPJS --}}
                    <div class="col-sm-5">
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
                                value="{{old('npwp')}}" data-toggle="tooltip" data-placement="bottom"
                                title="Kosongkan Jika Tidak Ada NPWP">
                        </div>
                        <span id="npwp" class="help-block customspan">{{ $errors->first('npwpClean') }} </span>
                    </div>
                    {{-- Akhir NPWP --}}
                    <div class="col-sm-2">
                    </div>
                    {{-- Lampiran NPWP --}}
                    <div class="col-sm-5">
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
                                placeholder="No Rekening Bank" value="{{old('no_rek')}}">
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
                                placeholder="Nama Rekening Bank" value="{{old('nama_rek')}}">
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
                                    {{ $key->id_bank == old('bank_id') ? 'selected' : '' }}>
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
                <div class="input-group">
                    <h4><b>Data Sekolah</b></h4>
                    <span class="input-group-btn">
                        <button id="addRow" type="button" class="btn btn-md btn-success pull-right"><i
                                class="fa fa-plus-circle"></i> Tambah Baris</button>
                    </span>
                </div>

                <table id="data-sekolah"
                    class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Jenjang_Pddk</th>
                            <th>Nama_Sklh</th>
                            <th>Negara_Sklh</th>
                            <th>Prov_Sklh</th>
                            <th>Kota_Sklh</th>
                            <th>Prodi</th>
                            <th>Tahun_tamat</th>
                            <th>No_Ijasah</th>
                            <th>Tgl_Ijasah</th>
                            <th>Default</th>
                            <th>Pdf_Ijs</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <input type="hidden" name='id_detail_sekolah' id='id_detail_sekolah' value=''>
                </div>

                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url('personals') }}" class="btn btn-md btn-default"><i class="fa fa-times-circle"></i>
                                Batal</a>
                        </div>
                    </div>
                </div>
                <br>

            </form>

            {{-- </div> Jumbotron --}}
        </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    var home = "{{ url('personals') }}";


    $(function() {
       // Tambah Baris Data Sekolah
       function add_Row(no) {
            if (no == 1) {
                a = `<option value="0">-- Pilih Default --</option>
                     <option value="1" selected>Default</option>`;
            } else {
                a = `<option value="0" selected>-- Pilih Default --</option>
                     <option value="1">Default</option>`;
            }

            $('#data-sekolah > tbody:last').append(`
                <tr class"odd" role="row">
                    <td style="text-align:center;">` + no + `</td>
                    <td>
                        <select required class="form-control select2" name="id_jp_` + no + `" id="id_jp_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($jenjang_pendidikan as $key)
                            <option value="{{ $key->id_jenjang }}"> {{ $key->deskripsi }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input required name="id_namasekolah_` + no + `" id="id_namasekolah_` + no + `" type="text" class="form-control " placeholder=""></td>
                    <td>
                        <select required class="form-control select2 negarasekolah" idprov="id_provsekolah_` + no +
                `" name="id_negarasekolah_` + no + `" id="id_negarasekolah_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($negara as $key)
                            <option value="{{ $key->id }}"> {{ $key->country_name }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 provsekolah" idkota="id_kotasekolah_` + no +
                `" name="id_provsekolah_` + no + `" id="id_provsekolah_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($provinsis as $key)
                            <option value="{{ $key->id }}"> {{ $key->nama }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2" name="id_kotasekolah_` + no +
                `" id="id_kotasekolah_` + no + `" style="width: 100%;">
                            <option value="" selected></option>
                        </select>
                    </td>
                    <td><input required name="id_prodi_` + no + `" id="id_prodi_` + no + `" type="text" class="form-control " placeholder=""></td>
                    <td style="width:10%">
                        <input required onkeypress="return isNumberKey(event)" name="id_tahuntamat_` + no +
                `" id="id_tahuntamat_` + no + `" type="text"
                            class="form-control tahun_tamat" placeholder="" maxlength="4">
                    </td>
                    <td><input required name="id_noijasah_` + no + `" id="id_noijasah_` + no + `" type="text" class="form-control " placeholder=""></td>
                    <td style="width:10%">
                        <input required autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                        class="form-control " id="id_tglijasah_` + no + `" name="id_tglijasah_` + no + `" placeholder="dd/mm/yyyyy">
                    </td>
                    <td>
                        <select required class="form-control select2 selectdefault" nomor="` + no +
                `" name="id_default_` + no +
                `" id="id_default_` +
                no + `" style="width: 100%;">
                            ` + a + `
                        </select>
                    </td>
                    <td  class="image-upload">
                        <label for="id_pdfijasah_` + no + `">
                                <i class="fa fa-upload" id="i_pdfijasah_` + no + `" style="padding-top:8px;padding-left:13px;color:grey" >  Upload</i>
                        </label>
                        <input accept=".pdf,.jpeg,.jpg" required idi="#i_pdfijasah_` + no + `" name="id_pdfijasah_` +
                no + `" id="id_pdfijasah_` + no + `" type="file" class="form-control cstmfile" placeholder="">

                    </td>
                    <td style="padding-top:4px">
                        <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor=" ` + no + `" >
                        <span class="fa fa-trash"></span></button>
                    </td
                </tr>
            `);
            $('.tahun_tamat').datepicker({
                format: "yyyy",
                // viewMode: "years",
                minViewMode: "years",
                endDate: "today"
            });

        };


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

        // Filter kota berdasarkan provinsi
        $('#id_prov').on('select2:select', function () {
            var id = $(this).val();

            var url = `{{ url('personals/chain') }}`;
            chainedProvinsi(url, 'id_prov', 'id_kota', "*Kota Alamat (Domisili)");
        });

        // Tambah Baris Data Sekolah
        var no = 1;
        var id_detail = [];
        $('#addRow').on('click', function () {
            add_Row(no);
            id_detail.push(no);
            $('#id_detail_sekolah').val(id_detail);
            $('.select2').select2();
            no++;
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

    });

    $(document).ready(function () {


        // $('body').on('change', '.form-group', function() {
        //     // Action goes here.
        // });
        // $('#provinsi').select2(); // Select2 Provinsi
        // $('#instansi').select2(); // Select2 instansi
        // $('#kota').select2(); // Select2 Kota
        // $('#jenis_kelamin').select2(); // Select2 JK
        // $('#temp_lahir').select2(); // Select2 Tempat Lahir
        // $('#bank_id').select2(); // Select2 Bank


        $('.select2').select2(); // Select2
        // Ajax Untuk Kota, Onchange Provinsi
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

        $('#tgl_lahir').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        });

        $('#tgl_lahir').mask("99-99-9999",{placeholder:"HH-BB-TTTT"});

        $('#npwp').mask("99.999.999.9-999.999",{placeholder:"Nomor Pokok Wajib Pajak"}).attr('maxlength','20');
    });

</script>
@endpush
