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
        Tambah Dokumen Personil PJS_PPKB Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="/dokpersonil">Dok Personil</a></li>
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

            <form action="{{ url('dokpersonal/store') }}" class="form-horizontal" id="formAdd" name="formAdd"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group {{ $errors->first('id_nama_pjk3') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama PJK3
                                </div>
                                <select class="form-control select2" name="id_nama_pjk3" id="id_nama_pjk3"
                                    style="width: 100%;" placeholder="*Nama PJK3">
                                    <option value="" disabled selected>*Nama PJK3</option>
                                    @foreach($instansi as $key)
                                    <option value="{{ $key->id }}" {{ $key->id == old('id_nama_pjk3') ? 'selected' : '' }}>
                                        {{ $key->nama_bu }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="id_nama_pjk3"
                                class="help-block customspan">{{ $errors->first('id_nama_pjk3') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group {{ $errors->first('id_personal') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Personil
                                </div>
                                <select class="form-control select2" name="id_personal" id="id_personal"
                                    style="width: 100%;" placeholder="*Nama Personil">
                                    <option value="" disabled selected>*Nama Personil</option>
                                    @foreach($personil as $key)
                                    <option value="{{ $key->id }}" {{ $key->id == old('id_personal') ? 'selected' : '' }}>
                                        {{ $key->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
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
                                    placeholder="Refferensi" value="{{old('id_reff')}}" disabled>
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
                                <input class="form-control" name="id_status" id="id_status" placeholder="Status"
                                    value="{{old('id_status')}}" disabled>
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
                                <input class="form-control" name="id_jenkel" id="id_jenkel" placeholder="Jenis Kelamin"
                                    value="{{old('id_jenkel')}}" disabled>
                            </div>
                            <span id="id_jenkel" class="help-block customspan">{{ $errors->first('id_jenkel') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <a name="btnFotoPdf" type="button" id="btnFotoPdf" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File Foto</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    NIK
                                </div>
                                <input name="nik" id="nik" type="text" class="form-control" placeholder="NIK"
                                    value="{{old('nik')}}" disabled>
                            </div>
                            <span id="nik" class="help-block customspan">{{ $errors->first('nik') }} </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <a name="btnKtpPdf" type="button" id="btnKtpPdf" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File KTP</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Alamat (KTP)
                                </div>
                                <input name="id_ktp_alamat" id="id_ktp_alamat" type="text" class="form-control"
                                    placeholder="Alamat Jalan, Kelurahan, Kecamatan (KTP)" value="{{old('id_ktp_alamat')}}" disabled>
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
                                <input class="form-control" name="id_ktp_prov" id="id_ktp_prov" placeholder="Prov Alamat (KTP)"
                                    value="{{old('id_ktp_prov')}}" disabled>
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
                                <input class="form-control" name="id_ktp_kota" id="id_ktp_kota" placeholder="Kota Alamat (KTP)"
                                    value="{{old('id_ktp_kota')}}" disabled>
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
                                    placeholder="Alamat Jalan, Kelurahan, Kecamatan (Domisili)" value="{{old('id_alamat')}}" disabled>
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
                                <input class="form-control" name="id_prov" id="id_prov" placeholder="Prov Alamat (Domisili)"
                                    value="{{old('id_prov')}}" disabled>
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
                                <input class="form-control" name="id_kota" id="id_kota" placeholder="Kota Alamat (Domisili)"
                                    value="{{old('id_kota')}}" disabled>
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
                                    placeholder="No HP" value="{{old('id_no_telp')}}" disabled>
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
                                <input name="id_email" id="id_email" type="email" class="form-control" placeholder="Email"
                                    value="{{old('id_email')}}" disabled>
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
                                    placeholder="Tempat Lahir" value="{{old('id_temp_lahir')}}" disabled>
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
                                    placeholder="Tanggal Lahir" value="{{old('id_tgl_lahir')}}" disabled>
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
                                <input class="form-control" name="agama" id="agama"
                                    placeholder="Agama" value="{{old('agama')}}" disabled>
                            </div>
                            <span id="agama"
                                class="help-block customspan">{{ $errors->first('agama') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Status Pajak
                                </div>
                                <input class="form-control" id="status_pajak" name="status_pajak"
                                    placeholder="Status Pajak" value="{{old('status_pajak')}}" disabled>
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
                                <input class="form-control" name="status_perni" id="status_perni"
                                    placeholder="Status Pernikahan" value="{{old('status_perni')}}" disabled>
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
                                <input class="form-control" name="bpjs_no" id="bpjs_no"
                                    placeholder="No BPJS Kesehatan" value="{{old('bpjs_no')}}" disabled>
                            </div>
                            <span id="bpjs_no"
                                class="help-block customspan">{{ $errors->first('bpjs_no') }}</span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <a name="btnBpjsPdf" type="button" id="btnBpjsPdf" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File BPJS</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    NPWP
                                </div>
                                <input id="npwp" name="npwp" class="form-control" placeholder="NPWP"
                                    value="{{old('npwp')}}" disabled>
                            </div>
                            <span id="npwp" class="help-block customspan">{{ $errors->first('npwp') }} </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <a name="btnNpwpPdf" type="button" id="btnNpwpPdf" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> File NPWP</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Rekening Bank
                                </div>
                                <input name="id_norek_bank" id="id_norek_bank" type="text" class="form-control"
                                    placeholder="No Rekening Bank" value="{{old('id_norek_bank')}}" disabled>
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
                                    placeholder="Nama Rekening Bank" value="{{old('id_namarek_bank')}}" disabled>
                            </div>
                            <span id="id_namarek_bank"
                                class="help-block customspan">{{ $errors->first('id_namarek_bank') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Bank
                                </div>
                                <input class="form-control" name="id_nama_bank" id="id_nama_bank" placeholder="Nama Bank"
                                    value="{{old('id_nama_bank')}}" disabled>
                            </div>
                            <span id="id_nama_bank"
                                class="help-block customspan">{{ $errors->first('id_nama_bank') }}</span>
                        </div>
                    </div>

                    <div class="row" style="text-align:right">
                        <div class="col-sm-12">
                            <span class="bintang"><b>*</b></span> Wajib Diisi
                        </div>
                    </div>

                    <b>Data Sekolah</b>

                    <table id="data-sekolah"
                        class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                        <thead>
                            <tr role="row">
                                <th style="width:3%;">No</th>
                                <th style="width:6%;">Jenjang_Pddk</th>
                                <th style="width:18%;">Nama_Sklh</th>
                                <th style="width:7%;">Negara_Sklh</th>
                                <th style="width:10%;">Prov_Sklh</th>
                                <th style="width:11%;">Kota_Sklh</th>
                                <th style="width:10%;">Prodi</th>
                                <th style="width:6%;">Tahun_Tamat</th>
                                <th style="width:11%;">No_Ijasah</th>
                                <th style="width:7%;">Tgl_Ijasah</th>
                                <th style="width:5%;">Default</th>
                                <th style="width:5%;">Pdf_Ijs</th>
                                {{-- <th style="border-right:0px !important;border-bottom:0px !important;border-top:0px !important;background-color:white;"></th>
                                <td style="border-right:0px !important;border-bottom:0px !important;"></td> --}}
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <br>
                    <button id="addRow" type="button" class="btn btn-success pull-right"><i
                            class="fa fa-plus-circle"></i> Tambah Dok</button>
                    <br>

                    <b>Data Dokumen Personil</b>

                    <table id="data-dokpersonil"
                        class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                        <thead>
                            <tr role="row">
                                <th>No</th>
                                <th>Bidang_Dok</th>
                                <th>Nama_Dok</th>
                                <th>Jenis_Dok</th>
                                <th >Instansi_Dok</th>
                                <th >Penyelenggara</th>
                                <th>No_Dok</th>
                                <th>Tgl_Terbit</th>
                                <th>Tgl_Akhir</th>
                                <th>Pdf_Dok</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

                <input type="hidden" name='id_detail_dokpersonil' id='id_detail_dokpersonil' value=''>

                {{-- <div class="box-footer">
                    <a href="{{ url('dokpersonil') }}" class="btn btn-md btn-default pull-left"><i
                            class="fa fa-times-circle"></i> Batal</a>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>
                </div> --}}

                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url('dokpersonil') }}" class="btn btn-md btn-default"><i
                                    class="fa fa-times-circle"></i>
                                Batal</a>
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

{{-- <td style="border-right:0px !important;">
    <select required class="form-control select2 instansi" name="id_instansidok_` + urutan + `" id="id_instansidok_` + urutan + `" style="width: 100%;">
        <option value="" disabled selected>Pilih Instansi</option>
        @foreach($instansi as $key)
        <option value="{{ $key->singkat_bu }}">{{ $key->singkat_bu }}</option>
        @endforeach
        <option value="lain">LAINNYA</option>
    </select>
</td>
<td style="border-left:0px !important;"><input disabled name="id_instansidok2_` + urutan + `" id="id_instansidok2_` + urutan + `" type="text" class="form-control" placeholder=""
    oninvalid="this.setCustomValidity('Masukkan Nama Instansi')" oninput="setCustomValidity('')"></td>
<td style="border-right:0px !important;">
    <select required class="form-control select2 penyelenggara" name="id_penyelenggara_` + urutan + `" id="id_penyelenggara_` + urutan + `" style="width: 100%;">
        <option value="" disabled selected>Pilih Penyelenggara</option>
        @foreach($instansi as $key)
        <option value="{{ $key->singkat_bu }}">{{ $key->singkat_bu }}</option>
        @endforeach
        <option value="lain">LAINNYA</option>
    </select>
</td>
<td style="border-left:0px !important;"><input disabled name="id_penyelenggara2_` + urutan + `" id="id_penyelenggara2_` + urutan + `" type="text" class="form-control" placeholder=""
    oninvalid="this.setCustomValidity('Masukkan Nama Penyelenggara')" oninput="setCustomValidity('')"></td> --}}

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var home = "{{ url('personals') }}";
    var img = "{{ url('logo_p3sm.png') }}";

    $(function () {
        $('#btnFotoPdf').hide();
        $('#btnKtpPdf').hide();
        $('#btnNpwpPdf').hide();
        $('#btnBpjsPdf').hide();
        $('#addRow').hide();

        $(document).on('change', '.cstmfile', function (e) {
            if ($(this).val() == "") {
                $($(this).attr('idi')).css('color', 'grey');
            } else {
                $($(this).attr('idi')).css('color', '#3c8dbc');
            }
        });

        $(document).on('change', '#id_nama_pjk3', function (e) {
            $("#id_personal").select2({
                // placeholder: "*Nama Personil",
                // allowClear: true
            }).val('').trigger('change.select2');
        });

        //Pilih Nama Personil on Change
        $(document).on('select2:select', '#id_personal', function (e) {
            pjk3 = $('#id_nama_pjk3').val();
            $('#addRow').show();
            var id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('dokpersonal/get_personal') }}/" + pjk3 + "/" + id,
                type: "POST",
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image: "",
                        fontawesome: "fa fa-refresh fa-spin",
                        fontawesomeColor: "black",
                        fade: [5, 5],
                        background: "rgba(60, 60, 60, 0.4)"
                    });
                },
                success: function (response) {
                    console.log(response);
                    // Memberi value personil
                    var bpjs_pdf = response['dataPersonil']['lampiran_bpjs'];
                    var foto_pdf = response['dataPersonil']['lampiran_foto'];
                    var ktp_pdf = response['dataPersonil']['lampiran_ktp'];
                    var npwp_pdf = response['dataPersonil']['lampiran_npwp'];
                    if (foto_pdf == '' || foto_pdf == null) {
                        $('#btnFotoPdf').hide();
                    } else {
                        $('#btnFotoPdf').show();
                        $('#btnFotoPdf').attr('href', "{{ url('/') }}" + '/' + foto_pdf);
                        $('#btnFotoPdf').attr('target', '_blank');
                    }
                    if (ktp_pdf == '' || ktp_pdf == null) {
                        $('#btnKtpPdf').hide();
                    } else {
                        $('#btnKtpPdf').show();
                        $('#btnKtpPdf').attr('href', "{{ url('/') }}" + '/' + ktp_pdf);
                        $('#btnKtpPdf').attr('target', '_blank');
                    }
                    if (npwp_pdf == '' || npwp_pdf == null) {
                        $('#btnNpwpPdf').hide();
                    } else {
                        $('#btnNpwpPdf').show();
                        $('#btnNpwpPdf').attr('href', "{{ url('/') }}" + '/' + npwp_pdf);
                        $('#btnNpwpPdf').attr('target', '_blank');
                    }
                    if (bpjs_pdf == '' || bpjs_pdf == null) {
                        $('#btnBpjsPdf').hide();
                    } else {
                        $('#btnBpjsPdf').show();
                        $('#btnBpjsPdf').attr('href', "{{ url('/') }}" + '/' + bpjs_pdf);
                        $('#btnBpjsPdf').attr('target', '_blank');
                    }
                    if (response['dataPersonil']['status_p'] == '1') {
                        var status = 'Internal';
                    } else {
                        status = 'External';
                    }
                    if (response['dataPersonil']['jenis_kelamin'] == 'L') {
                        var jenkel = 'Laki-laki';
                    } else {
                        var jenkel = 'Perempuan';
                    }
                    var tgl_lahir = tanggal_indonesia((response['dataPersonil'][
                        'tgl_lahir'
                    ]));
                    $('#id_reff').val(response['dataPersonil']['reff_p']);
                    $('#id_status').val(status);
                    $('#id_jenkel').val(jenkel);
                    $('#nik').val(response['dataPersonil']['nik']);
                    $('#id_ktp_alamat').val(response['dataPersonil']['alamat_ktp']);
                    if(response['dataPersonil']['kota_id_ktp']==null){
                        $('#id_ktp_prov').val(response['dataPersonil']['kota_id_ktp']);
                    }else{
                        $('#id_ktp_prov').val(response['dataPersonil']['kota_ktp']['provinsi']['nama']);
                    }
                    if(response['dataPersonil']['kota_id_ktp']==null){
                        $('#id_ktp_kota').val(response['dataPersonil']['kota_id_ktp']);
                    }else{
                        $('#id_ktp_kota').val(response['dataPersonil']['kota_ktp']['nama']);
                    }
                    $('#id_alamat').val(response['dataPersonil']['alamat']);
                    if(typeof response['dataPersonil']['kota']!== 'undefined'){
                        $('#id_prov').val(response['dataPersonil']['kota']['provinsi']['nama']);
                    }
                    $('#id_kota').val(response['dataPersonil']['kota_id']);
                    $('#id_no_telp').val(response['dataPersonil']['no_hp']);
                    $('#id_email').val(response['dataPersonil']['email']);
                    $('#id_temp_lahir').val(response['dataPersonil']['temp_lahir'][
                        'ibu_kota'
                    ]);
                    $('#id_tgl_lahir').val(tgl_lahir);
                    $('#agama').val(capitalizeFirstLetter(response['dataPersonil']['agama']));

                    if(response['dataPersonil']['id_ptkp']==null){
                        $('#status_pajak').val(response['dataPersonil']['id_ptkp']);
                    }else{
                        $('#status_pajak').val(response['dataPersonil']['id_ptkp']['nama_ptkp']+' (' + response['dataPersonil']['id_ptkp']['remarks'] + ')');
                    }

                    if(response['dataPersonil']['status_pernikahan']=='K'){
                        $('#status_perni').val("Kawin");
                    }else if(response['dataPersonil']['status_pernikahan']=='BK'){
                        $('#status_perni').val("Belum Kawin");
                    }else if(response['dataPersonil']['status_pernikahan']=='CH'){
                        $('#status_perni').val("Cerai Hidup");
                    }else if(response['dataPersonil']['status_pernikahan']=='CM'){
                        $('#status_perni').val("Cerai Mati");
                    }else{
                        $('#status_perni').val("");
                    }

                    $('#bpjs_no').val(response['dataPersonil']['bpjs']);

                    $('#npwp').val(response['dataPersonil']['npwp']);
                    $('#id_norek_bank').val(response['dataPersonil']['no_rek']);
                    $('#id_namarek_bank').val(response['dataPersonil']['nama_rek']);
                    $('#id_nama_bank').val(response['dataPersonil']['id_bank']);

                    // Hapus semua data di table temporary
                    hapusalltemp();

                    //auto fill data sekolah
                    $('#data-sekolah > tbody').html("");
                    urut = 1;
                    id_detail = [];

                    // Menambahkan baris data detail sebanyak data yang ada
                    for (var i = 0; i < response['dataSekolah'].length; i++) {
                        var tgl_ijasah = response['dataSekolah'][i]['tgl_ijasah'];
                        var pdf_ijasah = response['dataSekolah'][i]['pdf_ijasah'];
                        if (response['dataSekolah'][i]['negara_s'] == null || response[
                                'dataSekolah'][i]['negara_s'] == '') {
                            negara = '-';
                        } else {
                            negara = response['dataSekolah'][i]['negara_s']['country_name'];
                        }
                        if (response['dataSekolah'][i]['default'] == '1') {
                            var dflt = 'Default';
                        } else {
                            var dflt = '';
                        }
                        $('#data-sekolah > tbody:last').append(`
                            <tr>
                                <td style="text-align:center;">` + urut + `</td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['jp']['deskripsi'] + `" type="text" class="form-control" placeholder="Jenjang Pendidikan"
                                        name="id_jp_` + urut + `" id="id_jp_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['nama_sekolah'] + `" type="text" class="form-control" placeholder="Nama Sekolah"
                                        name="id_namasekolah_` + urut + `" id="id_namasekolah_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + negara + `" type="text" class="form-control" placeholder="Negara Sekolah"
                                        name="id_negarasekolah_` + urut + `" id="id_negarasekolah_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['kota_s']['provinsi'][
                                'nama'
                            ] + `" type="text" class="form-control" placeholder="Prov Sekolah"
                                        name="id_provsekolah_` + urut + `" id="id_provsekolah_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['kota_s']['nama'] + `" type="text" class="form-control" placeholder="Kota Sekolah"
                                        name="id_kotasekolah_` + urut + `" id="id_kotasekolah_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['jurusan'] + `" type="text" class="form-control" placeholder="Prodi"
                                        name="id_prodi_` + urut + `" id="id_prodi_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['tahun'] + `" type="text" class="form-control" placeholder="Tahun Tamat"
                                        name="id_tahuntamat_` + urut + `" id="id_tahuntamat_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + response['dataSekolah'][i]['no_ijazah'] + `" type="text" class="form-control" placeholder="No Ijasah"
                                        name="id_noijasah_` + urut + `" id="id_noijasah_` + urut + `">
                                </td>
                                <td style="width:10%">
                                    <input disabled value="` + tanggal_indonesia(tgl_ijasah) + `"type="text" class="form-control" placeholder="id_tglijasah_"
                                        name="id_tglijasah_` + urut + `" id="id_tglijasah_` + urut + `">
                                </td>
                                <td>
                                    <input disabled value="` + dflt + `" type="text" class="form-control" placeholder=""
                                        name="id_default_` + urut + `" id="id_default_` + urut + `">
                                </td>
                                <td >
                                    <a target="_blank" href="/uploads/` + response['dataSekolah'][i]['pdf_ijasah'] + `" type="button" class="btn btn-primary btn-sm"
                                        placeholder="Pdf Ijasah" name="id_pdfijasah_` + urut + `" id="id_pdfijasah_` +
                            urut + `" style="margin-top:2px;margin-left:6px;">
                                        <i class="fa fa-file-pdf-o" ></i> Lihat</a>
                                </td>

                            </tr>
                        `);
                        urut++;
                    }

                    // auto fill dok personil
                    $('#data-dokpersonil > tbody').html("");
                    urutan = 1;
                    id_detail = [];

                    // Menambahkan baris data detail sebanyak data yang ada
                    for (var i = 0; i < response['dataSkpAk3'].length; i++) {
                        var tgl_terbit = response['dataSkpAk3'][i]['tgl_skp'];
                        var tgl_akhir = response['dataSkpAk3'][i]['tgl_akhir_skp'];
                        if (tgl_akhir == null || tgl_akhir == ''){
                            tgl_akhir = 'Berlaku Seumur Hidup';
                        } else{
                            tgl_akhir = tanggal_indonesia(response['dataSkpAk3'][i]['tgl_akhir_skp']);
                        }
                        if (response['dataSkpAk3'][i]['negara_s'] == null || response['dataSkpAk3'][i]['negara_s'] == ''){
                            negara = '-';
                        } else{
                            negara = response['dataSkpAk3'][i]['negara_s']['country_name'];
                        }

                        $('#data-dokpersonil > tbody:last').append(`
                            <tr>
                                <td style="text-align:center;">` + urutan + `</td>
                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['bidang_ak3']['kode_bidang'] + ` (` + response['dataSkpAk3'][i]['bidang_ak3']['jenis_usaha']['kode_jns_usaha'] + `)"
                                    type="text" class="form-control" placeholder="" name="id_bidang_` + urutan + `" id="id_bidang_` + urutan + `">
                                </td>
                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['bid_sertifikat_alat']['nama_srtf_alat'] + `" type="text" class="form-control" placeholder=""
                                        name="id_srtfalat_` + urutan + `" id="id_srtfalat_` + urutan + `">
                                </td>
                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['jenisdok_ak3']['Nama_jns_dok'] + `" type="text" class="form-control" placeholder=""
                                        name="id_jenisdok_` + urutan + `" id="id_jenisdok_` + urutan + `">
                                </td>
                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['instansi_skp'] + `" type="text" class="form-control" placeholder=""
                                        name="id_instansidok_` + urutan + `" id="id_instansidok_` + urutan + `">
                                </td>

                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['penyelenggara'] + `" type="text" class="form-control" placeholder=""
                                        name="id_penyelenggara_` + urutan + `" id="id_penyelenggara_` + urutan + `">
                                </td>
                                <td>
                                    <input readonly value="` + response['dataSkpAk3'][i]['no_skp'] + `" type="text" class="form-control" placeholder="Prodi"
                                        name="id_nodokumen_` + urutan + `" id="id_nodokumen_` + urutan + `">
                                </td>
                                <td style="width:10%">
                                    <input readonly value="` + tanggal_indonesia(tgl_terbit) + `"type="text" class="form-control" placeholder="id_tglijasah_"
                                        name="id_tglterbit_` + urutan + `" id="id_tglterbit_` + urutan + `">
                                </td>
                                <td style="width:10%">
                                    <input readonly value="` + tgl_akhir + `"type="text" class="form-control" placeholder="id_tglijasah_"
                                        name="id_tglakhir_` + urutan + `" id="id_tglakhir_` + urutan + `">
                                </td>
                                <td>
                                    <a target="_blank" href="/uploads/` + response['dataSkpAk3'][i]['pdf_skp_ak3'] + `" type="button" class="btn btn-primary btn-sm"
                                        placeholder="Pdf Dok" name="id_pdfdok_` + urutan + `" id="id_pdfdok_` +
                                        urutan + `" style="margin-top:2px;margin-left:6px;">
                                        <i class="fa fa-file-pdf-o" ></i> Lihat</a>
                                </td>
                                <td></td>
                            </tr>
                        `);
                        // Input data ke table temporary
                        id_bidang = response['dataSkpAk3'][i]['id_bid_skp'];
                        id_srtfalat = response['dataSkpAk3'][i]['id_srtf_alat'];
                        id_jenisdok = response['dataSkpAk3'][i]['jns_dok'];

                        inserttemp(id_bidang, id_srtfalat, id_jenisdok, urutan);

                        urutan++;
                    }

                },
                error: function (xhr) {
                    swal.fire('terjadi error ketika menampilkan data');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });
        });

        // Tambah Baris Data Dok Personil
        function add_Row(urutan) {

            $('#data-dokpersonil > tbody:last').append(`
                <tr class"odd" role="row">
                    <td style="text-align:center;">` + urutan + `</td>
                    <td>
                        <select required class="form-control select2 bidang_dok" id_srtfalat="id_srtfalat_` + urutan + `" name="id_bidang_` + urutan + `" id="id_bidang_` + urutan + `" style="width: 100%;">
                            <option value="" disabled selected></option>
                            @foreach($bidang as $key)
                            <option value="{{ $key->id }}">{{ $key->kode_bidang }} ({{ $key->jenis_usaha->kode_jns_usaha }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 nama_srtf" id_bidang="id_bidang_` + urutan +
                `" id_jenisdok="id_jenisdok_` + urutan + `" name="id_srtfalat_` + urutan + `" id="id_srtfalat_` +
                urutan + `" style="width: 100%;">
                        </select>
                    </td>
                    <td>
                        <select required class="form-control select2 jns_dok" id_namadok="id_namadok_` +
                urutan + `" id_srtfalat="id_srtfalat_` + urutan +
                `" name="id_jenisdok_` + urutan + `" id="id_jenisdok_` + urutan + `" style="width: 100%;">
                        </select>
                    </td>
                    <td><input autocomplete="off" name="id_instansidok_` + urutan + `" id="id_instansidok_` + urutan + `" type="text" class="form-control" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan Nama Instansi')" oninput="setCustomValidity('')"></td>
                    <td><input autocomplete="off" name="id_penyelenggara_` + urutan + `" id="id_penyelenggara_` + urutan + `" type="text" class="form-control" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan Nama Penyelenggara')" oninput="setCustomValidity('')"></td>
                    <td><input required name="id_nodokumen_` + urutan + `" id="id_nodokumen_` + urutan + `" type="text" class="form-control" placeholder=""
                        oninvalid="this.setCustomValidity('Masukkan No Dokumen')" oninput="setCustomValidity('')"></td>
                    <td style="width:10%">
                        <input required  autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                        class="form-control" id="id_tglterbit_` + urutan + `" name="id_tglterbit_` + urutan + `" placeholder="dd/mm/yyyy">
                    </td>
                    <td style="width:10%">
                        <input autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                            class="form-control inputtgl" id="id_tglakhir_` + urutan + `" name="id_tglakhir_` + urutan + `" placeholder="dd/mm/yyyy">
                    </td>
                    <td class="image-upload">
                        <label required for="id_pdfdok_` + urutan + `">
                                <i class="fa fa-upload" id="i_pdfdok_` + urutan + `" style="padding-top:8px;padding-left:5px;color:grey" >  Upload</i>
                        </label>
                        <input class="cstmfile" accept=".pdf,.jpeg,.jpg" name="id_pdfdok_` + urutan + `" idi="#i_pdfdok_` +
                urutan + `" id="id_pdfdok_` + urutan + `" type="file" class="" placeholder="">

                    </td>
                    <td style="padding-top:7px;"">
                        <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + urutan + `" >
                        <span class="fa fa-trash"></span></button>
                    </td>
                </tr>
            `);
            awal = "#id_tglterbit_" + urutan;
            akhir = "#id_tglakhir_" + urutan;
            setDateRangePicker(awal, akhir);

            // $('.instansi').select2();
            // $('.penyelenggara').select2();

            // $(document).on('change', '#id_instansidok_' + urutan , function (e) {
            //     let pilihan = $(this).val();
            //     if(pilihan == "lain") {
            //         $("#id_instansidok2_" + urutan).val("");
            //         $("#id_instansidok2_" + urutan).prop("disabled", false);
            //     } else {
            //         $("#id_instansidok2_" + urutan).val("");
            //         $("#id_instansidok2_" + urutan).prop("disabled", true);
            //     }
            // });
            // $(document).on('change', '#id_penyelenggara_' + urutan , function (e) {
            //     let pilihan = $(this).val();
            //     if(pilihan == "lain") {
            //         $("#id_penyelenggara2_" + urutan).val("");
            //         $("#id_penyelenggara2_" + urutan).prop("disabled", false);
            //     } else {
            //         $("#id_penyelenggara2_" + urutan).val("");
            //         $("#id_penyelenggara2_" + urutan).prop("disabled", true);
            //     }
            // });

            var instansi = "{{ route('searchInstansiByName') }}";
            var inst_dok = '#id_instansidok_' + urutan;
            var penye = '#id_penyelenggara_' + urutan;

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
        // var nomor = 1;
        var id_detail = [];
        $('#addRow').on('click', function () {
            if (id_detail == '') {
                // console.log('Masuk if cek id_detail');
                add_Row(urutan);
                id_detail.push(urutan);
                $('#id_detail_dokpersonil').val(id_detail);

                $('.select2').select2();

                urutan++;
                // nomor++;
            } else {
                // console.log('Masuk else cek id_detail');
                var last_element = id_detail[id_detail.length - 1];
                bidang_dok = $("#id_bidang_" + last_element).val();
                nama_srtf = $("#id_srtfalat_" + last_element).val();
                jenis_dok = $("#id_jenisdok_" + last_element).val();

                nama_dok = $("#id_namadok_" + last_element).val();

                if (bidang_dok == null || nama_srtf == null || jenis_dok == null) {
                    Swal.fire({
                        title: "Bidang Dok, Nama Dok atau Jenis Dok belum diisi!",
                        type: 'error',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#AAA'
                    });
                } else {
                    // console.log('Masuk tambah baris');
                    inserttemp(bidang_dok, nama_srtf, jenis_dok, last_element);

                    add_Row(urutan);
                    id_detail.push(urutan);
                    $('#id_detail_dokpersonil').val(id_detail);

                    $('#id_bidang_' + urutan).select2();
                    $('#id_srtfalat_' + urutan).select2();
                    $('#id_jenisdok_' + urutan).select2();
                    $('#id_namadok_' + urutan).select2();

                    urutan++;
                    // nomor++;
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
                // console.log('MASUK IF HAPUS');
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_detail_dokpersonil').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                bidang_dok = $("#id_bidang_" + last_element).val();
                nama_srtf = $("#id_srtfalat_" + last_element).val();
                jenis_dok = $("#id_jenisdok_" + last_element).val();
                nama_dok = $("#id_namadok_" + last_element).val();

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
                // console.log('MASUK ElSE HAPUS');
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

        // Function insert data ke table temporary
        function inserttemp(bidang_dok, nama_srtf, jenis_dok, last_element) {
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
                    bidang_dok: bidang_dok,
                    nama_srtf: nama_srtf,
                    jenis_dok: jenis_dok
                },
                success: function (data) {
                    if (last_element == "none") {

                    } else {
                        $("#id_bidang_" + last_element).parent().find(
                                '.select2-container--default')
                            .css('pointer-events', 'none');
                        $("#id_srtfalat_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#id_jenisdok_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');
                        $("#id_namadok_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');

                        $("#id_bidang_" + last_element).parent().find(
                                '.select2-selection--single')
                            .css('background', 'silver');
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



        // $(document).on('click', '.inputtgl', function (e) {
        //     $(this).datepicker({
        //         format: 'yyyy/mm/dd',
        //         autoclose: true,

        //     })
        // });
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
        autoclose: true,
        maxDate: new Date('2020-9-10')
    })

</script>
@endpush
