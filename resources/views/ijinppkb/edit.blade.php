@extends('templates.header')

@section('content')
<style>
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
        Ubah Ijin PJS_PKB Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Daftar PJS_PKB</a></li>
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

            <form action="{{ route('ijinppkb.update', $data->id ) }}" class="form-horizontal" id="formAdd"
                name="formAdd" method="post" enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama PJS_PKB
                                </div>
                                <select disabled class="form-control select2" name="id_kode_pjk3_tmp"
                                    id="id_kode_pjk3_tmp" style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($badanusaha as $key)
                                    <option value="{{ $key->id }}" {{ $key->id == $data->kode_pjk3 ? 'selected' : '' }}>
                                        {{ $key->nama_bu }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="{{$data->kode_pjk3}}" name="id_kode_pjk3" id="id_kode_pjk3">
                            <span id="id_kode_pjk3" class="help-block customspan">{{ $errors->first('id_kode_pjk3') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Provinsi Naker
                                </div>
                                <input name="id_prov_naker" id="id_prov_naker" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->provinsi->nama}}"
                                    disabled>
                            </div>
                            <span id="id_prov_naker" class="help-block customspan">{{ $errors->first('id_prov_naker') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Alamat
                                </div>
                                <input name="id_alamat_bu" id="id_alamat_bu" class="form-control"
                                    placeholder=""
                                    value="{{$data->badan_usaha->alamat}}" disabled>
                            </div>
                            <span id="id_alamat_bu" class="help-block customspan">{{ $errors->first('id_alamat_bu') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Provinsi BU
                                </div>
                                <input name="id_prov_bu" id="id_prov_bu" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->provinsibu->nama}}" disabled>
                            </div>
                            <span id="id_prov_bu" class="help-block customspan">{{ $errors->first('id_prov_bu') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Kota BU
                                </div>
                                <input name="id_kota_bu" id="id_kota_bu" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->kota->nama}}" disabled>
                            </div>
                            <span id="id_kota_bu" class="help-block customspan">{{ $errors->first('id_kota_bu') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Tlp
                                </div>
                                <input name="id_no_telp" id="id_no_telp" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->telp}}" disabled>
                            </div>
                            <span id="id_no_telp" class="help-block customspan">{{ $errors->first('id_no_telp') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email
                                </div>
                                <input name="id_email" id="id_email" type="email" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->email}}" disabled>
                            </div>
                            <span id="id_email" class="help-block customspan">{{ $errors->first('id_email') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Instansi Reff
                                </div>
                                <input name="id_instansi" id="id_instansi" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->instansi_reff}}" disabled>
                            </div>
                            <span id="id_instansi" class="help-block customspan">{{ $errors->first('id_instansi') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Web
                                </div>
                                <input name="id_web" id="id_web" type="text" class="form-control" placeholder=""
                                    value="{{$data->badan_usaha->web}}" disabled>
                            </div>
                            <span id="id_web" class="help-block customspan">{{ $errors->first('id_web') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Pimpinan
                                </div>
                                <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                    autocomplete="off" placeholder="" value="{{$data->nama_pimp}}">
                                <!-- <select class="form-control select2" name="id_nama_p" id="id_nama_p"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($personil as $key)
                                    <option id-personil="{{ $key->id }}" value="{{ $key->nama }}">
                                        {{ $key->nama }}
                                    </option>
                                    @endforeach
                                    <option id-personil="lain" value="lain">Lainnya</option>
                                </select> -->
                            </div>
                            <span id="id_nama_p" class="help-block customspan">{{ $errors->first('id_nama_p') }} </span>
                        </div>

                        <!-- <div class="col-sm-2">
                            <input id="nama_p_lain" name="nama_p_lain" type="text" class="form-control"
                                readonly="readonly" style="background:silver">
                        </div> -->

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Pimpinan
                                </div>
                                <input name="id_jab_p" id="id_jab_p" type="text" class="form-control"
                                    placeholder="" value="{{$data->jab_pimp}}">
                            </div>
                            <span id="id_jab_p" class="help-block customspan">{{ $errors->first('id_jab_p') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Hp Pimpinan
                                </div>
                                <input name="id_hp_p" id="id_hp_p" type="text" class="form-control"
                                    placeholder="" value="{{$data->no_pimp}}">
                            </div>
                            <span id="id_hp_p" class="help-block customspan">{{ $errors->first('id_hp_p') }} </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email Pimpinan
                                </div>
                                <input name="id_email_p" id="id_email_p" type="email" class="form-control"
                                    placeholder="" value="{{$data->email_pimp}}">
                            </div>
                            <span id="id_email_p" class="help-block customspan">{{ $errors->first('id_email_p') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Kontak Person
                                </div>
                                <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    autocomplete="off" placeholder="" value="{{$data->nama_kp}}">
                                <!-- <select class="form-control select2" name="id_nama_kp" id="id_nama_kp"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($personil as $key)
                                    <option id-personil="{{ $key->id }}" value="{{ $key->nama }}">
                                        {{ $key->nama }}
                                    </option>
                                    @endforeach
                                    <option id-personil="lain" value="lain">Lainnya</option>
                                </select> -->
                                <!-- <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->kontak_p}}" disabled> -->
                            </div>
                            <span id="id_nama_kp" class="help-block customspan">{{ $errors->first('id_nama_kp') }}
                            </span>
                        </div>

                        <!-- <div class="col-sm-2">
                            <input id="nama_kp_lain" name="nama_kp_lain" type="text" class="form-control"
                                readonly="readonly" style="background:silver">
                        </div> -->

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Kontak Person
                                </div>
                                <input name="id_jab_kp" id="id_jab_kp" type="text" class="form-control"
                                    placeholder="" value="{{$data->jab_kp}}">
                            </div>
                            <span id="id_jab_kp" class="help-block customspan">{{ $errors->first('id_jab_kp') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No HP Kontak Person
                                </div>
                                <input name="id_hp_kp" id="id_hp_kp" type="text" class="form-control"
                                    placeholder="" value="{{$data->no_kp}}">
                            </div>
                            <span id="id_hp_kp" class="help-block customspan">{{ $errors->first('id_hp_kp') }} </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email Kontak Person
                                </div>
                                <input name="id_email_kp" id="id_email_kp" type="email" class="form-control"
                                    placeholder="" value="{{$data->email_kp}}">
                            </div>
                            <span id="id_email_kp" class="help-block customspan">{{ $errors->first('id_email_kp') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No NPWP
                                </div>
                                <input type="text" id="id_npwp" name="id_npwp" class="form-control"
                                    placeholder="" value="{{$data->badan_usaha->npwp}}" disabled>
                            </div>
                            <span id="id_npwp" class="help-block customspan">{{ $errors->first('id_npwp') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Rekening Bank
                                </div>
                                <input name="id_norek_bank" id="id_norek_bank" type="text" class="form-control"
                                    placeholder="" value="{{ $data->no_rek }}">
                            </div>
                            <span id="id_norek_bank" class="help-block customspan">{{ $errors->first('id_norek_bank') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Rekening Bank
                                </div>
                                <input name="id_namarek_bank" id="id_namarek_bank" type="text" class="form-control"
                                    placeholder="" value="{{$data->nama_rek}}">
                            </div>
                            <span id="id_namarek_bank"
                                class="help-block customspan">{{ $errors->first('id_namarek_bank') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Bank
                                </div>
                                <select class="form-control select2" name="id_nama_bank" id="id_nama_bank"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($bank as $key)
                                    <option value="{{ $key->id_bank }}"
                                        {{$data->id_bank == $key->id_bank ? 'selected' : '' }}>
                                        {{ $key->Nama_Bank }}
                                    </option>
                                    @endforeach
                                </select>

                                <!-- <input name="id_nama_bank" id="id_nama_bank" type="text" class="form-control"
                                    placeholder=""
                                    value="{{ isset($data->badan_usaha->bank->Nama_Bank) ? $data->badan_usaha->bank->Nama_Bank : '' }}"
                                    disabled> -->
                            </div>
                            <span id="id_nama_bank" class="help-block customspan">{{ $errors->first('id_nama_bank') }}
                            </span>
                        </div>
                    </div>

                    <div class="row" style="text-align:right">
                        <div class="col-sm-12">
                            <span class="bintang"><b>*</b></span> Wajib Diisi
                        </div>
                    </div>

                    <br>

                    <div class="input-group">
                        <h4><b>Data Ijin</b></h4>
                        <span class="input-group-btn">
                            <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span>
                                Tambah
                                Baris</button>
                        </span>
                    </div>
                </div>

                <!-- Detail -->



                <!-- <div class="btn-group btn-lg" style="margin-left: 10px;">
                    <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span> Tambah
                        SKP</button>
                </div> -->

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="kontak-Detail" class="table table-bordered table-Detail">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Jenis Usaha</th>
                                <th>Jenis_Kgt</th>
                                <th>No Ijin</th>
                                <th>Tgl_Terbit Ijin</th>
                                <th>Tgl_Akhir Ijin</th>
                                <th>Pdf_Ijin</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailskp as $key)
                            <tr>
                                <input type="hidden" name='type_detail_{{$loop->iteration}}'
                                    id='type_detail_{{$loop->iteration}}' value='{{$key->id}}'>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <select class="form-control select2 jns_usaha"
                                        name="jns_usaha_detail_{{$loop->iteration}}"
                                        id="jns_usaha_detail_{{$loop->iteration}}" style="width: 100%;"
                                        idbidang="bidang_detail_{{$loop->iteration}}" required>
                                        <option value="{{$key->bidang->jenis_usaha->id}}">
                                            {{$key->bidang->jenis_usaha->kode_jns_usaha}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="bidang_detail_{{$loop->iteration}}"
                                        id="bidang_detail_{{$loop->iteration}}" style="width: 100%;" required>
                                        <option value="{{$key->bidang->id}}">{{$key->bidang->nama_bidang}}</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder=""
                                        name="no_skp_{{$loop->iteration}}" id="no_skp_{{$loop->iteration}}"
                                        value="{{$key->no_sk}}"></td>
                                <td style="width:10%"> <input autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="" name="tgl_terbit_{{$loop->iteration}}"
                                        id="tgl_terbit_{{$loop->iteration}}"
                                        value="@if($key->tgl_sk=='')  @else {{date('d/m/Y', strtotime($key->tgl_sk))}} @endif">
                                </td>
                                <td style="width:10%"> <input autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="" name="tgl_akhir_{{$loop->iteration}}"
                                        id="tgl_akhir_{{$loop->iteration}}"
                                        value="@if($key->tgl_akhir_sk=='')  @else {{date('d/m/Y', strtotime($key->tgl_akhir_sk))}} @endif">
                                </td>
                                <td style="width:15%">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="file" style="padding: 3px 3px;" class="form-control cstmfile"
                                                placeholder="" name="pdf_skp_{{$loop->iteration}}"
                                                id="pdf_skp_{{$loop->iteration}}">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"
                                            style="padding-left:0px;padding-top: 0px;margin-top: 1px;">
                                            @if($key->pdf_skp_pjk3!="")
                                            <button type="button"
                                                onclick='tampilLampiran("/uploads/{{$key->pdf_skp_pjk3}}","SKP")'
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-file-pdf-o"></i></button>
                                            @endif</label>
                                    </div>
                                </td>
                                <td style="width:5%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-detail-hapus"
                                        nomor="{{$loop->iteration}}" onclick=""><span
                                            class="fa fa-trash"></span></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- /.box-body -->
                <input type="hidden" name='id_jumlah_detail' id='id_jumlah_detail' value=''>

                <!-- End Detail -->
                <br>
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
                <br>
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

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

</section>
<!-- /.content -->

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    // $('.select2').val(null).trigger('change');
    var home = "{{ route('ijinppkb.index') }}";

    $(function () {

        // untuk dropdown cari berdasarkan nama
        sugestPersonil('id_nama_p', 'id_hp_p','id_email_p',"{{ route('searchPersonilByName') }}"); // Jika tidak autocomplete ke hp atau email parameter ny di kosongkan
        sugestPersonil('id_nama_kp', 'id_hp_kp','id_email_kp',"{{ route('searchPersonilByName') }}");

        // Kunci Input fILE Hanya PDF
        $(document).on('change', '.cstmfile', function (e) {
            if ($(this).val() == "") {
                $($(this).attr('idi')).css('color', 'grey');
            } else {
                $($(this).attr('idi')).css('color', '#3c8dbc');
                var id = $(this).val();
                var ext = id.substr(id.lastIndexOf('.') + 1);
                ext = ext.toLowerCase();
                switch (ext) {
                    case 'pdf':
                        break;
                    default:
                        this.value = '';
                        $($(this).attr('idi')).css('color', 'grey');
                        Swal.fire({
                            title: "Extension file tidak sesuai!",
                            type: 'warning',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#AAA'
                        });
                }


            }
        });

        // Fungsi Tambah Baris Detail
        function add_row(no) {
            $('#kontak-Detail > tbody:last').append(`
            <tr>
            <input type="hidden" name="type_detail_` + no + `" id="type_detail_` + no + `" value="">
                                <td>` + no + `</td>
                                <td>
                                    <select class="form-control select2 jns_usaha" name="jns_usaha_detail_` + no + `"
                                        id="jns_usaha_detail_` + no +
                `" style="width: 100%;" idbidang="bidang_detail_` + no + `" required>
                                        <option value="" disabled selected></option>
                                        @foreach($jenisusaha as $key)
                                        <option value="{{ $key->id }}">
                                            {{ $key->kode_jns_usaha }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="bidang_detail_` + no +
                `" id="bidang_detail_` + no + `" style="width: 100%;" required>
                                        <option value="" disabled selected></option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="" name="no_skp_` + no +
                `" id="no_skp_` + no + `"></td>
                                <td style="width:10%"> <input required autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="" name="tgl_terbit_` + no + `" id="tgl_terbit_` +
                no + `"></td>
                                <td style="width:10%"> <input required autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="" name="tgl_akhir_` + no + `" id="tgl_akhir_` + no + `"></td>
                                <td style="width:15%"><input style="padding: 3px 3px;" required type="file" class="form-control cstmfile" placeholder=""
                                        name="pdf_skp_` + no + `" id="pdf_skp_` + no + `"></td>
                                <td style="width:5%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" onclick=""><span class="fa fa-trash"></span></button></td>
                            </tr>
            `);

            awal = "#tgl_terbit_" + no;
            akhir = "#tgl_akhir_" + no;
            setDateRangePicker(awal, akhir);
        }

        // Button Tambah Baris Detail
        var no = 1;
        var id_detail = [];
        var jumlah_detail = "{{$jumlahdetail}}";

        for (index = 1; index <= jumlah_detail; index++) {
            id_detail.push(no);
            $('#id_jumlah_detail').val(id_detail);

            // Input data ke table temporary
            id_jenis_usaha = $("#jns_usaha_detail_" + no).val();
            id_bidang = $("#bidang_detail_" + no).val();

            inserttemp(id_jenis_usaha, id_bidang, index);

            awal = "#tgl_terbit_" + no;
            akhir = "#tgl_akhir_" + no;
            setDateRangePicker(awal, akhir);

            no++;
        }

        // $("#id_nama_p").on('select2:select', function (e) {
        //     id_personil = $('option:selected', this).attr('id-personil');
        //     id_nama = "id_nama_p";
        //     id_jab = "id_jab_p";
        //     id_hp = "id_hp_p";
        //     id_email = "id_email_p";
        //     var url = "{{ url('chain/personil') }}";

        //     if (id_personil == "lain") {
        //         $("#id_hp_p").val("");
        //         $("#id_jab_p").val("");
        //         $("#id_email_p").val("");
        //         $("#nama_p_lain").removeAttr('readonly');
        //         $("#nama_p_lain").css('background', 'white');
        //     } else {
        //         changepersonil(id_personil, id_nama, id_jab, id_hp, id_email, url);
        //         $("#nama_p_lain").attr('readonly', 'readonly');
        //         $("#nama_p_lain").css('background', 'silver');
        //         $("#nama_p_lain").val('');
        //     }
        // });

        // $("#id_nama_kp").on('select2:select', function (e) {
        //     id_personil = $('option:selected', this).attr('id-personil');
        //     id_nama = "id_nama_kp";
        //     id_jab = "id_jab_kp";
        //     id_hp = "id_hp_kp";
        //     id_email = "id_email_kp";
        //     var url = "{{ url('chain/personil') }}";
        //     if (id_personil == "lain") {
        //         $("#id_hp_kp").val("");
        //         $("#id_jab_kp").val("");
        //         $("#id_email_kp").val("");
        //         $("#nama_kp_lain").removeAttr('readonly');
        //         $("#nama_kp_lain").css('background', 'white');
        //     } else {
        //         changepersonil(id_personil, id_nama, id_jab, id_hp, id_email, url);
        //         $("#nama_kp_lain").attr('readonly', 'readonly');
        //         $("#nama_kp_lain").css('background', 'silver');
        //         $("#nama_kp_lain").val('');
        //     }
        // });

        // Menambah baris detail
        $('#addrow').on('click', function () {
            if (id_detail == '') {
                add_row(no);
                id_detail.push(no);
                $('#id_jumlah_detail').val(id_detail);
                $('.select2').select2();
                no++;
            } else {
                var last_element = id_detail[id_detail.length - 1];
                id_jenis_usaha = $("#jns_usaha_detail_" + last_element).val();
                id_bidang = $("#bidang_detail_" + last_element).val();
                if (id_jenis_usaha == null || id_bidang == null) {
                    Swal.fire({
                        title: "Jenis Usaha atau Bidang SKP belum diisi !",
                        type: 'error',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#AAA'
                    });
                    // alert('Jenis Usaha atau Bidang SKP belum diisi')
                } else {
                    // Insert data ke table temporary
                    inserttemp(id_jenis_usaha, id_bidang, last_element);

                    // Menambahkan data detail di tampilan web
                    add_row(no);
                    id_detail.push(no);
                    $('#id_jumlah_detail').val(id_detail);

                    // Menjalankan Select2 pada baris baru
                    $('#jns_usaha_detail_' + no).select2();
                    $('#bidang_detail_' + no).select2();

                    // $('.select2').select2();
                    no++;
                }
            }
        });

        // Button Hapus Baris Detail
        $(document).on('click', '.btn-detail-hapus', function (e) {
            nomor = $(this).attr('nomor');
            id_jenis_usaha = $("#jns_usaha_detail_" + nomor).val();
            id_bidang = $("#bidang_detail_" + nomor).val();


            // Hapus data dari table temporary
            hapustemp(id_jenis_usaha, id_bidang);

            last_element = id_detail[id_detail.length - 1];
            if (last_element == nomor) {
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_jumlah_detail').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                id_jenis_usaha = $("#jns_usaha_detail_" + last_element).val();
                id_bidang = $("#bidang_detail_" + last_element).val();
                hapustemp(id_jenis_usaha, id_bidang);

                $("#jns_usaha_detail_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#jns_usaha_detail_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

                $("#bidang_detail_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#bidang_detail_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

            } else {
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_jumlah_detail').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                id_jenis_usaha = $("#jns_usaha_detail_" + last_element).val();
                idbidang = "bidang_detail_" + last_element;
                jenisusahachange(id_jenis_usaha, idbidang);
            }

            $(this).closest('tr').remove();
        });

        // Filter bidang berdasarkan jenis usaha
        $(document).on('change', '.jns_usaha', function (e) {
            id_jenis_usaha = $(this).val();
            idbidang = $(this).attr('idbidang');
            $('#' + idbidang).empty();
            // Select bidang yang belum dipilih / belum ada di table temporary
            jenisusahachange(id_jenis_usaha, idbidang);
        });

        // Function insert data ke table temporary
        function inserttemp(id_jenis_usaha, id_bidang, last_element) {
            var url = "{{ url('add_temp_skp_pjk3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jenis_usaha: id_jenis_usaha,
                    id_bidang: id_bidang
                },
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image: "",
                        fontawesome: "fa fa-refresh fa-spin",
                        fontawesomeColor: "black",
                        fade: [5, 5],
                        background: "rgba(60, 60, 60, 0.4)"
                    });
                    // $("#btnSave").button('loading');
                },
                success: function (data) {
                    if (last_element == "none") {

                    } else {
                        $("#jns_usaha_detail_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#bidang_detail_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');

                        $("#jns_usaha_detail_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                        $("#bidang_detail_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');
                        // id_bidang = $("#bidang_detail_" + last_element).val();
                        // nama_bidang = $("#bidang_detail_" + last_element + " option:selected")
                        //     .text();
                        // var databidang = {
                        //     id: id_bidang,
                        //     text: nama_bidang
                        // };
                        // $("#bidang_detail_" + last_element).empty();
                        // var newOption = new Option(databidang.text, databidang.id, false, false);
                        // $("#bidang_detail_" + last_element).append(newOption).trigger('change');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                    // $("#btnSave").button('reset');
                }
            });
        }

        // Fungsi ketika memilih jenis usaha menampilkan bidang yang belum di pilih / belum ada di table temporary
        function jenisusahachange(id_jenis_usaha, idbidang) {
            var url = "{{ url('select_temp_skp_pjk3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jenis_usaha: id_jenis_usaha
                },
                success: function (data) {
                    $("#" + idbidang).html(
                        "<option value='' selected disabled></option>");
                    $("#" + idbidang).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi hapus data di table temporary
        function hapustemp(id_jenis_usaha, id_bidang) {
            var url = "{{ url('delete_temp_skp_pjk3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jenis_usaha: id_jenis_usaha,
                    id_bidang: id_bidang
                },
                success: function (data) {
                    console.log('Sukses');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }



    });

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
