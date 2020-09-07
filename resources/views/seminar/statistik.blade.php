@extends('templates.header')

@section('content')

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Statistik Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron"  style='padding-top:15px'>
                <div class="btn-group">
                    <span class="form-group">
                        <input type="text" style="padding-bottom:5px;" name="tgl_awal" id="tgl_awal" value="{{ request()->get('tgl_awal') }}" placeholder="Tanggal Awal">

                        <span style="margin: 10px;"> s/d </span>

                        <input type="text" style="padding-bottom:5px;" name="tgl_akhir" id="tgl_akhir" value="{{ request()->get('tgl_akhir') }}" placeholder="Tanggal Akhir">

                        <button class="btn btn-info btn-bermargin" id="btnFilter" name="btnFilter">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button class="btn btn-success btn-bermargin" id="btnReset" name="btnReset">
                        <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                        </button>
                        {{-- <a href="{{ url('seminar') }}" class="btn btn-sm btn-default"> <i
                            class="fa fa-refresh"></i>
                        Reset</a> --}}

                        {{-- https://datatables.net/examples/plug-ins/range_filtering.html --}}

                    </span>
                </div>
                
            </div> {{-- Jumbotron --}}
      </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}

</section>

@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $("#tgl_awal").datepicker();
    $("#tgl_akhir").datepicker();

    // Cache Warna Filter
    if ("{{request()->get('tgl_awal')}}" != "") {
            inputFilterCache("tgl_awal");
        }
        if ("{{request()->get('tgl_akhir')}}" != "") {
            inputFilterCache("tgl_akhir");
    }

    // Rubah Warna Filter
    inputFilter("tgl_awal");
    inputFilter("tgl_akhir");

    // Fungsi Rubah warna filter
    function inputFilter(name) {
        $('#' + name).on('change', function () {
            idfilter = $(this).attr('id');
            if ($(this).val() == '') {
                $(this).css('background-color', 'transparent');
                $(this).css('font-weight', 'unset');
            } else {
                $(this).css('background-color', '#b6f38f');
                $(this).css('font-weight', 'bold');
            }
        });
    }

    // Fungsi merubah Cache warna filter input biasa
    function inputFilterCache(name){
        $('#'+name).css('background-color', '#b6f38f');
        $('#'+name).css('font-weight', 'bold');
    }

</script>
@endpush
