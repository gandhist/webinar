@extends('templates.header')

@section('content')
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
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
        Edit TUK
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> TUK</a></li>
        <li class="active"><a href="#"> Edit</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            {{-- <div class="jumbotron" style='padding-top:1px'> --}}
                {{-- <h1 style="margin-bottom:50px;">Tempat Uji Kompetensi</h1> --}}
                <form method="POST" action="{{ url('tuk/update') }}" enctype="multipart/form-data" style="padding-top: 20px; padding-bottom: 20px;">
                @method('patch')
                @csrf

                    <div class="row">

                        {{-- Nama TUK --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('nama_tuk') ? 'has-error' : '' }}">
                                <label for="nama_tuk" class="label-control required">Nama TUK</label>
                                <input type="text" id="nama_tuk" class="form-control" name="nama_tuk"
                                placeholder="Nama Tempat Uji Kompetensi" required
                                value="{{ old('nama_tuk') ? old('nama_tuk') : $tuk->nama_tuk }}">
                                <div id="nama_tuk" class="invalid-feedback text-danger">
                                    {{ $errors->first('nama_tuk') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama TUK --}}

                    @if($tuk->is_online == '0')
                            {{-- Alamat TUK --}}
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('alamat') ? 'has-error' : '' }}">
                                    <label for="alamat" class="label-control required">Alamat</label>
                                    <input type="text" id="alamat" class="form-control" name="alamat"
                                    placeholder="Alamat Tempat Uji Kompetensi" required
                                    value="{{ old('alamat') ? old('alamat') : $tuk->alamat }}">
                                    <div id="alamat" class="invalid-feedback text-danger">
                                        {{ $errors->first('alamat') }}
                                    </div>
                                </div>
                            </div>
                            {{-- Akhir Nama TUK --}}

                        </div>
                    @else
                            {{-- Jenis --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_online" class="label-control required">Jenis TUK</label>
                                    <input type="text" id="is_online" class="form-control" name="is_online"
                                    placeholder="Jenis TUK" disabled
                                    value="{{ $tuk->is_online == '0' ? 'Online' : 'Offline' }}">
                                </div>
                            </div>
                            {{-- Akhir Jenis --}}
                        </div>
                    @endif


                    @if($tuk->is_online == '0')
                        <div class="row">

                            {{-- Provinsi --}}
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('provinsi') ? 'has-error' : '' }}">
                                    <label for="provinsi" class="label-control required">Provinsi</label>
                                    {{-- <select name="klasifikasi[]" multiple="multiple"
                                    id="klasifikasi" class="form-control"> --}}
                                    <select name="provinsi"  required
                                    id="provinsi" class="form-control">
                                        <option value="" selected hidden>Pilih Provinsi</option>
                                        @foreach ($provinsi as $key)
                                            <option value="{{$key->id}}"
                                            @if(old('provinsi'))
                                                {{ old('provinsi') == $key->id ? 'selected' : '' }}
                                            @else
                                                {{ $tuk->prov == $key->id ? 'selected' : '' }}
                                            @endif
                                            >
                                                {{$key->nama}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="provinsi" class="invalid-feedback text-danger">
                                        {{ $errors->first('provinsi') }}
                                    </div>
                                </div>
                            </div>
                            {{-- Akhir Provinsi --}}

                            {{-- Kota --}}
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('kota') ? 'has-error' : '' }}">
                                    <label for="kota" class="label-control required">Kota</label>
                                    {{-- <select name="klasifikasi[]" multiple="multiple"
                                    id="klasifikasi" class="form-control"> --}}
                                    <select name="kota"  required
                                    id="kota" class="form-control">
                                        <option value="" selected hidden>Pilih Kota</option>
                                        @foreach ($kota as $key)
                                            @if (old('provinsi'))
                                                @if (old('provinsi') == $key->provinsi_id)
                                                    <option value="{{$key->id}}"
                                                    {{ old('kota') == $key->id ? 'selected' : '' }}>
                                                        {{$key->nama}}
                                                    </option>
                                                @endif
                                            @else
                                                @if ($tuk->prov == $key->provinsi_id)
                                                    <option value="{{$key->id}}"
                                                    {{ $tuk->kota == $key->id ? 'selected' : '' }}>
                                                        {{$key->nama}}
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                    <div id="kota" class="invalid-feedback text-danger">
                                        {{ $errors->first('kota') }}
                                    </div>
                                </div>
                            </div>
                            {{-- Akhir Kota --}}

                        </div>
                    @endif

                    <div class="row">

                        {{-- Nama Pengelola --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('pengelola') ? 'has-error' : '' }}">
                                <label for="pengelola" class="label-control">Pengelola TUK</label>
                                <input type="text" id="pengelola" class="form-control" name="pengelola"
                                placeholder="Pengelola Tempat Uji Kompetensi"
                                value="{{ old('pengelola') ? old('pengelola') : $tuk->pengelola }}">
                                <div id="pengelola" class="invalid-feedback text-danger">
                                    {{ $errors->first('pengelola') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nama Pengelola --}}


                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                                <label for="email" class="label-control">Email</label>
                                <input type="email" id="email" class="form-control" name="email"
                                placeholder="Email"
                                value="{{ old('email') ? old('email') : $tuk->email }}">
                                <div id="email" class="invalid-feedback text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Email --}}

                    </div>

                    <div class="row">

                        {{-- Nomor Telepon --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('no_hp') ? 'has-error' : '' }}">
                                <label for="no_hp" class="label-control">Nomor Telepon</label>
                                <input type="text" id="pengelola" class="form-control" name="no_hp"
                                placeholder="Nomor Telepon"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('no_hp') ? old('no_hp') : $tuk->no_hp }}">
                                <div id="no_hp" class="invalid-feedback text-danger">
                                    {{ $errors->first('no_hp') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Nomor Telepon --}}


                        {{-- Website --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('website') ? 'has-error' : '' }}">
                                <label for="website" class="label-control">Website</label>
                                <input type="text" id="website" class="form-control" name="website"
                                placeholder="Website"
                                value="{{ old('website') ? old('website') : $tuk->web }}">
                                <div id="website" class="invalid-feedback text-danger">
                                    {{ $errors->first('website') }}
                                </div>
                            </div>
                        </div>
                        {{-- Akhir Website --}}

                    </div>

                    <input type="hidden" name="id" value="{{$id}}">

                    <button class="btn btn-success">Ubah</button>

                </form>
            {{-- </div> --}}
        </div>
    </div>
    <!-- END Default BOX -->
</section>
<!-- End MAIN -->
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            // Select2
            $('#provinsi').select2();
            $('#kota').select2();
            // End select2

            // OnChange Provinsi
            $('#provinsi').on('change', function(e) {
                $('select[name="kota"]').empty();
                let id = e.target.value;
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
            })
            // End OnChange Provinsi

        });
    </script>
@endpush
