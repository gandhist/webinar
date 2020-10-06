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
        Tambah Ijin PJS_PPKB Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Daftar Ijin PJS_PPKB Mandiri</a></li>
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

            <form action="{{ route('ijinppkb.store') }}" class="form-horizontal" id="formAdd" name="formAdd"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div
                                class="input-group {{ $errors->first('id_kode_pjk3') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Ijin PJS_PPKB
                                </div>
                                <select class="form-control select2" name="id_kode_pjk3" id="id_kode_pjk3"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Nama Ijin PJS_PPKB</option>
                                    @foreach($badanusaha as $key)
                                    <option value="{{ $key->id }}"
                                        {{ $key->id == old('id_kode_pjk3') ? 'selected' : '' }}>
                                        {{ $key->nama_bu }} </option>
                                    @endforeach
                                </select>
                            </div>
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
                                    placeholder="Provinsi Naker" value="{{old('id_prov_naker')}}" disabled>
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
                                    placeholder="Alamat Jalan, Kelurahan, Kecamatan" value="{{old('id_alamat_bu')}}"
                                    disabled>
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
                                    placeholder="Provinsi BU" value="{{old('id_prov_bu')}}" disabled>
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
                                    placeholder="Kota BU" value="{{old('id_kota_bu')}}" disabled>
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
                                    placeholder="No Tlp" value="{{old('id_no_telp')}}" disabled>
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
                                    placeholder="Email" value="{{old('id_email')}}" disabled>
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
                                    placeholder="Instansi Reff" value="{{old('id_instansi')}}" disabled>
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
                                <input name="id_web" id="id_web" type="text" class="form-control" placeholder="Web"
                                    value="{{old('id_web')}}" disabled>
                            </div>
                            <span id="id_web" class="help-block customspan">{{ $errors->first('id_web') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div
                                class="input-group {{ $errors->first('id_nama_p') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Pimpinan
                                </div>
                                <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                    autocomplete="off" placeholder="Nama Pimpinan" value="{{old('id_nama_p')}}">
                                {{-- <select class="form-control select2" name="id_nama_p" id="id_nama_p"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Nama Pimpinan</option>
                                    @foreach($personil as $key)
                                    <option id-personil="{{ $key->id }}" value="{{ $key->nama }}">
                                {{ $key->nama }}
                                </option>
                                @endforeach
                                <option id-personil="lain" value="lain">Lainnya</option>
                                </select> --}}
                                <!-- <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                    placeholder="Nama Pimpinan" value="{{old('id_nama_p')}}"> -->
                            </div>
                            <span id="id_nama_p" class="help-block customspan">{{ $errors->first('id_nama_p') }} </span>
                        </div>



                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Pimpinan
                                </div>
                                <input name="id_jab_p" id="id_jab_p" type="text" class="form-control"
                                    placeholder="Jabatan Pimpinan" value="{{old('id_jab_p')}}">
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
                                    placeholder="No Hp Pimpinan" value="{{old('id_hp_p')}}">
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
                                    placeholder="Email Pimpinan" value="{{old('id_email_p')}}">
                            </div>
                            <span id="id_email_p" class="help-block customspan">{{ $errors->first('id_email_p') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div
                                class="input-group {{ $errors->first('id_nama_kp') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Kontak Person
                                </div>

                                <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    autocomplete="off" placeholder="Nama Kontak Person" value="{{old('id_nama_kp')}}">

                                <!-- <select class="form-control select2" name="id_nama_kp" id="id_nama_kp"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Nama Kontak Person</option>
                                    @foreach($personil as $key)
                                    <option id-personil="{{ $key->id }}" value="{{ $key->nama }}">
                                        {{ $key->nama }}
                                    </option>
                                    @endforeach
                                    <option id-personil="lain" value="lain">Lainnya</option>
                                </select> -->
                                <!-- <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    placeholder="Nama Kontak Person" value="{{old('id_nama_kp')}}"> -->
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
                                    placeholder="Jabatan Kontak Person" value="{{old('id_jab_kp')}}">
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
                                    placeholder="No HP Kontak Person" value="{{old('id_hp_kp')}}">
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
                                    placeholder="Email Kontak Person" value="{{old('id_email_kp')}}">
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
                                    placeholder="No NPWP" value="{{old('id_npwp')}}" disabled>
                            </div>
                            <span id="id_npwp" class="help-block customspan">{{ $errors->first('id_npwp') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 ">
                            <div
                                class="input-group {{ $errors->first('id_norek_bank') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    No Rekening Bank
                                </div>
                                <input name="id_norek_bank" id="id_norek_bank" type="text" class="form-control"
                                    placeholder="No Rekening Bank" value="{{old('id_norek_bank')}}">
                            </div>
                            <span id="id_norek_bank" class="help-block customspan">{{ $errors->first('id_norek_bank') }}
                            </span>
                        </div>

                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-5">
                            <div
                                class="input-group {{ $errors->first('id_namarek_bank') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    Nama Rekening Bank
                                </div>
                                <input name="id_namarek_bank" id="id_namarek_bank" type="text" class="form-control"
                                    placeholder="Nama Rekening Bank" value="{{old('id_namarek_bank')}}">
                            </div>
                            <span id="id_namarek_bank"
                                class="help-block customspan">{{ $errors->first('id_namarek_bank') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div
                                class="input-group {{ $errors->first('id_nama_bank') ? 'has-error has-error-select' : '' }}">
                                <div class="input-group-addon">
                                    Nama Bank
                                </div>
                                <select class="form-control select2" name="id_nama_bank" id="id_nama_bank"
                                    style="width: 100%;">
                                    <option value="" disabled selected>Nama Bank</option>
                                    @foreach($bank as $key)
                                    <option value="{{ $key->id_bank }}"
                                        {{ $key->id_bank == old('id_nama_bank') ? 'selected' : '' }}>
                                        {{ $key->Nama_Bank }}
                                    </option>
                                    @endforeach
                                </select>
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



                <!-- <div class="btn-group btn-lg">
                    <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span> Tambah
                        SKP</button>
                </div> -->
                <!-- <div class="btn-group">
                    <h4><b>Tambah Kontak</b></h4>
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
                                <th style="width:1%">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- /.box-body -->
                <input type="hidden" name='id_jumlah_detail' id='id_jumlah_detail' value=''>

                <br>
                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url('ijinppkb') }}" class="btn btn-md btn-default"><i
                                    class="fa fa-times-circle"></i>
                                Batal</a>
                        </div>
                    </div>
                </div>
                <br>

                <!-- <div class="box-footer">
                    <a href="{{ url('daftarpjk3') }}" class="btn btn-md btn-default pull-left"><i
                            class="fa fa-times-circle"></i> Batal</a>
                    <button type="submit" class="btn btn-md btn-info pull-left"> <i class="fa fa-save"></i>
                        Simpan</button>
                </div> -->
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

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

        //Kunci Input No Hp Hanya Angka
        $('#id_norek_bank').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        })

        // Fungsi Tambah Baris Detail
        function add_row(no) {
            $('#kontak-Detail > tbody:last').append(`
            <tr>
                                <td>` + no + `</td>
                                <td>
                                    <select required class="form-control select2 jns_usaha" name="jns_usaha_detail_` +
                no + `"
                                        id="jns_usaha_detail_` + no +
                `" style="width: 100%;" idbidang="bidang_detail_` + no + `">
                                        <option value="" disabled selected>Pilih Jenis Usaha</option>
                                        @foreach($jenisusaha as $key)
                                        <option value="{{ $key->id }}">
                                            {{ $key->kode_jns_usaha }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select required class="form-control select2" name="bidang_detail_` + no +
                `" id="bidang_detail_` + no + `" style="width: 100%;">
                                        <option value="" disabled selected>Pilih Bidang SKP</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="No SKP" name="no_skp_` + no +
                `" id="no_skp_` + no + `"></td>
                                <td style="width:10%"> <input autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="Tgl_Terbit SKP" name="tgl_terbit_` + no + `" id="tgl_terbit_` +
                no + `"></td>
                                <td style="width:10%"> <input autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="Tgl_Akhir SKP" name="tgl_akhir_` + no + `" id="tgl_akhir_` + no + `"></td>
                                <td style="width:15%"><input style="padding: 3px 3px;" required type="file" class="form-control cstmfile" placeholder="Pdf SKP"
                                        name="pdf_skp_` + no + `" id="pdf_skp_` + no + `"></td>
                                <td style="width:1%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" onclick=""><span class="fa fa-trash"></span></button></td>

                            </tr>
            `);
            awal = "#tgl_terbit_" + no;
            akhir = "#tgl_akhir_" + no;
            setDateRangePicker(awal, akhir);
        }

        //Pilih Nama PJK3 on Change
        $(document).on('change', '#id_kode_pjk3', function (e) {
            var id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('ijinppkb/get_pjk3') }}/" + id,
                type: "POST",
                success: function (response) {
                    // console.log(response);
                    // Memberi value badan usaha
                    $('#id_alamat_bu').val(response['dataPjk3']['alamat']);
                    $('#id_prov_bu').val(response['dataPjk3']['id_prop']);
                    $('#id_kota_bu').val(response['dataPjk3']['id_kota']);
                    $('#id_no_telp').val(response['dataPjk3']['telp']);
                    $('#id_prov_naker').val(response['dataPjk3']['prop_naker']);
                    $('#id_email').val(response['dataPjk3']['email']);
                    $('#id_instansi').val(response['dataPjk3']['instansi_reff']);
                    $('#id_web').val(response['dataPjk3']['web']);
                    $('#id_npwp').val(response['dataPjk3']['npwp']);

                    // if (response['skpPjk3'].length <= 0) {
                    // $('#id_nama_p').val("").trigger('change');
                    // $('#nama_p_lain').val("");
                    // $('#nama_p_lain').css("background", 'silver');
                    // $('#nama_p_lain').attr("readonly", "readonly");

                    // $('#id_nama_kp').val("").trigger('change');
                    // $('#nama_kp_lain').val("");
                    // $('#nama_kp_lain').css("background", 'silver');
                    // $('#nama_kp_lain').attr("readonly", "readonly");

                    // $('#id_jab_p').val("");
                    // $('#id_hp_p').val("");
                    // $('#id_email_p').val("");

                    // $('#id_jab_kp').val("");
                    // $('#id_hp_kp').val("");
                    // $('#id_email_kp').val("");

                    // $('#id_norek_bank').val("");
                    // $('#id_namarek_bank').val("");
                    // $('#id_nama_bank').val("").trigger('change');
                    // } else {
                    // if (response['cek_pimp'] <= 0) {
                    //     $('#id_nama_p').val('lain');
                    //     $('#nama_p_lain').val(response['skpPjk3'][0]['nama_pimp']);
                    //     $('#nama_p_lain').css("background", 'white');
                    //     $('#nama_p_lain').removeAttr("readonly");
                    // } else {
                    //     $('#id_nama_p').val(response['skpPjk3'][0]['nama_pimp']);
                    //     $('#nama_p_lain').val("");
                    //     $('#nama_p_lain').css("background", 'silver');
                    //     $('#nama_p_lain').attr("readonly", "readonly");
                    // }

                    // if (response['cek_kp'] <= 0) {
                    //     $('#id_nama_kp').val('lain');
                    //     $('#nama_kp_lain').val(response['skpPjk3'][0]['nama_kp']);
                    //     $('#nama_kp_lain').css("background", 'white');
                    //     $('#nama_kp_lain').removeAttr("readonly");
                    // } else {
                    //     $('#id_nama_kp').val(response['skpPjk3'][0]['nama_kp']);
                    //     $('#nama_kp_lain').val("");
                    //     $('#nama_kp_lain').css("background", 'silver');
                    //     $('#nama_kp_lain').attr("readonly", "readonly");
                    // }
                    $('#id_nama_p').val(response['dataPjk3']['nama_pimp']);
                    $('#id_nama_kp').val(response['dataPjk3']['kontak_p']);

                    $('#id_jab_p').val(response['dataPjk3']['jab_pimp']);
                    $('#id_hp_p').val(response['dataPjk3']['hp_pimp']);
                    $('#id_email_p').val(response['dataPjk3']['email_pimp']);

                    $('#id_jab_kp').val(response['dataPjk3']['jab_kontak_p']);
                    $('#id_hp_kp').val(response['dataPjk3']['no_kontak_p']);
                    $('#id_email_kp').val(response['dataPjk3']['email_kontak_p']);

                    $('#id_norek_bank').val(response['dataPjk3']['no_rek']);
                    $('#id_namarek_bank').val(response['dataPjk3']['nama_rek']);

                    if(response['dataPjk3']['id_bank']){
                        // $("#default_bank").removeAttr("selected");
                        $('#id_nama_bank').val(response['dataPjk3']['id_bank']).trigger('change');
                    }

                    // $('#id_norek_bank').val("");
                    // $('#id_namarek_bank').val("");
                    // $('#id_nama_bank').val("").trigger('change');
                    // }

                    hapusalltemp();

                    // Hapus semua data detail & ulangi dari awal
                    $('#kontak-Detail > tbody').html("");
                    no = 1;
                    id_detail = [];


                    // Menambahkan baris data detail sebanyak data yang ada
                    for (var i = 0; i < response['skpPjk3'].length; i++) {

                        if (response['skpPjk3'][i]['tgl_sk'] == null) {
                            tgl_terbit = "";
                        } else {
                            tgl_terbit = new Date(response['skpPjk3'][i]['tgl_sk']);
                            tgl_terbit = convertDate(tgl_terbit);
                        }

                        if (response['skpPjk3'][i]['tgl_akhir_sk'] == null) {
                            tgl_akhir = "";
                        } else {
                            tgl_akhir = new Date(response['skpPjk3'][i]['tgl_akhir_sk']);
                            tgl_akhir = convertDate(tgl_akhir);
                        }

                        $('#kontak-Detail > tbody:last').append(`
            <tr>
                                <td>` + no + `</td>
                                <td>
                                    <select required class="form-control select2 jns_usaha" name="jns_usaha_detail_` +
                            no + `"
                                        id="jns_usaha_detail_` + no +
                            `" style="width: 100%;" idbidang="bidang_detail_` + no + `">
                                        <option value="` + response['skpPjk3'][i]['bidang']['id_jns_usaha'] + `" >` +
                            response['skpPjk3'][i]['bidang']['jenis_usaha'][
                                'kode_jns_usaha'
                            ] + `</option>
                                    </select>
                                </td>
                                <td>
                                    <select required class="form-control select2" name="bidang_detail_` + no +
                            `" id="bidang_detail_` + no + `" style="width: 100%;">
                                        <option value="` + response['skpPjk3'][i]['bidang']['id'] + `">` + response[
                                'skpPjk3'][i]['bidang']['nama_bidang'] + `</option>
                                    </select>
                                </td>
                                <td><input value="` + cekNull(response['skpPjk3'][i]['no_sk']) +
                            `" type="text" class="form-control" placeholder="No SKP" name="no_skp_` +
                            no +
                            `" id="no_skp_` + no + `"></td>
                                <td style="width:10%"> <input value="` + tgl_terbit + `" autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="Tgl_Terbit SKP" name="tgl_terbit_` + no + `" id="tgl_terbit_` +
                            no + `"></td>
                                <td style="width:10%"> <input value="` + tgl_akhir + `" autocomplete="off" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy" type="text" class="form-control"
                                        placeholder="Tgl_Akhir SKP" name="tgl_akhir_` + no + `" id="tgl_akhir_` + no + `"></td>
                                <td style="width:15%"><input style="padding: 3px 3px;" type="file" class="form-control cstmfile" placeholder="Pdf SKP"
                                        name="pdf_skp_` + no + `" id="pdf_skp_` + no + `"></td>
                                <td style="width:1%"></td>
                            </tr>
            `);


                        // Insert data ke table temporary kecuali yang terakhir
                        id_jenis_usaha = response['skpPjk3'][i]['bidang']['id_jns_usaha'];
                        id_bidang = response['skpPjk3'][i]['bid_sk'];

                        // if (i == (response['skpPjk3'].length) - 1) {

                        // } else {
                        inserttemp(id_jenis_usaha, id_bidang, no);
                        // }
                        // End

                        $('.select2').select2();
                        id_detail.push(no);
                        $('#id_jumlah_detail').val(id_detail);
                        no++;
                    }
                },
                error: function (xhr) {
                    alert('Error');
                }
            });
        });

        // Button Tambah Baris Detail
        var no = 1;
        var id_detail = [];
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
                    // Insert data detail ke table temporary
                    inserttemp(id_jenis_usaha, id_bidang, last_element);

                    add_row(no);
                    id_detail.push(no);
                    $('#id_jumlah_detail').val(id_detail);

                    // Menjalankan Select2 pada baris baru
                    $('#jns_usaha_detail_' + no).select2();
                    $('#bidang_detail_' + no).select2();

                    no++;
                }
            }
        });

        //Button Hapus Baris Detail
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
                                '.select2-container--default')
                            .css('pointer-events', 'none');
                        $("#bidang_detail_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');

                        $("#jns_usaha_detail_" + last_element).parent().find(
                                '.select2-selection--single')
                            .css('background', 'silver');
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

        // Fungsi hapus semua data di table temporary
        function hapusalltemp() {
            var url = "{{ url('delete_all_temp_skp_pjk3') }}";
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
                    console.log('Sukses');
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
                        "<option value='' selected disabled>Pilih Bidang SKP</option>");
                    $("#" + idbidang).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi konversi date javascript
        function convertDate(inputFormat) {

            function pad(s) {
                return (s < 10) ? '0' + s : s;
            }
            var d = new Date(inputFormat)
            return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('/')

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
