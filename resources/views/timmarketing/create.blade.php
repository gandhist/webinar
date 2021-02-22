@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
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
<section class="content-header">
    <h1>
        Tambah Tim Marketing PKB P3S Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Tim Marketing</a></li>
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

            <form action="" class="form-horizontal" id="formAdd" name="formAdd" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Tim Marketing
                                </div>
                                <input name="nama" id="nama" class="form-control" placeholder="">
                            </div>
                            <span id="nama" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Singkat
                                </div>
                                <input name="nama_singkat" id="nama_singkat" class="form-control"
                                    placeholder="*Nama Singkat">
                            </div>
                            <span id="nama_singkat" class="help-block customspan"></span>
                        </div>

                        {{-- <div class="col-sm-1">
                        </div> --}}

                        <div class="col-sm-2" style="text-align:right">
                            <div class="row">
                                <div class="col-sm-10" style="color:red;padding-top:2px !important">
                                    Badan Usaha
                                </div>
                                <div class="col-sm-2">
                                    <input style="height:18px !important" id="ckbadanusaha" type="checkbox">
                                </div>
                            </div>

                            <!-- <div class="checkbox" style="padding-top: 0px;color:red">
                                Badan Usaha
                                <label>
                                    <input type="checkbox" id="ckbadanusaha" style="margin: 0 0 0 0;">
                                </label>
                            </div> -->
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon checkbox">
                                    Badan Usaha
                                </div>
                                <select class="form-control select2" name="id_bu" id="id_bu" style="width: 100%;">
                                    <option value="" disabled selected>Non BU</option>
                                    {{-- @foreach($bentukbu as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <span id="id_bu" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Level_M
                                </div>
                                <select class="form-control select2" name="leveltimmkt" id="leveltimmkt"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($leveltimmkt as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama_level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="leveltimmkt" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Tim Marketing Level
                                </div>
                                <select class="form-control select2" name="timmktatas" id="timmktatas"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                </select>
                            </div>
                            <span id="timmktatas" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Alamat
                                </div>
                                <input type="text" name="id_alamat" id="id_alamat" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_alamat" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Provinsi
                                </div>
                                <select class="form-control select2" name="id_prov" id="id_prov" style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($prov as $key)
                                    <option value="{{ $key->id }}">
                                        {{ $key->nama }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="id_prov" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Kota
                                </div>
                                <select class="form-control select2" name="id_kota" id="id_kota" style="width: 100%;">
                                    <option value="" disabled selected></option>
                                </select>
                            </div>
                            <span id="id_kota" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> No Tlp
                                </div>
                                <input name="id_no_telp" id="id_no_telp" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_no_telp" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Email
                                </div>
                                <input name="id_email" id="id_email" type="email" class="form-control"
                                    placeholder="" value="{{old('id_email')}}">
                            </div>
                            <span id="id_email" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Instansi Reff
                                </div>
                                <input name="id_instansi" id="id_instansi" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_instansi" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Web
                                </div>
                                <input name="id_web" id="id_web" type="text" class="form-control" placeholder="">
                            </div>
                            <span id="id_web" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Pimpinan
                                </div>
                                <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_nama_p" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Pimpinan
                                </div>
                                <input name="id_jab_p" id="id_jab_p" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_jab_p" class="help-block customspan"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Hp Pimpinan
                                </div>
                                <input name="id_hp_p" id="id_hp_p" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_hp_p" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Email Pimpinan
                                </div>
                                <input name="id_eml_p" id="id_eml_p" type="email" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_eml_p" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Nama Kontak Person
                                </div>
                                <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_nama_kp" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jabatan Kontak Person
                                </div>
                                <input name="id_jab_kp" id="id_jab_kp" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_jab_kp" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> No HP Kontak Person
                                </div>
                                <input name="id_hp_kp" id="id_hp_kp" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_hp_kp" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="bintang">*</span> Email Kontak Person
                                </div>
                                <input name="id_email_kp" id="id_email_kp" type="email" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_email_kp" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No NPWP
                                </div>
                                <input type="text" data-inputmask="'mask': ['99.999.999.9-999.999']" data-mask=""
                                    id="id_npwp" name="id_npwp" class="form-control" placeholder="">
                            </div>
                            <span id="id_npwp" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    File NPWP
                                </div>
                                <input style="padding:2px" type="file" class="form-control" id="id_file_npwp"
                                    name="id_file_npwp" placeholder="">
                            </div>
                            <span id="id_file_npwp" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    No Rekening Bank
                                </div>
                                <input name="id_no_rek" id="id_no_rek" type="text" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_no_rek" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Rekening Bank
                                </div>
                                <input name="id_nama_rek" id="id_nama_rek" type="email" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_nama_rek" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Nama Bank
                                </div>
                                <select class="form-control select2" name="id_bank" id="id_bank" style="width: 100%;">
                                    <option value="" selected></option>
                                    @foreach($bank as $key)
                                    <option value="{{ $key->id_bank }}">
                                        {{ $key->Nama_Bank }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="id_bank" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Jenis Usaha
                                </div>
                                <select class="form-control select2" name="id_jenis_usaha" id="id_jenis_usaha"
                                    style="width: 100%;">
                                    <option value="" disabled selected></option>
                                    @foreach($jenisusaha as $key)
                                    <option value="{{ $key->id }}">
                                        {{ $key->nama_jns_usaha }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="id_jenis_usaha" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Tim Produksi
                                </div>
                                <select class="form-control select2" name="tim_prod" id="tim_prod" style="width: 100%;">
                                    <option value="" selected></option>
                                    <!-- @foreach($timproduksi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama_tim_p }}</option>
                                    @endforeach -->
                                </select>
                            </div>
                            <span id="tim_prod" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Gol Harga Marketing
                                </div>
                                <select class="form-control select2" name="gol_harga" id="gol_harga"
                                    style="width: 100%;">
                                    <option value="" selected></option>
                                    @foreach($golharga as $key)
                                    <option value="{{ $key->kode }}">
                                        {{ $key->kode }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="gol_harga" class="help-block customspan"></span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Keterangan
                                </div>
                                <input name="id_keterangan" id="id_keterangan" type="email" class="form-control"
                                    placeholder="">
                            </div>
                            <span id="id_keterangan" class="help-block customspan"></span>
                        </div>
                    </div>

                    <div class="row" style="text-align:right">
                        <div class="col-sm-12">
                            <span class="bintang"><b>*</b></span> Wajib Diisi
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-6">
                            <select class="form-control select2" name="tim_prod" id="tim_prod" style="width: 100%;">
                                <option value="" disabled selected></option>
                                @foreach($timproduksi as $key)
                                <option value="{{ $key->id }}">{{ $key->nama_tim_p }}</option>
                                @endforeach
                            </select>
                            <span id="tim_prod" class="help-block customspan"></span>
                        </div>
                    </div> --}}

                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <input name="ket" id="ket" class="form-control" placeholder="">
                            <span id="ket" class="help-block customspan"></span>
                        </div>
                    </div> -->
                </div>

                <!-- End Detail -->
                <div class="box-footer" style="text-align:center">
                    <div class="row">
                        <div class="col-sm-6">
                            <button id="btnSave" type="button" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url('timmarketing/all') }}" class="btn btn-md btn-default"><i
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

    $(function () {

        // untuk dropdown cari berdasarkan nama
        sugestPersonil('id_nama_p', 'id_hp_p','id_eml_p',"{{ route('searchPersonilByName') }}"); // Jika tidak autocomplete ke hp atau email parameter ny di kosongkan
        sugestPersonil('id_nama_kp', 'id_hp_kp','id_email_kp',"{{ route('searchPersonilByName') }}");

        // $("#tim_prod,#id_jenis_usaha").parent().find('.select2-selection--single')
        //     .css('background', 'silver');
        // $("#tim_prod,#id_jenis_usaha").parent().find(
        //     '.select2-container--default').css('pointer-events', 'none');


        $('#id_jenis_usaha').change(function () {
            y = $(this).val();
            autofilltimprod(y);
        });

        $('#ckbadanusaha').change(function () {
            if (this.checked) {
                getbadanusaha('on');
            } else {
                getbadanusaha('off');
            }
            // $('#textbox1').val(this.checked);
        });

        $('#id_bu').change(function () {
            autofillnpwp($(this).val());
        });

        $('#leveltimmkt').on('select2:select', function () {
            x = $(this).val();
            changelevelatas(x);
        });

        // $('#tim_prod').on('change', function () {
        //     changetimprod();
        // });

        // Readonly Jenis Usaha
        // $("#id_jenis_usaha").parent().find('.select2-container--default').css('pointer-events',
        //     'none');
        // $("#id_jenis_usaha").parent().find('.select2-selection--single').css('background', '#eee');

        // Autofill ketika pjk3 change
        // $('#id_pjk3').on('select2:select', function () {
        //     pjk3_change();
        // });

        $('#btnSave').on('click', function (e) {
            e.preventDefault();
            store();
        });

        // format input
        $('[data-mask]').inputmask()

        // Filter Kota Berdasarkan Provinsi
        $('#id_prov').on('select2:select', function () {
            var url = `{{ url('register_perusahaan/chain') }}`;
            chainedProvinsi(url, 'id_prov', 'id_kota', "*Kota");
        });

        //Kunci Input No Hp Hanya Angka
        $('#id_no_telp,#id_hp_p,#id_hp_kp,#id_no_rek').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        })

        function store() {
            var formData = new FormData($('#formAdd')[0]);

            var url = "{{ url('timmarketing/save') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
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
                success: function (response) {
                    // console.log(response);
                    if (response.status) {
                        Swal.fire({
                            title: response.message,
                            type: response.icon,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#AAA'
                        }).then(function () {
                            if (response.icon == "warning") {

                            } else {
                                window.location.replace("{{ url('timmarketing/all') }}");
                            }
                        });
                    }
                },
                error: function (xhr, status) {
                    var a = JSON.parse(xhr.responseText);
                    // console.log(a);
                    $(".form-control").parent().removeClass('has-error');
                    $(".select2").parent().parent().removeClass('has-error');
                    $(".textarea").css('border-color', 'rgb(118, 118, 118)');
                    $(".select2-selection").css('border-color', '#aaa');
                    $('.x').removeClass('has-error');
                    $('.help-block').text("");
                    $.each(a.errors, function (key, value) {
                        tipeinput = $('#' + key).attr("class");
                        tipeselect = "select2";
                        tipetextarea = "textarea";
                        if (tipeinput.indexOf(tipeselect) > -1) {
                            $("#" + key).parent().parent().addClass("has-error-select has-error");
                            $("#" + key).parent().find(".select2-container").children()
                                .children().css(
                                    'border-color', '#a94442');
                            $('span[id^="' + key + '"]').text(value);
                        } else if (tipeinput.indexOf(tipetextarea) > -1) {
                            $("#" + key).css('border-color', '#a94442');
                            $('span[id^="' + key + '"]').text(value);
                        } else {
                            $('[name="' + key + '"]').parent().addClass(
                                'has-error'
                            );
                            if (!$('[name="' + key + '"]').is("select")) {
                                $('[name="' + key + '"]').next().text(
                                    value);
                            }
                            $('span[id^="' + key + '"]').text(value);
                        }

                    });
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                    // $("#btnSave").button('reset');
                }
            });
        }

        // function pjk3_change() {
        //     var url = "{{ url('timproduksi/changepjk3') }}";
        //     var id_pjk3 = $("#id_pjk3").val();
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: url,
        //         method: 'POST',
        //         data: {
        //             id_pjk3: id_pjk3
        //         },
        //         success: function (data) {
        //             $("#id_instansi").val(data['instansi_reff']);
        //             $("#id_web").val(data['web']);
        //             $('#bentuk_bu').val(data['id_bentuk_usaha']);
        //             $('#bentuk_bu').trigger('change');
        //             $('#id_jenis_usaha').val(data['jns_usaha']);
        //             $('#id_jenis_usaha').trigger('change');
        //             console.log(data['id_bentuk_usaha']);
        //         },
        //         error: function (xhr, status) {
        //             alert('Error');
        //         }
        //     });
        // }
        function autofilltimprod(y) {
            var url = "{{ url('timmarketing/autofilltimprod') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    value: y
                },
                success: function (data) {
                    $("#tim_prod").html(
                        "<option value='' disabled>-- Pilih Tim Produksi --</option>");
                    $("#tim_prod").select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        function changelevelatas(x) {
            var url = "{{ url('timmarketing/changelevelatas') }}";
            var leveltimmkt = $("#leveltimmkt").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    leveltimmkt: leveltimmkt
                },
                success: function (data) {



                    level = $('#leveltimmkt').val();
                    if (level != 1 && data.length <= 0) {
                        alert('Level atas belum terdaftar');
                        $('#leveltimmkt').val("").trigger('change.select2');
                        $("#timmktatas").html(
                            "<option value='' disabled selected></option>"
                        );
                    } else {
                        $("#timmktatas").html(
                            "<option value='' disabled></option>");
                        $("#timmktatas").select2({
                            data: data
                        }).val(null).trigger('change');
                        // $('#timmktatas').val($('#timmktatas option:eq(1)').val()).trigger(
                        //     'change.select2');
                        // $('#timprodatas').select2("val", $('#timprodatas option:eq(1)').val());
                    }

                    // if (x == 1) {
                    //     $("#tim_prod").parent().find('.select2-selection--single')
                    //         .css('background', 'white');
                    //     $("#tim_prod").parent().find(
                    //         '.select2-container--default').css('pointer-events', '');
                    // } else {
                    //     $("#tim_prod").parent().find('.select2-selection--single')
                    //         .css('background', 'silver');
                    //     $("#tim_prod").parent().find(
                    //         '.select2-container--default').css('pointer-events', 'none');
                    // }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        function changetimprod() {
            var url = "{{ url('timmarketing/changetimprod') }}";
            var tim_prod = $("#tim_prod").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    tim_prod: tim_prod
                },
                success: function (data) {

                    // level = $('#leveltimprod').val();
                    // if (level != 1 && data.length <= 0) {
                    //     alert('Level atas belum terdaftar');
                    //     $('#leveltimprod').val("").trigger('change.select2');
                    //     $("#timprodatas").html(
                    //         "<option value='' disabled selected></option>"
                    //     );
                    // } else {
                    // $("#id_jenis_usaha").html();
                    $("#id_jenis_usaha").html(
                        "<option value='' disabled selected></option>"
                    ).trigger('change');
                    // $('#id_jenis_usaha').html("").trigger('change');
                    $("#id_jenis_usaha").select2({
                        data: data
                    }).val(null).trigger('change');
                    $('#id_jenis_usaha').val($('#id_jenis_usaha option:eq(1)').val()).trigger(
                        'change.select2');

                    // $("#id_jenis_usaha").parent().find('.select2-selection--single')
                    //     .css('background', 'silver');
                    // $("#id_jenis_usaha").parent().find(
                    //     '.select2-container--default').css('pointer-events', 'none');
                    // }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        function getbadanusaha(status) {
            var url = "{{ url('timmarketing/changebadanusaha') }}";
            // var ceklis = $("#ckbadanusaha").val();

            if (status == "on") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        status: status
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#id_bu").html(
                            "<option value='' selected></option>"
                        ).trigger('change');

                        $("#id_bu").select2({
                            data: data
                        }).val(null).trigger('change');
                        // $('#id_bu').val($('#id_bu option:eq(1)').val()).trigger(
                        //     'change.select2');

                    },
                    error: function (xhr, status) {
                        alert('Error');
                    }
                });
            } else {
                $("#id_bu").html(
                    "<option value='' disabled selected>Non BU</option>"
                ).trigger('change');
            }
        }

        function autofillnpwp(value) {
            if (value == "" || value == null) {
                $("#id_npwp").val('');
            } else {
                var url = "{{ url('timmarketing/autofillnpwp') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        value: value
                    },
                    success: function (data) {
                        $("#id_npwp").val(data['npwp']);

                    },
                    error: function (xhr, status) {
                        alert('Error');
                    }
                });

            }
        }

    });

    //Initialize Select2 Elements
    $('.select2').select2();

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
