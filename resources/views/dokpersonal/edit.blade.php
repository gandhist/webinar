@extends('templates.header')

@section('content')
<style>
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
        border-color: #aaaaaa !important;
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
        Ubah Dokumen Personil PKB P3S Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="/dokpersonal">Dok Personil</a></li>
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

            <form action="{{ url('dokpersonal/update', $data->id) }}" class="form-horizontal" id="formAdd"
                name="formAdd" method="post" enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama PJK3
                                </div>
                                <select disabled class="form-control select2" name="id_nama_pjk3" id="id_nama_pjk3"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($instansi as $key)
                                    <option value="{{ $key->id }}"
                                        {{ $key->id == $data->id_skp_pjk3 ? 'selected' : '' }}>
                                        {{ $key->nama_bu }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="{{$data->id_skp_pjk3}}" name="id_nama_pjk3" id="id_nama_pjk3">
                            <span id="id_nama_pjk3"
                                class="help-block customspan">{{ $errors->first('id_nama_pjk3') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Personil
                                </div>
                                <select disabled class="form-control select2" name="id_personal" id="id_personal"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($personil as $key)
                                    <option value="{{ $key->id }}"
                                        {{ $key->id == $data->id_personal ? 'selected' : '' }}>
                                        {{ $key->nama }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="{{$data->id_personal}}" name="id_personal" id="id_personal">
                            <span id="id_personal"
                                class="help-block customspan">{{ $errors->first('id_personal') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Refferensi
                                </div>
                                <input name="id_reff" id="id_reff" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->reff_p}}" disabled>
                            </div>
                            <span id="id_reff" class="help-block customspan">{{ $errors->first('id_reff') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Status
                                </div>
                                <input class="form-control" name="id_status" id="id_status" placeholder=""
                                    value="@if ($data->personal->status_p == '1') Internal @else External @endif"
                                    disabled>
                            </div>
                            <span id="id_status" class="help-block customspan">{{ $errors->first('id_status') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jenis Kelamin
                                </div>
                                <input class="form-control" name="id_jenkel" id="id_jenkel" placeholder=""
                                    value="@if ($data->personal->jns_kelamin == 'L') Laki-laki @else Perempuan @endif"
                                    disabled>
                            </div>
                            <span id="id_jenkel" class="help-block customspan">{{ $errors->first('id_jenkel') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            @if($data->personal->foto_pdf)
                            <button type="button" id="FotoPdf"
                                onclick='tampilLampiran("/uploads/{{ $data->personal->foto_pdf }}","Foto")'
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File Foto</button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    NIK
                                </div>
                                <input name="nik" id="nik" type="text" class="form-control" placeholder=""
                                    value="{{$data->personal->nik}}" disabled>
                            </div>
                            <span id="nik" class="help-block customspan">{{ $errors->first('nik') }} </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            @if($data->personal->ktp_pdf)
                            <button type="button" id="KtpPdf"
                                onclick='tampilLampiran("/uploads/{{ $data->personal->ktp_pdf }}","KTP")'
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File KTP</button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Alamat (KTP)
                                </div>
                                <input name="id_ktp_alamat" id="id_ktp_alamat" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->alamat_ktp}}"
                                    disabled>
                            </div>
                            <span id="id_ktp_alamat" class="help-block customspan">{{ $errors->first('id_ktp_alamat') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Prov Alamat (KTP)
                                </div>
                                <input class="form-control" name="id_ktp_prov" id="id_ktp_prov" placeholder=""
                                    value="{{$data->personal->kode_kota_ktp ? $data->personal->kota_ktp->provinsi->nama :''}}" disabled>
                            </div>
                            <span id="id_ktp_prov" class="help-block customspan">{{ $errors->first('id_ktp_prov') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Kota Alamat (KTP)
                                </div>
                                <input class="form-control" name="id_ktp_kota" id="id_ktp_kota" placeholder=""
                                    value="{{$data->personal->kode_kota_ktp ? $data->personal->kota_ktp->nama :''}}" disabled>
                            </div>
                            <span id="id_ktp_kota" class="help-block customspan">{{ $errors->first('id_ktp_kota') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Alamat (Domisili)
                                </div>
                                <input name="id_alamat" id="id_alamat" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->alamat}}"
                                    disabled>
                            </div>
                            <span id="id_alamat" class="help-block customspan">{{ $errors->first('id_alamat') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Prov Alamat (Domisili)
                                </div>
                                <input class="form-control" name="id_prov" id="id_prov" placeholder=""
                                    value="{{$data->personal->kota->provinsi->nama}}" disabled>
                            </div>
                            <span id="id_prov" class="help-block customspan">{{ $errors->first('id_prov') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Kota Alamat (Domisili)
                                </div>
                                <input class="form-control" name="id_kota" id="id_kota" placeholder=""
                                    value="{{$data->personal->kota->nama}}" disabled>
                            </div>
                            <span id="id_kota" class="help-block customspan">{{ $errors->first('id_kota') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No HP
                                </div>
                                <input name="id_no_telp" id="id_no_telp" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->hp_wa}}" disabled>
                            </div>
                            <span id="id_no_telp"
                                class="help-block customspan">{{ $errors->first('id_no_telp') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email
                                </div>
                                <input name="id_email" id="id_email" type="email" class="form-control"
                                    placeholder="" value="{{$data->personal->email_p}}" disabled>
                            </div>
                            <span id="id_email" class="help-block customspan">{{ $errors->first('id_email') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Tempat Lahir
                                </div>
                                <input class="form-control" name="id_temp_lahir" id="id_temp_lahir"
                                    placeholder="" value="{{$data->personal->tempLahir->ibu_kota}}"
                                    disabled>
                            </div>
                            <span id="id_temp_lahir"
                                class="help-block customspan">{{ $errors->first('id_temp_lahir') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Tanggal Lahir
                                </div>
                                <input class="form-control" id="id_tgl_lahir" name="id_tgl_lahir"
                                    placeholder=""
                                    value="{{ isset($data->personal->tgl_lahir) ? \Carbon\Carbon::parse($data->personal->tgl_lahir)->isoFormat("DD MMMM YYYY") : ''}}"
                                    disabled>
                            </div>
                            <span id="id_tgl_lahir"
                                class="help-block customspan">{{ $errors->first('id_tgl_lahir') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Agama
                                </div>
                                <input class="form-control" name="agama" id="agama" placeholder=""
                                    value="{{ucfirst($data->personal->agama)}}" disabled>
                            </div>
                            <span id="agama" class="help-block customspan">{{ $errors->first('agama') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Status Pajak
                                </div>
                                <input class="form-control" id="status_pajak" name="status_pajak"
                                    placeholder=""
                                    value="@if($data->personal->id_ptkp!=null) {{$data->personal->ptkp_r->nama_ptkp}} ( {{$data->personal->ptkp_r->remarks}} ) @else @endif"
                                    disabled>
                            </div>
                            <span id="status_pajak"
                                class="help-block customspan">{{ $errors->first('status_pajak') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Status Pernikahan
                                </div>
                                @if($data->personal->status_pernikahan=='K')
                                @php
                                $st_pernikahan = "Kawin";
                                @endphp
                                @elseif($data->personal->status_pernikahan=='BK')
                                @php
                                $st_pernikahan = "Belum Kawin";
                                @endphp
                                @elseif($data->personal->status_pernikahan=='CH')
                                @php
                                $st_pernikahan = "Cerai Hidup";
                                @endphp
                                @elseif($data->personal->status_pernikahan=='CM')
                                @php
                                $st_pernikahan = "Cerai Mati";
                                @endphp
                                @else
                                @php
                                $st_pernikahan = "";
                                @endphp
                                @endif
                                <input class="form-control" name="status_perni" id="status_perni"
                                    placeholder="" value="{{$st_pernikahan}}" disabled>
                            </div>
                            <span id="status_perni"
                                class="help-block customspan">{{ $errors->first('status_perni') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No BPJS Kesehatan
                                </div>
                                <input class="form-control" name="bpjs_no" id="bpjs_no" placeholder=""
                                    value="{{$data->personal->bpjs_no}}" disabled>
                            </div>
                            <span id="bpjs_no" class="help-block customspan">{{ $errors->first('bpjs_no') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            @if($data->personal->bpjs_pdf=="")

                            @else
                            <button type="button" id="btnBpjsPdf"
                                onclick='tampilLampiran("/uploads/{{$data->personal->bpjs_pdf}}","Foto BPJS")'
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File BPJS</button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    NPWP
                                </div>
                                <input id="npwp" name="npwp" class="form-control" placeholder=""
                                    value="{{$data->personal->npwp}}" disabled>
                            </div>
                            <span id="npwp" class="help-block customspan">{{ $errors->first('npwp') }} </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            @if($data->personal->npwp_pdf)
                            <button type="button" id="NpwpPdf"
                                onclick='tampilLampiran("/uploads/{{ $data->personal->npwp_pdf }}","NPWP")'
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File NPWP</button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Rekening Bank
                                </div>
                                <input name="id_norek_bank" id="id_norek_bank" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->no_rek}}" disabled>
                            </div>
                            <span id="id_norek_bank"
                                class="help-block customspan">{{ $errors->first('id_norek_bank') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Rekening Bank
                                </div>
                                <input name="id_namarek_bank" id="id_namarek_bank" type="text" class="form-control"
                                    placeholder="" value="{{$data->personal->nama_rek}}" disabled>
                            </div>
                            <span id="id_namarek_bank"
                                class="help-block customspan">{{ $errors->first('id_namarek_bank') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        Nama Bank
                                    </div>
                                    <input class="form-control" name="id_nama_bank" id="id_nama_bank"
                                        placeholder=""
                                        value="{{ isset($data->personal->bank->Nama_Bank) ? $data->personal->bank->Nama_Bank : ''}}"
                                        disabled>
                                </div>
                                <span id="id_nama_bank"
                                    class="help-block customspan">{{ $errors->first('id_nama_bank') }}</span>
                            </div>

                            <div class="row" style="text-align:right">
                                <div class="col-sm-12">
                                    <span class="bintang"><b>*</b></span> Wajib Diisi
                                </div>
                            </div>
                        </div>

                        <b>Data Sekolah</b>

                        <table id="data-sekolah"
                            class="table table-bordered table-hover dataTable customTable customTableDetail"
                            role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width:3%;">No</th>
                                    <th style="width:6%;">Jenjang_Pddk</th>
                                    <th style="width:18%;">Nama_Sklh</th>
                                    <th style="width:7%;">Negara_Sklh</th>
                                    <th style="width:10%;">Prov_Sklh</th>
                                    <th style="width:11%;">Kota_Sklh</th>
                                    <th style="width:9%;">Prodi</th>
                                    <th style="width:6%;">Tahun_Tamat</th>
                                    <th style="width:11%;">No_Ijasah</th>
                                    <th style="width:9%;">Tgl_Ijasah</th>
                                    <th style="width:6%;">Default</th>
                                    <th style="width:5%;">Pdf_Ijs</th>
                                    {{-- <th style="border-right:0px !important;border-bottom:0px !important;border-top:0px !important;background-color:white;"></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail_sekolah as $key)
                                <tr>
                                    <td style="text-align:center;">{{$loop->iteration}}</td>
                                    <td>
                                        <input disabled type="text" class="form-control"
                                            placeholder="" name="id_jp_{{$loop->iteration}}"
                                            id="id_jp_{{$loop->iteration}}" value="{{$key->jp->deskripsi}}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control " placeholder=""
                                            name="id_namasekolah_{{$loop->iteration}}"
                                            id="id_namasekolah_{{$loop->iteration}}" value="{{$key->nama_sekolah}}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control" placeholder=""
                                            name="id_negarasekolah_{{$loop->iteration}}"
                                            id="id_negarasekolah_{{$loop->iteration}}"
                                            value="{{ isset($key->negara_s->country_name) ?$key->negara_s->country_name : '' }}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control" placeholder=""
                                            name="id_provsekolah_{{$loop->iteration}}"
                                            id="id_provsekolah_{{$loop->iteration}}" value="{{$key->prov_s->nama}}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control" placeholder=""
                                            name="id_kotasekolah_{{$loop->iteration}}"
                                            id="id_kotasekolah_{{$loop->iteration}}" value="{{$key->kota_s->nama}}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control "
                                            name="id_prodi_{{$loop->iteration}}" id="id_prodi_{{$loop->iteration}}"
                                            value="{{$key->jurusan}}">
                                    </td>
                                    <td>
                                        <input disabled onkeypress="return isNumberKey(event)" type="text"
                                            class="form-control " placeholder=""
                                            name="id_tahuntamat_{{$loop->iteration}}"
                                            id="id_tahuntamat_{{$loop->iteration}}" value="{{$key->tahun}}"
                                            maxlength="4">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control " placeholder=""
                                            name="id_noijasah_{{$loop->iteration}}"
                                            id="id_noijasah_{{$loop->iteration}}" value="{{$key->no_ijazah}}">
                                    </td>
                                    <td>
                                        <input disabled autocomplete="off"
                                            data-provide="datepicker" data-date-format="yyyy-mm-dd" type="text"
                                            class="form-control " id="id_tglijasah_{{$loop->iteration}}"
                                            name="id_tglijasah_{{$loop->iteration}}"
                                            value="{{isset ($key->tgl_ijasah) ? \Carbon\Carbon::parse($data->personal->tgl_ijasah)->isoFormat("DD MMMM YYYY") : ''}}">
                                    </td>
                                    <td>
                                        <input disabled type="text" class="form-control" placeholder=""
                                            name="id_default_{{$loop->iteration}}" id="id_default_{{$loop->iteration}}"
                                            value=" @if ($loop->iteration > 1) @else Default @endif ">
                                    </td>
                                    <td style="border-left:0px !important;padding-top:4px;padding-left:13px;">
                                        <button type="button" id="btnIjsPdf"
                                            onclick='tampilLampiran("{{ asset("uploads/$key->pdf_ijasah") }}","Ijasah")'
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-file-pdf-o"></i> Lihat</button>
                                    </td>
                                    {{-- <td style="border-right:0px !important;border-bottom:0px !important;"></td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <button id="addRow" type="button" class="btn btn-success pull-right"><i
                                class="fa fa-plus-circle"></i> Tambah Dok</button>
                        <br>

                        <b>Data Dokumen Personil</b>
                        <div class="withscroll">
                            <table id="data-dokpersonil"
                                class="table table-bordered table-hover dataTable customTable customTableDetail"
                                role="grid">
                                <thead>
                                    <tr role="row">
                                        <th>No</th>
                                        <th>Bidang_Dok</th>
                                        <th>Nama_Dok</th>
                                        <th>Jenis_Dok</th>
                                        <th>Instansi_Dok</th>
                                        <th>Penyelenggara</th>
                                        <th>No_Dok</th>
                                        <th>Tgl_Terbit</th>
                                        <th>Tgl_Akhir</th>
                                        <th>Pdf_Dok</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailAk3 as $key)
                                    <tr>
                                        <td style="text-align:center;">{{$loop->iteration}} <input type="hidden"
                                                name='type_detail_{{$loop->iteration}}'
                                                id='type_detail_{{$loop->iteration}}' value='{{$key->id}}'></td>
                                        <td>
                                            <select class="form-control select2 bidang_dok"
                                                id_srtfalat="id_srtfalat_{{$loop->iteration}}"
                                                name="id_bidang_{{$loop->iteration}}"
                                                id="id_bidang_{{$loop->iteration}}" style="width: 100%;">
                                                <option value="{{$key->bidang_ak3->id}}">
                                                    {{$key->bidang_ak3->kode_bidang}}
                                                    ({{$key->bidang_ak3->jenis_usaha->kode_jns_usaha}})</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2 nama_srtf"
                                                id_bidang="id_bidang_{{$loop->iteration}}"
                                                name="id_srtfalat_{{$loop->iteration}}"
                                                id="id_srtfalat_{{$loop->iteration}}" style="width: 100%;">
                                                <option value="{{$key->bid_sertifikat_alat->id}}">
                                                    {{$key->bid_sertifikat_alat->nama_srtf_alat}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2 jns_dok"
                                                id_namadok="id_namadok_{{$loop->iteration}}"
                                                name="id_jenisdok_{{$loop->iteration}}"
                                                id="id_jenisdok_{{$loop->iteration}}" style="width: 100%;">
                                                <option value="{{$key->jenisdok_ak3->id}}">
                                                    {{$key->jenisdok_ak3->Nama_jns_dok}}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input autocomplete="off" name="id_instansidok_{{$loop->iteration}}" id="id_instansidok_{{$loop->iteration}}" type="text"
                                            class="form-control instdok" placeholder="" value="{{$key->instansi_skp}}">
                                        </td>
                                        <td>
                                            <input autocomplete="off" name="id_penyelenggara_{{$loop->iteration}}" id="id_penyelenggara_{{$loop->iteration}}" type="text"
                                            class="form-control penye" placeholder="" value="{{$key->penyelenggara}}">
                                        </td>

                                        {{-- @php
                                        $inst = '';
                                        @endphp
                                        @foreach($instansi as $rw)
                                            @if ($rw->singkat_bu == $key->instansi_skp)
                                                @php
                                                    $inst = 'Y';
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($inst == 'Y')
                                            <td style="border-right:0px !important;">
                                                <select class="form-control select2 instdok" idinstan2="id_instansidok2_{{$loop->iteration}}" name="id_instansidok_{{$loop->iteration}}"
                                                    id="id_instansidok_{{$loop->iteration}}" style="width: 100%;">
                                                    <option value="" disabled selected></option>
                                                    @foreach($instansi as $row)
                                                    <option value="{{ $row->singkat_bu }}" {{ $row->singkat_bu == $key->instansi_skp ? "selected" : "" }} > {{ $row->singkat_bu }}
                                                    </option>
                                                    @endforeach
                                                    <option value="lain">LAINNYA</option>
                                                </select>
                                            </td>
                                            <td style="border-left:0px !important;">
                                                <input readonly="readonly" name="id_instansidok2_{{$loop->iteration}}" id="id_instansidok2_{{$loop->iteration}}" type="text"
                                                class="form-control" placeholder="" value="">
                                            </td>
                                        @else
                                            <td style="border-right:0px !important;">
                                                <select class="form-control select2 instdok" idinstan2="id_instansidok2_{{$loop->iteration}}" name="id_instansidok_{{$loop->iteration}}"
                                                    id="id_instansidok_{{$loop->iteration}}" style="width: 100%;">
                                                    <option value="" disabled ></option>
                                                    @foreach($instansi as $row)
                                                    <option value="{{ $row->singkat_bu }}"> {{ $row->singkat_bu }}
                                                    </option>
                                                    @endforeach
                                                    <option value="lain" selected>LAINNYA</option>
                                                </select>
                                            </td>
                                            <td style="border-left:0px !important;">
                                                <input name="id_instansidok2_{{$loop->iteration}}" id="id_instansidok2_{{$loop->iteration}}" type="text"
                                                class="form-control" placeholder="" value="{{$key->instansi_skp}}">
                                            </td>
                                        @endif --}}

                                        {{-- @php
                                        $inst = '';
                                        @endphp
                                        @foreach($instansi as $rw)
                                            @if ($rw->singkat_bu == $key->penyelenggara)
                                                @php
                                                    $inst = 'Y';
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($inst == 'Y')
                                            <td style="border-right:0px !important;">
                                                <select class="form-control select2 penye" idpenye2="id_penyelenggara2_{{$loop->iteration}}" name="id_penyelenggara_{{$loop->iteration}}"
                                                    id="id_penyelenggara_{{$loop->iteration}}" style="width: 100%;">
                                                    <option value="" disabled selected></option>
                                                    @foreach($instansi as $row)
                                                    <option value="{{ $row->singkat_bu }}" {{ $row->singkat_bu == $key->penyelenggara ? "selected" : "" }} > {{ $row->singkat_bu }}
                                                    </option>
                                                    @endforeach
                                                    <option value="lain">LAINNYA</option>
                                                </select>
                                            </td>
                                            <td style="border-left:0px !important;">
                                                <input readonly="readonly" name="id_penyelenggara2_{{$loop->iteration}}" id="id_penyelenggara2_{{$loop->iteration}}" type="text"
                                                class="form-control" placeholder="" value="">
                                            </td>
                                        @else
                                            <td style="border-right:0px !important;">
                                                <select class="form-control select2 penye" idpenye2="id_penyelenggara2_{{$loop->iteration}}" name="id_penyelenggara_{{$loop->iteration}}"
                                                    id="id_penyelenggara_{{$loop->iteration}}" style="width: 100%;">
                                                    <option value="" disabled ></option>
                                                    @foreach($instansi as $row)
                                                    <option value="{{ $row->singkat_bu }}"> {{ $row->singkat_bu }}
                                                    </option>
                                                    @endforeach
                                                    <option value="lain" selected>LAINNYA</option>
                                                </select>
                                            </td>
                                            <td style="border-left:0px !important;">
                                                <input name="id_penyelenggara2_{{$loop->iteration}}" id="id_penyelenggara2_{{$loop->iteration}}" type="text"
                                                class="form-control" placeholder="" value="{{$key->penyelenggara}}">
                                            </td>
                                        @endif --}}

                                        <td><input name="id_nodokumen_{{$loop->iteration}}"
                                                id="id_nodokumen_{{$loop->iteration}}" type="text" class="form-control"
                                                placeholder="" value="{{$key->no_skp}}"></td>
                                        <td style="width:10%">
                                            <input autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control" id="id_tglterbit_{{$loop->iteration}}"
                                                name="id_tglterbit_{{$loop->iteration}}" placeholder=""
                                                value="{{isset ($key->tgl_skp) ?  date('d/m/Y', strtotime($key->tgl_skp)) : ''}}">
                                        </td>
                                        <td style="width:10%">
                                            <input autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control" id="id_tglakhir_{{$loop->iteration}}"
                                                name="id_tglakhir_{{$loop->iteration}}" placeholder=""
                                                value="{{isset ($key->tgl_akhir_skp) ? date('d/m/Y', strtotime($key->tgl_akhir_skp)) : ''}}">
                                        </td>
                                        <td class="image-upload">
                                            <label for="id_pdfdok_{{$loop->iteration}}">
                                                <i id="i_pdfdok_{{$loop->iteration}}" class="fa fa-upload"
                                                    style="padding-top:8px;padding-left:5px;color:grey">
                                                    Upload</i>
                                            </label>
                                            <input accept=".pdf,.jpeg,.jpg" class="cstmfile" idi="#i_pdfdok_{{$loop->iteration}}"
                                                name="id_pdfdok_{{$loop->iteration}}"
                                                id="id_pdfdok_{{$loop->iteration}}" type="file" placeholder="">
                                            @if($key->pdf_skp_ak3!="")
                                            <button type="button" id="btnKtpPdf" id="btn-npwp"
                                                onclick='tampilLampiran("/uploads/{{$key->pdf_skp_ak3}}","PDF_Dok")'
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-file-pdf-o"></i></button>
                                            @endif
                                        </td>
                                        <td style="padding-top:7px;">
                                            <button type="button"
                                                class="btn btn-block btn-danger btn-sm btn-detail-hapus"
                                                nomor="{{$loop->iteration}}">
                                                <span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name='id_detail_dokpersonil' id='id_detail_dokpersonil' value=''>

                    <div class="box-footer" style="text-align:center">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" onclick="goBack()" class="btn btn-md btn-default"><i
                                        class="fa fa-times-circle"></i>
                                    Batal</button>
                            </div>
                        </div>
                    </div>

            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@endsection

<!-- Modal Lampiran -->
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
<!-- End of Modal Lampiran -->

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var home = "{{ url('dokpersonal') }}";
    var instansi = "{{ route('searchInstansiByName') }}";

    $(function () {
        $('.instdok').typeahead({
            source:  function (query, process) {
                return $.get(instansi, { query: query }, function (data) {
                    return process(data);
                });
            },
            displayText: function(item) {
                return item.singkat_bu
            }
        });
        $('.penye').typeahead({
            source:  function (query, process) {
                return $.get(instansi, { query: query }, function (data) {
                    return process(data);
                });
            },
            displayText: function(item) {
                return item.singkat_bu
            }
        });

        // $(document).on('change', '.instdok' , function (e) {
        //     var pilihan = $(this).val();
        //     var inst2 = $(this).attr('idinstan2');
        //     if(pilihan == "lain") {
        //         $("#" + inst2).val("");
        //         $("#" + inst2).removeAttr('readonly');
        //     } else {
        //         $("#" + inst2).val("");
        //         $("#" + inst2).attr('readonly', 'readonly');
        //     }
        // });
        // $(document).on('change', '.penye' , function (e) {
        //     var pilihan = $(this).val();
        //     var penye2 = $(this).attr('idpenye2');
        //     if(pilihan == "lain") {
        //         $("#" + penye2).val("");
        //         $("#" + penye2).removeAttr('readonly');
        //     } else {
        //         $("#" + penye2).val("");
        //         $("#" + penye2).attr('readonly', 'readonly');
        //     }
        // });

        $(document).on('change', '.cstmfile', function (e) {
            // alert($(this).val());
            if ($(this).val() == "") {
                $($(this).attr('idi')).css('color', 'grey');
            } else {
                $($(this).attr('idi')).css('color', '#3c8dbc');
            }
        });

        // Tambah Baris Data Dok Personil
        function add_Row(no) {
            $('#data-dokpersonil > tbody:last').append(`
                <tr class"odd" role="row">
                    <td style="text-align:center;">` + no + `<input type="hidden" value="" name="type_detail_` + no + `"></td>
                    <td>
                        <select required class="form-control select2 bidang_dok" id_srtfalat="id_srtfalat_` + no +
                `" name="id_bidang_` + no + `" id="id_bidang_` + no + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($bidang as $key)
                            <option value="{{ $key->id }}">{{ $key->kode_bidang }} ({{ $key->jenis_usaha->kode_jns_usaha }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 nama_srtf" id_bidang="id_bidang_` + no +
                `" id_jenisdok="id_jenisdok_` + no + `" name="id_srtfalat_` + no + `" id="id_srtfalat_` +
                no + `" style="width: 100%;">
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 jns_dok" id_srtfalat="id_srtfalat_` +
                no + `" id_namadok="id_namadok_` + no +
                `" name="id_jenisdok_` + no + `" id="id_jenisdok_` + no + `" style="width: 100%;">
                        </select>
                    </td>
                    <td><input autocomplete="off" name="id_instansidok_` + no + `" id="id_instansidok_` + no + `" type="text" class="form-control instansi2" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan Nama Instansi')" oninput="setCustomValidity('')"></td>
                    <td><input autocomplete="off" name="id_penyelenggara_` + no + `" id="id_penyelenggara_` + no + `" type="text" class="form-control" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan Nama Penyelenggara')" oninput="setCustomValidity('')"></td>
                    <td><input required name="id_nodokumen_` + no + `" id="id_nodokumen_` + no + `" type="text" class="form-control" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan No Dokumen')" oninput="setCustomValidity('')"></td>
                    <td style="width:10%">
                        <input required autocomplete="off" data-provide="datepicker" data-date-format="dd-mm-yyyy" type="text"
                        class="form-control" id="id_tglterbit_` + no + `" name="id_tglterbit_` + no + `" placeholder="">
                    </td>
                    <td style="width:10%">
                        <input autocomplete="off" data-provide="datepicker" data-date-format="dd-mm-yyyy" type="text"
                            class="form-control" id="id_tglakhir_` + no + `" name="id_tglakhir_` + no + `" placeholder="">
                    </td>
                    <td class="image-upload">
                        <label required for="id_pdfdok_` + no + `">
                                <i id="i_pdfdok_` + no + `" class="fa fa-upload" style="padding-top:8px;padding-left:5px;color:grey" >  Upload</i>
                        </label>
                        <input idi="#i_pdfdok_` + no + `" class="cstmfile" accept=".pdf,.jpeg,.jpg" name="id_pdfdok_` +
                no + `" id="id_pdfdok_` + no + `" type="file"  placeholder="">
                    </td>
                    <td style="padding-top:7px;"">
                        <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" >
                        <span class="fa fa-trash"></span></button>
                    </td>
                </tr>
            `);

            // $('#id_instansidok_' + no).select2();
            // $('#id_penyelenggara_' + no).select2();

            awal = "#id_tglterbit_" + no;
            akhir = "#id_tglakhir_" + no;
            setDateRangePicker(awal, akhir);

            // $(document).on('change', '#id_instansidok_' + no , function (e) {
            //     let pilihan = $(this).val();
            //     console.log(pilihan);
            //     if(pilihan == "lain") {
            //         $("#id_instansidok2_" + no).val("");
            //         $("#id_instansidok2_" + no).prop("disabled", false);
            //         $("#id_instansidok2_" + no).css('background', 'white');
            //     } else {
            //         $("#id_instansidok2_" + no).val("");
            //         $("#id_instansidok2_" + no).prop("disabled", true);
            //     }
            // });
            // $(document).on('change', '#id_penyelenggara_' + no , function (e) {
            //     let pilihan = $(this).val();
            //     console.log(pilihan);
            //     if(pilihan == "lain") {
            //         $("#id_penyelenggara2_" + no).val("");
            //         $("#id_penyelenggara2_" + no).prop("disabled", false);
            //         $("#id_penyelenggara2_" + no).css('background', 'white');
            //     } else {
            //         $("#id_penyelenggara2_" + no).val("");
            //         $("#id_penyelenggara2_" + no).prop("disabled", true);
            //     }
            // });

            var inst_dok = '#id_instansidok_' + no;
            var penye = '#id_penyelenggara_' + no;

            $(inst_dok).typeahead({
                source:  function (query, process) {
                    return $.get(instansi, { query: query }, function (data) {
                        return process(data);
                    });
                },
                displayText: function(item) {
                    return item.singkat_bu
                }
            });
            $(penye).typeahead({
                source:  function (query, process) {
                    return $.get(instansi, { query: query }, function (data) {
                        return process(data);
                    });
                },
                displayText: function(item) {
                    return item.singkat_bu
                }
            });
        }

        // Tambah Baris Data Dok Personil
        var no = 1;
        var id_detail = [];
        var jumlah_detail = "{{ $jumlahdetailAk3 }}";

        for (index = 1; index <= jumlah_detail; index++) {

            awal = "#id_tglterbit_" + no;
            akhir = "#id_tglakhir_" + no;
            setDateRangePicker(awal, akhir);

            id_detail.push(no);
            $('#id_detail_dokpersonil').val(id_detail);

            // Input data ke table temporary
            id_bidang = $("#id_bidang_" + no).val();
            id_srtfalat = $("#id_srtfalat_" + no).val();
            id_jenisdok = $("#id_jenisdok_" + no).val();

            inserttemp(id_bidang, id_srtfalat, id_jenisdok, index);

            no++;
        }

        // Menambah baris dok personil
        $('#addRow').on('click', function () {
            if (id_detail == '') {
                add_Row(no);
                id_detail.push(no);

                $('#id_detail_dokpersonil').val(id_detail);
                $('.select2').select2();

                no++;
            } else {
                var last_element = id_detail[id_detail.length - 1];
                bidang_dok = $("#id_bidang_" + last_element).val();
                nama_srtf = $("#id_srtfalat_" + last_element).val();
                jenis_dok = $("#id_jenisdok_" + last_element).val();
                nama_dok = $("#id_namadok_" + last_element).val();

                if (bidang_dok == null || nama_srtf == null || jenis_dok == null) {
                    Swal.fire({
                        title: "Bidang Dok, Nama Dok, atau Jenis Dok belum diisi !",
                        type: 'error',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#AAA'
                    });
                } else {
                    inserttemp(bidang_dok, nama_srtf, jenis_dok, last_element);

                    add_Row(no);
                    id_detail.push(no);
                    $('#id_detail_dokpersonil').val(id_detail);

                    $('#id_bidang_' + no).select2();
                    $('#id_srtfalat_' + no).select2();
                    $('#id_jenisdok_' + no).select2();
                    $('#id_namadok_' + no).select2();

                    no++;
                }
            }
        });

        // Hapus Baris Data Dok Personil
        $(document).on('click', '.btn-detail-hapus', function (e) {
            nomor = $(this).attr('nomor');
            bidang_dok = $("#id_bidang_" + nomor).val();
            nama_srtf = $("#id_srtfalat_" + nomor).val();
            jenis_dok = $("#id_jenisdok_" + nomor).val();
            nama_dok = $("#id_namadok_" + nomor).val();

            // Hapus data dari table temporary
            hapustemp(bidang_dok, nama_srtf, jenis_dok);

            last_element = id_detail[id_detail.length - 1];
            if (last_element == nomor) {
                console.log('MASUK IF HAPUS');
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_detail_dokpersonil').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                bidang_dok = $("#id_bidang_" + nomor).val();
                nama_srtf = $("#id_srtfalat_" + nomor).val();
                jenis_dok = $("#id_jenisdok_" + nomor).val();
                nama_dok = $("#id_namadok_" + nomor).val();

                hapustemp(bidang_dok, nama_srtf, jenis_dok);

                $("#id_bidang_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#id_bidang_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

                $("#id_srtfalat_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#id_srtfalat_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

                $("#id_jenisdok_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#id_jenisdok_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

                $("#id_namadok_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#id_namadok_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

            } else {
                console.log('MASUK ELSE HAPUS');
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_detail_dokpersonil').val(id_detail);

                bidang_dok = $("#id_bidang_" + nomor).val();
                nama_srtf = $("#id_srtfalat_" + nomor).val();
                jenis_dok = $("#id_jenisdok_" + nomor).val();
                nama_dok = $("#id_namadok_" + nomor).val();

                hapustemp(bidang_dok, nama_srtf, jenis_dok);
            }

            $(this).closest('tr').remove();
        });

        // Filter nama srtf berdasarkan bidang
        $(document).on('change', '.bidang_dok', function (e) {
            id_bidang = $(this).val();
            id_srtfalat = $(this).attr('id_srtfalat');
            $('#' + id_srtfalat).empty();

            bidangchange(id_bidang, id_srtfalat);
        });

        // Filter jenis dok berdasarkan nama srtf
        $(document).on('change', '.nama_srtf', function (e) {
            id_namasrtf = $(this).val();
            id_jenisdok = $(this).attr('id_jenisdok');
            id_bidang = $(this).attr('id_bidang');
            $('#' + id_jenisdok).empty();

            namasrtfchange(id_namasrtf, id_jenisdok, id_bidang);
        });

        // Filter nama dok berdasarkan jns dok
        // $(document).on('change', '.jns_dok', function (e) {
        //     id_jnsdok = $(this).val();
        //     id_namadok = $(this).attr('id_namadok');
        //     id_namasrtf = $(this).attr('id_srtfalat');
        //     $('#' + id_namadok).empty();

        //     jnsdokchange(id_jnsdok, id_namadok, id_namasrtf);
        // });

        // Fungsi ketika memilih bidang dok menampilkan nama srtf yang belum di pilih / belum ada di table temporary
        function bidangchange(id_bidang, id_srtfalat) {
            var url = "{{ url('select_temp_bidang_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_bidang: id_bidang
                },
                success: function (data) {

                    $("#" + id_srtfalat).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi ketika memilih nama srtf menampilkan jenis dok
        function namasrtfchange(id_namasrtf, id_jenisdok, id_bidang) {
            bidang = $("#" + id_bidang).val();
            var url = "{{ url('select_temp_namasrtf_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_namasrtf: id_namasrtf,
                    id_bidang: bidang
                },
                success: function (data) {
                    $("#" + id_jenisdok).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi ketika memilih jenis dok menampilkan nama dok
        // function jnsdokchange(id_jnsdok, id_namadok, id_namasrtf) {
        //     nama_srtf = $("#" + id_namasrtf).val();
        //     var url = "{{ url('select_temp_jnsdok_skp_ak3') }}";
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: url,
        //         method: 'POST',
        //         data: {
        //             id_jnsdok: id_jnsdok,
        //             id_namasrtf: nama_srtf
        //         },
        //         success: function (data) {
        //             $("#" + id_namadok).select2({
        //                 data: data
        //             }).val(null).trigger('refresh');
        //         },
        //         error: function (xhr, status) {
        //             alert('Error');
        //         }
        //     });
        // }

        // Function insert data ke table temporary
        function inserttemp(id_bidang, id_srtfalat, id_jenisdok, last_element) {
            var url = "{{ url('add_temp_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    bidang_dok: id_bidang,
                    nama_srtf: id_srtfalat,
                    jenis_dok: id_jenisdok
                },
                success: function (data) {
                    if (last_element == "none") {

                    } else {
                        $("#id_bidang_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#id_srtfalat_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#id_jenisdok_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#id_namadok_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');

                        $("#id_bidang_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                        $("#id_srtfalat_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                        $("#id_jenisdok_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                        $("#id_namadok_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi hapus data di table temporary
        function hapustemp(bidang_dok, nama_srtf, jenis_dok) {
            var url = "{{ url('delete_temp_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    bidang_dok: bidang_dok,
                    nama_srtf: nama_srtf,
                    jenis_dok: jenis_dok
                },
                success: function (data) {
                    console.log('Sukses Hapus Data Temp');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi hapus semua data di table temporary
        function hapusalltemp() {
            var url = "{{ url('delete_all_temp_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                success: function (data) {
                    console.log('Sukses Hapus Semua Data Temp');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

    });

    // fungsi hanya input angka
    // function isNumberKey(evt) {
    //     var charCode = (evt.which) ? evt.which : event.keyCode
    //     if (charCode > 31 && (charCode < 48 || charCode > 57))
    //         return false;
    //     return true;
    // }

    function tanggal(e) {
        if (!/^[0-9/]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush
