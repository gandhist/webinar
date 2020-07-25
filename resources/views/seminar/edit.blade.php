@extends('templates.header')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Tambahkan Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron">
                <h1 style="margin-bottom:50px;">Seminar</h1>

                <form method="POST" action="{{ url('seminar/store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Nama Seminar --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('nama_seminar') ? 'has-error' : '' }}">
                            <label for="nama_seminar" class="label-control required">Nama Seminar</label>
                            <input type="text" id="nama_seminar" class="form-control" name="nama_seminar"
                            placeholder="Nama Seminar"
                            value="{{ old('nama_seminar') ? old('nama_seminar') : '' }}">
                            <div id="nama_seminar" class="invalid-feedback text-danger">
                                {{ $errors->first('nama_seminar') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Nama Seminar --}}


                    {{-- Klasifikasi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('klasifikasi') ? 'has-error' : '' }}">
                            <label for="klasifikasi" class="label-control required">Klasifikasi</label>
                            <select name="klasifikasi[]" multiple="multiple"
                            id="klasifikasi" class="form-control">
                                <option value="a">A</option>
                                <option value="b">B</option>
                            </select>
                            <div id="klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('klasifikasi') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Klasifikasi --}}

                    {{-- Sub Klasifikasi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('sub_klasifikasi') ? 'has-error' : '' }}">
                            <label for="sub_klasifikasi" class="label-control required">Sub-klasifikasi</label>
                            <select name="sub_klasifikasi[]" multiple="multiple"
                            id="sub_klasifikasi" class="form-control">
                                <option value="a">A</option>
                                <option value="b">B</option>
                            </select>
                            <div id="sub_klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('sub_klasifikasi') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Sub Klasifikasi --}}

                </div>
                    
                <div class="row">
                    {{--Tema --}}
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->first('tema') ? 'has-error' : '' }}">
                            <label for="tema" class="label-control required">Tema Seminar</label>
                            <textarea name="tema" class="form-control" id="tema"></textarea>
                            <div id="tema" class="invalid-feedback text-danger">
                                {{ $errors->first('tema') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Tema --}}
                </div>

                <div class="row">

                    {{-- Kuota Peserta --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('kuota') ? 'has-error' : '' }} ">
                            <label for="kuota" class="label-control required">Kuota Peserta</label>
                            <input type="text" class="form-control" name="kuota" id="kuota"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('kuota') }}"
                                placeholder="Kuota Peserta">
                            <div id="kuota" class="invalid-feedback text-danger">
                                {{ $errors->first('kuota') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Kuota Peserta --}}

                    {{-- Nilai SKPK --}}
                    <div class="col-md-1">
                        <div class="form-group {{ $errors->first('skpk_nilai') ? 'has-error' : '' }} ">
                            <label for="skpk_nilai" class="label-control required">Nilai SKPK</label>
                            <input type="text" class="form-control" name="skpk_nilai" id="skpk_nilai"
                                maxlength="2"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('skpk_nilai') }}"
                                placeholder="Nilai SKPK">
                            <div id="skpk_nilai" class="invalid-feedback text-danger">
                                {{ $errors->first('skpk_nilai') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Nilai SKPK --}}

                    {{-- Berbayar --}}
                    <div class="col-md-1">
                        <div class="form-group {{ $errors->first('is_free') ? 'has-error' : '' }} ">
                            <label for="is-free" class="label-control required">Jenis</label>
                            <div class="radio" style="margin-top:-5px;">
                                <label>
                                    <input type="radio" name="is_free" id="gratis" value="0"
                                        {{ old('is_free') == "0" ? "checked" : "" }} required>
                                    Gratis
                                </label>
                                <label>
                                    <input type="radio" name="is_free" id="bayar" value="1" 
                                        {{ old('is_free') == "0" ? "checked" : "" }}>
                                    Berbayar
                                </label>
                                
                                <div id="is_free" class="invalid-feedback text-danger">
                                    {{ $errors->first('is_free') }}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    {{-- Akhir Berbayar --}}

                    {{-- Biaya --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('biaya') ? 'has-error' : '' }} ">
                            <label for="biaya" class="label-control required">Biaya</label>
                            <input type="text" class="form-control" name="biaya" id="biaya"
                                onkeypress="return /[0-9]/i.test(event.key)"
                                value="{{ old('biaya') }}"
                                placeholder="Biaya">
                            <div id="biaya" class="invalid-feedback text-danger">
                                {{ $errors->first('biaya') }}
                            </div>
                        </div>
                    </div>
                    {{-- Biaya --}}

                    {{-- Inisiator Penyelengara --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('inisiator') ? 'has-error' : '' }} ">
                            <label for="inisiator" class="label-control required">Inisiator Penyelenggara</label>
                            <select name="inisiator" id="inisiator" class="form-control" multiple>
                                <option></option>
                                @foreach($inisiator as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                @endforeach
                            </select>
                            <div id="inisiator" class="invalid-feedback text-danger">
                                {{ $errors->first('inisiator') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Inisiator Penyelengara --}}

                    {{-- Instansi Penyelengara --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                            <label for="instansi_penyelenggara" class="label-control required">Instansi Penyelengara</label>
                            <select name="instansi_penyelenggara[]" id="instansi_penyelenggara"
                            class="form-control" multiple>
                                @foreach($instansi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama_bu }}</option>
                                @endforeach
                            </select>
                            <div id="instansi_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('instansi_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Instansi Penyelengara --}}

                    {{-- Instansi Pendukung --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('instansi_pendukung') ? 'has-error' : '' }} ">
                            <label for="instansi_pendukung" class="label-control required">Instansi Pendukung</label>
                            <select name="instansi_pendukung[]" id="instansi_pendukung"
                            class="form-control" multiple>
                                @foreach($instansi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama_bu }}</option>
                                @endforeach
                            </select>
                            <div id="instansi_pendukung" class="invalid-feedback text-danger">
                                {{ $errors->first('instansi_pendukung') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Instansi Pendukung --}}

                </div>


                <div class="row">
                    {{-- Tanggal Mulai --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('tgl_awal') ? 'has-error' : '' }} ">
                            <label for="tgl_awal" class="label-control required">Tanggal Awal</label>
                            <input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('tgl_awal') }}"
                                placeholder=" DD/MM/YYYY">
                            <div id="tgl_awal" class="invalid-feedback text-danger">
                                {{ $errors->first('tgl_awal') }}
                            </div>
                        </div>
                    </div>
                    {{-- Tanggal Mulai --}}

                    {{-- Tanggal Akhir --}}
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->first('tgl_akhir') ? 'has-error' : '' }} ">
                            <label for="tgl_akhir" class="label-control required">Tanggal Akhir</label>
                            <input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('tgl_akhir') }}"
                                placeholder=" DD/MM/YYYY">
                            <div id="tgl_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('tgl_akhir') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Tanggal Akhir --}}

                    {{-- Jam Awal --}}
                    <div class="col-md-1">
                        <div class="form-group input-group {{ $errors->first('jam_awal') ? 'has-error' : '' }} ">
                            <label for="jam_awal" class="label-control required">Jam Awal</label>
                            <input type="text" class="form-control timepicker" name="jam_awal" id="jam_awal"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('jam_awal') }}"
                                placeholder=" 00:00">
                            <div id="tgl_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('jam_awal') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jam Awal --}}

                    {{-- Jam Awal --}}
                    <div class="col-md-1">
                        <div class="form-group {{ $errors->first('jam_akhir') ? 'has-error' : '' }} ">
                            <label for="jam_akhir" class="label-control required">Jam Akhir</label>
                            <input type="text" class="form-control timepicker" name="jam_akhir" id="jam_akhir"
                                onkeypress="return /[0-9\-]/i.test(event.key)"
                                value="{{ old('jam_akhir') }}"
                                placeholder=" 00:00">
                            <div id="jam_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('jam_akhir') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Jam Awal --}}

                    {{-- Tanda Tangan --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('ttd_pemangku') ? 'has-error' : '' }}">
                            <label for="ttd_pemangku" class="label-control required">Tanda Tangan Pemangku</label>
                            <select name="ttd_pemangku[]" multiple="multiple" class="form-control" id="ttd_pemangku">
                                    @foreach($provinsi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                            </select>
                            <div id="ttd_pemangku" class="invalid-feedback text-danger">
                                {{ $errors->first('ttd_pemangku') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Tanda Tangan --}}
                </div>

                <div class="row">
                    {{-- Provinsi --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('prov_penyelenggara') ? 'has-error' : '' }}"">
                            <label for="prov_penyelenggara" class="label-control required">Provinsi Penyelengara</label>
                            <select name="prov_penyelenggara" required
                            id="prov_penyelenggara" class="form-control">
                                @if(old('prov_penyelenggara'))
                                    @foreach($provinsi as $key)
                                        <option value="{{ $key->id }}" {{ old('prov_penyelenggara') == $key->id ? "selected" : "" }}
                                            >{{$key->nama}}</option>
                                    @endforeach
                                @else
                                    <option value="" selected hidden></option>
                                    @foreach($provinsi as $key)
                                        <option value="{{ $key->id }}">{{$key->nama}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div id="prov_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('prov_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Provinsi --}}

                    {{-- Kota --}}
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('kota_penyelenggara') ? 'has-error' : '' }} ">
                            <label for="kota_penyelenggara" class="label-control required">Kota Penyelenggara</label>
                            <select name="kota_penyelenggara" required
                            id="kota_penyelenggara" class="form-control">
                                @if(old('prov_penyelenggara'))
                                    @foreach($kota as $key)
                                        @if($key->provinsi_id == old('prov_penyelenggara'))
                                        <option value="{{ $key->id }}" 
                                        {{ old('kota_penyelenggara') == $key->id ? "selected" : "" }}
                                            >{{$key->nama}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" selected hidden></option>
                                @endif
                                
                            </select>
                            <div id="kota_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('kota_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Kota --}}

                    {{-- Alamat --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('lokasi_penyelenggara') ? 'has-error' : '' }}">
                            <label for="lokasi_penyelenggara" class="label-control required">Alamat Penyelenggara</label>
                            <input type="text" id="lokasi_penyelenggara" class="form-control"
                            placeholder="Alamat"
                            value="{{ old('alamat') ? old('lokasi_penyelenggara') : '' }}">
                            <div id="lokasi_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('lokasi_penyelenggara') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Alamat --}}
                </div>



                <button class="btn btn-success">Publish</button>
                <button class="btn btn-info pull-right">Save</button>
                </form>          
            </div> {{-- Jumbotron --}}
        </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
</section>

@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>  --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
<script>
    let instansi = {!! json_encode($pendukung->toArray()) !!};
    let tema = $('#tema');
    CKEDITOR.replace('tema');

    $(document).ready(function () {
        $('.timepicker').datetimepicker({

            format: 'HH:mm'

        }); 
        $('body').on('change', '.form-group', function() {
            // Action goes here.
        });
        $('#prov_penyelenggara').select2({
            placeholder: " Pilih Provinsi"
        }); // Select2 Provinsi
        $('#instansi').select2(); // Select2 instansi
        $('#kota_penyelenggara').select2({
            placeholder: " Pilih Kota"
        }); // Select2 Kota
        $('#klasifikasi').select2({
            placeholder: " Pilih Klasifikasi",
            allowClear: true
        }); // Select2 Klasifikasi
        $('#sub_klasifikasi').select2({
            placeholder: " Pilih Sub-klasifikasi", 
            allowClear: true
        }); // Select2 Sub-Klasifikasi
        $('#inisiator').select2({
            placeholder: " Pilih Inisiator Penyelenggara ",
        }); // Select2 Inisiator Penyelenggara
        $('#instansi_penyelenggara').select2({
            placeholder: " Pilih Instansi Penyelenggara",
            allowClear: true
        }); // Select2 Instansi Penyelenggara
        $('#instansi_pendukung').select2({
            placeholder: " Pilih Instansi Pendukung",
            allowClear: true
        }); // Select2 Instansi Pendukung
        $('#ttd_pemangku').select2({
            placeholder: " Pilih Tanda Tangan Pemangku",
            allowClear: true
        }); // Select2 Instansi Pendukung
        
        

        

        // Ajax Untuk Kota, Onchange Provinsi
        $('#prov_penyelenggara').on('change', function(e){
            $('select[name="kota_penyelenggara"]').empty();
            var id = e.target.value;
            //
            if(id) {
                $.ajax({
                    url: '/seminar/create/getKota/'+id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="kota_penyelenggara"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kota_penyelenggara"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="kota_penyelenggara"]').empty();
            }

            //
            $('#kota_penyelenggara').select2();
        });

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('.datepicker').timepicker();
        
        $('.datepicker').mask('00/00/0000');

    });
</script>
@endpush