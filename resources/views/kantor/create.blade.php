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
        /* border-color: #aaaaaa; */
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
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tambah Kantor P3S Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Kantor</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-content">
        <div class="box-body">
            <form method="POST" action="{{ url('kantor/store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Nama Kantor --}}
                <div class="col-sm-5 {{ $errors->first('nama_kantor') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Nama Kantor
                        </div>
                        <input name="nama_kantor" id="nama_kantor" class="form-control"
                            placeholder="*Nama Kantor" value="{{old('nama_kantor')}}">
                    </div>
                    <span id="nama_kantor"
                        class="help-block customspan">{{ $errors->first('nama_kantor') }}
                    </span>
                </div>
                {{-- Akhir Nama Kantor --}}

                <div class="col-sm-2">
                </div>

                <div class="col-sm-5 {{ $errors->first('nama_singkat') ? 'has-error' : '' }}">
                    {{-- Nama Singkat --}}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Singkat Nama Kantor
                        </div>
                        <input name="nama_singkat" id="nama_singkat" class="form-control"
                            placeholder="*Singkat Nama Kantor" value="{{old('nama_singkat')}}">
                    </div>

                    <span id="nama_singkat"
                        class="help-block customspan">{{ $errors->first('nama_singkat') }} </span>
                </div>
                {{-- Akhir Nama Singkat --}}
            </div>
            <div class="row">
                <div class="col-sm-5">
                    {{-- Level --}}
                    <div
                        class="input-group {{ $errors->first('level') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Level Kantor
                        </div>
                        <select class="form-control select2" name="level" id="level"
                            style="width: 100%;">
                            <option value="" disabled selected>*Level Kantor</option>
                            @foreach($level as $key)
                            <option value="{{ $key->id }}"
                                {{ $key->id == old('level') ? 'selected' : '' }}>
                                {{ $key->nama_level }} </option>
                            @endforeach
                        </select>
                    </div>
                    <span id="level" class="help-block customspan">{{ $errors->first('level') }}
                    </span>
                </div>
                {{-- Akhir Level --}}

                {{-- <div class="col-sm-5 {{ $errors->first('id_level_k') ? 'has-error has-error-select' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Level Kantor
                        </div>
                        <select class="form-control select2" name="id_level_k" id="id_level_k"
                            style="width: 100%;">
                            <option value="" disabled selected>Level_K</option>
                            @foreach($level as $key)
                            <option value="{{ $key->id }}"
                                {{ $key->id == old('id_level_k') ? 'selected' : '' }}>
                                {{ $key->nama_level }} </option>
                            @endforeach
                        </select>
                    </div>

                    <span id="id_level_k" class="help-block customspan">{{ $errors->first('id_level_k') }}
                    </span>
                </div> --}}

                <div class="col-sm-2">
                </div>

                {{-- Level Kantor Di atasnya --}}
                <div class="col-sm-5 {{ $errors->first('level_atas') ? 'has-error has-error-select' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Kantor Level Diatasnya
                        </div>
                        <select class="form-control select2" name="level_atas" id="level_atas"
                            style="width: 100%;">
                            <option value="" disabled selected>Kantor Level Diatasnya</option>
                        </select>
                    </div>
                    <span id="level_atas" class="help-block customspan">{{ $errors->first('level_atas') }}
                    </span>
                </div>
                {{-- Akhir Level Kantor Di atasnya --}}
            </div>
            <div class="row">
                <div class="col-sm-12 {{ $errors->first('alamat') ? 'has-error' : '' }} ">
                    {{-- Alamat --}}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Alamat
                        </div>
                        <input name="alamat" id="alamat" class="form-control"
                            placeholder="*Alamat Jalan, Kelurahan, Kecamatan" value="{{old('alamat')}}">
                    </div>
                    <span id="alamat" class="help-block customspan">{{ $errors->first('alamat') }}
                    </span>
                    {{-- Akhir Alamat --}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    {{-- Provinsi --}}
                    <div
                        class="input-group {{ $errors->first('prop') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Provinsi
                        </div>
                        <select class="form-control select2" name="prop" id="prop" style="width: 100%;">
                            <option value="" disabled selected>*Provinsi</option>
                            @foreach($prop as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('prop') ? 'selected' : '' }}>
                                {{ $key->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <span id="prop" class="help-block customspan">{{ $errors->first('prop') }}
                    </span>
                    {{-- Akhir Provinsi --}}
                </div>

                <div class="col-sm-2">
                </div>

                <div class="col-sm-5">
                    {{-- Kota --}}
                    <div
                        class="input-group {{ $errors->first('kota') ? 'has-error has-error-select' : '' }}">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Kota
                        </div>
                        <select class="form-control select2" name="kota" id="kota" style="width: 100%;">
                            <option value="" disabled selected>*Kota</option>
                        </select>
                    </div>
                    <span id="kota" class="help-block customspan">{{ $errors->first('kota') }}
                    </span>
                    {{-- Akhir Kota --}}
                </div>
            </div>
            <div class="row">
                {{-- No Telp --}}
                <div class="col-sm-5 {{ $errors->first('no_tlp') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> No Tlp
                        </div>
                        <input name="no_tlp" id="no_tlp" type="text" class="form-control"
                            placeholder="*No Tlp" value="{{old('no_tlp')}}">
                    </div>
                    <span id="no_tlp" class="help-block customspan">{{ $errors->first('no_tlp') }}
                    </span>
                </div>
                {{-- Akhir No Telp --}}

                <div class="col-sm-2">
                </div>

                {{-- Email --}}
                <div class="col-sm-5 {{ $errors->first('email') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Email
                        </div>
                        <input name="email" id="email" type="email" class="form-control"
                            placeholder="*Email" value="{{old('email')}}">
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

                {{-- Website --}}
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
                {{-- Akhir Website --}}
            </div>
            <div class="row">
                {{-- Nama Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Nama Pimpinan
                        </div>
                        <input name="nama_pimp" id="nama_pimp" type="text" class="form-control"
                            placeholder="Nama Pimpinan" value="{{old('nama_pimp')}}">
                    </div>
                    <span id="nama_pimp" class="help-block customspan">{{ $errors->first('nama_pimp') }} </span>
                </div>
                {{-- Akhir Nama Pimpinan --}}

                <div class="col-sm-2">
                </div>

                {{-- Jabatan Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Jabatan Pimpinan
                        </div>
                        <input name="jab_pimp" id="jab_pimp" type="text" class="form-control"
                            placeholder="Jabatan Pimpinan" value="{{old('jab_pimp')}}">
                    </div>
                    <span id="jab_pimp" class="help-block customspan">{{ $errors->first('jab_pimp') }} </span>
                </div>
                {{-- Akhir Jabatan Pimpinan --}}
            </div>
            <div class="row">
                {{-- Nomor Telepon Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            No Hp Pimpinan
                        </div>
                        <input name="hp_pimp" id="hp_pimp" type="text" class="form-control"
                            placeholder="No Hp Pimpinan" value="{{old('hp_pimp')}}">
                    </div>
                    <span id="hp_pimp" class="help-block customspan">{{ $errors->first('hp_pimp') }} </span>
                </div>
                {{-- Akhir Nomor Telepon Pimpinan --}}

                <div class="col-sm-2">
                </div>

                {{-- Email Pimpinan --}}
                <div class="col-sm-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            Email Pimpinan
                        </div>
                        <input name="email_pimp" id="email_pimp" type="email" class="form-control"
                            placeholder="Email Pimpinan" value="{{old('email_pimp')}}">
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
                {{-- Nomor Telepon Kontak Person --}}
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
                {{-- Akhir Nomor Telepon Kontak Person --}}

                <div class="col-sm-2">
                </div>

                {{-- Email Kontak Person --}}
                <div class="col-sm-5 {{ $errors->first('email_kontak_p') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="bintang">*</span> Email Kontak Person
                        </div>
                        <input name="email_kontak_p" id="email_kontak_p" type="email" class="form-control"
                            placeholder="*Email Kontak Person" value="{{old('email_kontak_p')}}">
                    </div>
                    <span id="email_kontak_p" class="help-block customspan">{{ $errors->first('email_kontak_p') }}
                    </span>
                </div>
                {{-- Akhir Email Kontak Person --}}
            </div>
            <div class="row">
                {{-- Keterangan --}}
                    <div class="col-sm-12 {{ $errors->first('keterangan') ? 'has-error' : '' }} ">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Keterangan
                            </div>
                            <input name="keterangan" id="keterangan" class="form-control"
                                placeholder="Keterangan" value="{{old('keterangan')}}">
                        </div>
                        <span id="keterangan" class="help-block customspan">{{ $errors->first('keterangan') }}
                        </span>
                    </div>
                {{-- Akhir Keterangan --}}
            </div>

            <div class="row" style="text-align:right">
                <div class="col-sm-12">
                    <span class="bintang"><b>*</b></span> Wajib Diisi
                </div>
            </div>

            <!-- End Detail -->
            <div class="box-footer" style="text-align:center">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                            Simpan</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('kantor') }}" class="btn btn-md btn-default"><i
                                class="fa fa-times-circle"></i>
                            Batal</a>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">

                </div>
            </div> --}}
            </form>
        </div> {{-- Box Body --}}
    </div> {{-- Box Content --}}
</section>

@endsection

@push('script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    //Initialize Select2 Elements
    $('.select2').select2();


    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });


    // Ajax Untuk Kota, Onchange Provinsi
    $('#prop').on('change', function(e){
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


    $('#level').on('select2:select', function () {
        changelevelatas();
    });

    function changelevelatas() {
        var url = "{{ url('kantor/changelevelatas') }}";
        var id_level_k = $("#level").val();
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
                level = $('#level').val();
                if (level != 1 && data.length <= 0) {
                    alert('Level atas belum terdaftar');
                    $('#level').val("").trigger('change.select2');
                    $("#level_atas").html(
                        "<option value='' disabled selected>Kantor Level Diatasnya</option>"
                    );
                } else {
                    $("#level_atas").html(
                        "<option value='' disabled>Kantor Level Diatasnya</option>");
                    $("#level_atas").select2({
                        data: data
                    }).val(null).trigger('change');
                    $('#level_atas').val($('#level_atas option:eq(1)').val()).trigger(
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
