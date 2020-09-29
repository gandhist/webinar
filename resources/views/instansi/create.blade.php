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
    input[type="checkbox"] {
        height: 16px !important;
        border-radius: 4px !important;
        width: 16px;
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
    .horizontal-line {
        width:30%;
        height:0px;
        border-top:
        1px solid gray;
        margin:45px auto;
    }
</style>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Tambahkan Badan Usaha
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Badan Usaha</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <form method="POST" action="{{ url('instansi/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
            <div class="row">
                {{-- Nama Instansi --}}
                <div class="col-sm-12 {{ $errors->first('nama_bu') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Nama Badan Usaha
                        </div>
                        <input name="nama_bu" id="nama_bu" class="form-control"
                            placeholder="*Nama Badan Usaha (Tanpa Bentuk Badan Usaha)" value="{{old('nama_bu')}}">
                    </div>
                    <span id="nama_bu"
                        class="help-block customspan">{{ $errors->first('nama_bu') }}
                    </span>
                </div>
                {{-- Akhir Nama Instansi --}}
            </div>

            <div class="row">
                {{-- Nama Singkat BU --}}
                <div class="col-sm-5 {{ $errors->first('singkat_bu') ? 'has-error' : '' }} ">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Singkat Badan Usaha
                        </div>
                        <input name="singkat_bu" id="singkat_bu" type="text" class="form-control"
                        placeholder="*Nama Singkat Badan Usaha" value="{{old('singkat_bu')}}">
                    </div>

                    <span id="singkat_bu" class="help-block customspan">{{ $errors->first('singkat_bu') }}
                    </span>
                </div>
                {{-- Akhir Nama Singkat BU --}}

                <div class="col-sm-2">
                </div>

                {{-- Bentuk BU --}}
                <div class="col-sm-5  ">
                    <div class="input-group {{ $errors->first('bentuk_bu') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Bentuk BU
                        </div>
                        <select class="form-control select2" name="bentuk_bu" id="bentuk_bu"
                            style="width: 100%;">
                            <option value="" selected>*Bentuk BU</option>
                            @foreach($bentukusaha as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('bentuk_bu') ? 'selected' : '' }}>
                                {{ $key->nama }} ({{$key->nama}})</option>
                            @endforeach
                        </select>
                    </div>

                    <span id="bentuk_bu" class="help-block customspan">{{ $errors->first('bentuk_bu') }}
                    </span>
                </div>
                {{-- Akhir Bentuk BU --}}
            </div>

            <div class="row">
                {{--  Status Kantor --}}
                <div class="col-sm-5">
                    <div class="input-group {{ $errors->first('status_kantor') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Status Kantor
                        </div>
                        <select class="form-control select2" name="status_kantor" id="status_kantor"
                            style="width: 100%;">
                            <option value="" disabled selected>*Status Kantor</option>
                            @foreach($statusmodel as $key)
                            <option value="{{ $key->id }}" urutan="{{ $key->urutan }}"
                                {{ $key->id == old('status_kantor') ? 'selected' : '' }}>
                                {{ $key->nama }} </option>
                            @endforeach
                        </select>
                    </div>

                    <span id="status_kantor" class="help-block customspan">{{ $errors->first('status_kantor') }}
                    </span>
                </div>
                {{-- Akhir Status Kantor --}}

                <div class="col-sm-2">
                </div>

                {{-- Kantor Atas --}}
                <div class="col-sm-5 {{ $errors->first('bu_atas') ? 'has-error' : '' }} ">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Kantor Level Atas
                        </div>
                        <select class="form-control select2" name="bu_atas" id="bu_atas"
                            style="width: 100%;">
                            <option value="" disabled selected>Kantor Level Atas</option>

                        </select>
                    </div>

                    <span id="bu_atas" class="help-block customspan">{{ $errors->first('id_bu_atasbu_atas') }}
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
                            placeholder="*Alamat Jalan, Kelurahan, Kecamatan" value="{{old('alamat')}}">
                    </div>
                    <span id="alamat"
                        class="help-block customspan">{{ $errors->first('alamat') }}
                    </span>
                </div>
                {{-- Akhir Alamat --}}
            </div>

            <div class="row">
                {{-- Provinsi --}}
                <div class="col-sm-5">
                    <div class="input-group {{ $errors->first('id_prop') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Provinsi BU
                        </div>
                            <select class="form-control select2" name="id_prop" id="id_prop" style="width: 100%;">
                            <option value="" disabled selected>*Provinsi BU</option>
                            @foreach($provinsi as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('id_prop') ? 'selected' : '' }}>
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
                    <div class="input-group {{ $errors->first('id_kota') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Kota BU
                        </div>
                        <select class="form-control select2" name="id_kota" id="id_kota" style="width: 100%;">
                            <option value="" disabled selected>*Kota BU</option>
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
                        placeholder="*No Tlp" value="{{old('telp')}}">
                    </div>
                    <span id="telp" class="help-block customspan">{{ $errors->first('telp') }}
                    </span>
                </div>
                {{-- Akhir No Telp --}}


                <div class="col-sm-2">

                </div>

                {{-- Email --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email
                        </div>
                        <input name="email" id="email" type="email" class="form-control" placeholder="Email"
                        value="{{old('email')}}">
                    </div>
                    <span id="email" class="help-block customspan">{{ $errors->first('email') }} </span>
                </div>
                {{-- Akhir Email --}}
            </div>

            <div class="row">
                {{-- Instansi Reff --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Instansi Reff
                        </div>
                        <input name="instansi_reff" id="instansi_reff" type="text" class="form-control"
                        placeholder="Instansi Reff" value="{{old('instansi_reff')}}">
                    </div>
                    <span id="instansi_reff" class="help-block customspan">{{ $errors->first('instansi_reff') }}
                    </span>
                </div>
                {{-- Akhir Instansi Reff --}}

                <div class="col-sm-2">
                </div>

                {{-- Web --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Web
                        </div>
                        <input name="web" id="web" type="text" class="form-control" placeholder="Web"
                        value="{{old('web')}}">
                    </div>
                    <span id="web" class="help-block customspan">{{ $errors->first('web') }} </span>
                </div>
                {{-- Akhir Web --}}
            </div>


            <div class="row">
                {{-- Nama Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Pimpinan
                        </div>
                        <select name="nama_pimp_select" id="nama_pimp_select" type="text" class="form-control select2"
                        placeholder="Nama Pimpinan" value="{{old('nama_pimp')}}">
                            <option value="" disabled selected>Nama Pimpinan</option>
                            @foreach($personal as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('nama_pimp') ? 'selected' : '' }}>
                                {{ $key->nama }} </option>
                            @endforeach
                        </select>
                        <input name="nama_pimp_text" id="nama_pimp_text" type="text" class="form-control"
                        placeholder="Nama Pimpinan" value="{{old('nama_pimp')}}" style="display:none">
                    </div>
                    <span id="nama_pimp" class="help-block customspan">{{ $errors->first('nama_pimp') }} </span>
                </div>
                {{-- Akhir Nama Pimpinan --}}

                <div class="col-sm-2">
                    <label for="isi_manual">
                        <input type="checkbox" name="isi_manual" id="isi_manual"> <span>Isi manual</span>
                    </label>
                </div>

                {{-- Jabatan Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Jabatan Pimpinan
                        </div>
                        <input name="jab_pimp" id="jab_pimp" type="text" class="form-control"
                        placeholder="Jabatan Pimpinan" value="{{old('jab_pimp')}}" readonly >
                    </div>
                    <span id="jab_pimp" class="help-block customspan">{{ $errors->first('jab_pimp') }} </span>
                </div>
                {{-- Akhir Jabatan Pimpinan --}}
            </div>


            <div class="row">
                {{-- No Hp Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            No Hp Pimpinan
                        </div>
                        <input name="hp_pimp" id="hp_pimp" type="text" class="form-control"
                        placeholder="No Hp Pimpinan" value="{{old('hp_pimp')}}" readonly>
                    </div>
                    <span id="hp_pimp" class="help-block customspan">{{ $errors->first('hp_pimp') }} </span>
                </div>
                {{-- Akhir No Hp Pimpinan --}}

                <div class="col-sm-2">
                </div>

                {{-- Email Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email Pimpinan
                        </div>
                        <input name="email_pimp" id="email_pimp" type="email" class="form-control"
                        placeholder="Email Pimpinan" value="{{old('email_pimp')}}" readonly >
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
                        placeholder="*Nama Kontak Person" value="{{old('kontak_p')}}">
                    </div>
                    <span id="kontak_p" class="help-block customspan">{{ $errors->first('kontak_p') }}
                    </span>
                </div>
                {{-- Akhir Nama Kontak Person --}}

                <div class="col-sm-2">
                </div>

                {{-- Jabatan Kontak Person --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Jabatan Kontak Person
                        </div>
                        <input name="jab_kontak_p" id="jab_kontak_p" type="text" class="form-control"
                        placeholder="Jabatan Kontak Person" value="{{old('jab_kontak_p')}}">
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
                        placeholder="*No HP Kontak Person" value="{{old('no_kontak_p')}}">
                    </div>
                    <span id="no_kontak_p" class="help-block customspan">{{ $errors->first('no_kontak_p') }} </span>
                </div>
                {{-- Akhir No Hp Kontak Person --}}

                <div class="col-sm-2">
                </div>

                {{-- Email Kontak Person --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email Kontak Person
                        </div>
                        <input name="email_kontak_p" id="email_kontak_p" type="email" class="form-control"
                        placeholder="Email Kontak Person" value="{{old('email_kontak_p')}}">
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
                        <input type="text"
                        id="npwp" name="npwp" class="form-control" placeholder="*No NPWP"
                        value="{{old('npwp') ? preg_replace("/[\.-]/", "",  old('npwp')) : ''}}">
                    </div>
                    <span id="npwp" class="help-block customspan">{{ $errors->first('npwpClean') }} </span>
                </div>
                {{-- Akhir No NPWP --}}

                <div class="col-sm-2">
                </div>

                {{-- File NPWP --}}
                <div class="col-sm-5" style="margin-bottom: -15px;">
                    <div class="input-group">
                        <div class="input-group-addon">
                            File NPWP
                        </div>
                        {{-- <div class="col-sm-6"> --}}
                            <input style="padding:2px" type="file" class="form-control" id="npwp_pdf"
                                name="npwp_pdf" placeholder="File NPWP">
                        {{-- </div> --}}
                        {{-- <label for="npwp_pdf" class="control-label"> File NPWP (.PDF)</label> --}}
                        <span id="npwp_pdf" class="help-block customspan"></span>
                    </div>
                </div>
                {{-- Akhir File NPWP --}}

                <!-- <div class="form-group row">
                    <label for="id_file_npwp" class="control-label">Upload File NPWP (.PDF)</label>
                </div> -->
            </div>


            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            No Rekening Bank
                        </div>
                        <input name="no_rek" id="no_rek" type="text" class="form-control"
                            placeholder="No Rekening Bank" value="{{old('no_rek')}}">
                    </div>
                    <span id="no_rek" class="help-block customspan">{{ $errors->first('no_rek') }}
                    </span>
                </div>

                <div class="col-sm-2">

                </div>

                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Rekening Bank
                        </div>
                        <input name="nama_rek" id="nama_rek" type="text" class="form-control"
                            placeholder="Nama Rekening Bank" value="{{old('nama_rek')}}">
                    </div>
                    <span id="nama_rek"
                        class="help-block customspan">{{ $errors->first('nama_rek') }}
                    </span>
                </div>
            </div>

            <div class="row">
                {{-- Nama Bank --}}
                <div class="col-sm-12">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Bank
                        </div>
                        <select class="form-control select2" name="id_bank" id="id_bank"
                            style="width: 100%;">
                            <option value="" disabled selected>Nama Bank</option>
                            @foreach($bank as $key)
                            <option value="{{ $key->id_bank }}"
                                {{ $key->id_bank == old('id_bank') ? 'selected' : '' }}> {{ $key->Nama_Bank }}
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
                <div class="col-sm-5 {{ $errors->first('logo') ? 'has-error' : '' }}" style="margin-bottom: -15px;">
                    <div class="input-group">
                        <div class="input-group-addon" style="vertical-align:top;">
                            Logo
                        </div>
                        <input style="padding:2px" type="file" class="form-control" id="logo" name="logo"
                            placeholder="File Logo">
                        <span id="logo" class="help-block customspan">{{ $errors->first('logo') }}</span>
                        <span style="color: #737373;">Format : jpg,jpeg,png</span>
                    </div>
                </div>
                {{-- Akhir Logo --}}
            </div>


            <div class="row" style="text-align:right">
                <div class="col-sm-12">
                    <span class="bintang"><b>*</b></span> Wajib Diisi
                </div>
            </div>

            <div class="box-footer" style="text-align:center">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- <a href="{{ url('badanusaha') }}" class="btn btn-md btn-danger"><i
                                            class="fa fa-times-circle"></i> Batal</a> -->
                        <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                            Simpan</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('instansi') }}" class="btn btn-md btn-default"><i class="fa fa-times-circle"></i>
                            Batal</a>
                        <!-- <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                        Simpan</button> -->
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div> {{-- Box-Content --}}
</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
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

        $('body').on('change', '.form-group', function() {
            // Action goes here.
        });
        $('#id_prop').select2(); // Select2
        $('#id_kota').select2(); // Select2
        $('#id_negara').select2(); // Select2
        $('#id_bank').select2(); // Select2 Bank
        $('#bentuk_bu').select2(); // Select2 Bank
        $('#status_kantor').select2(); // Select2 Bank
        $('#bu_atas').select2(); // Select2 Bank
        $('#nama_pimp_select').select2(); // Select2 Bank


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


        $('#npwp').mask("99.999.999.9-999.999",{placeholder:"Nomor Pokok Wajib Pajak"}).attr('maxlength','20');


        $('#status_kantor').on('select2:select', function () {
            changelevelatas();
        });

        function changelevelatas() {
            var url = "{{ url('instansi/changelevelatas') }}";
            var id_level_k = $("#status_kantor option:selected").attr("urutan"); // $("#status_kantor").attr('urutan');
            console.log(id_level_k);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_level_k: id_level_k
                },
                success: function (data) {
                    level =  $("#status_kantor option:selected").attr("urutan");
                    if (level != 1 && data.length <= 0) {
                        alert('Level atas belum terdaftar');
                        $('#status_kantor').val("").trigger('change.select2');
                        $("#bu_atas").html(
                            "<option value='' disabled selected>Kantor Level Diatasnya</option>"
                        );
                    } else {
                        $("#bu_atas").html(
                            "<option value='' disabled>Kantor Level Diatasnya</option>");
                        $("#bu_atas").select2({
                            data: data
                        }).val(null).trigger('change');
                        $('#bu_atas').val($('#bu_atas option:eq(1)').val()).trigger(
                            'change.select2');
                        // $('#timprodatas').select2("val", $('#timprodatas option:eq(1)').val());
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }
    });
</script>
@endpush
