@extends('templates.header')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Statistik Kegiatan PPKB
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Statistik</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">

        <div class="row" style="margin-top: 1rem">
            <div class="col-md-12" style="text-align: center">
                <h2>Tabel Blasting Kegiatan PPKB P3S Mandiri</h2>
            </div>
            <div class="col-md-12">
                <table id="pendaftar" class="cell-border" style="width:100%; background-color: #BCBCBC; border: 1px solid black;">
                    <thead>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu Blasting</th>
                        <th>Jumlah Target</th>
                        <th>Jumlah Dikirim</th>
                    </thead>
                    <tbody>
                        @foreach($blasting as $key)
                            <tr>
                                <td style='text-align:center;'>{{ $loop->iteration}}</td>
                                <td>{{$key->seminar->nama_seminar . " - " . \Carbon\Carbon::parse($key->seminar->tgl_awal)->format('d F Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($key->created_at)->format('d F Y H:i')}}</td>
                                <td>{{$key->jumlah_target}}</td>
                                <td>{{$key->jumlah_kirim}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div> {{-- Box-Content --}}
</section>



@endsection

@push('script')
<script type="text/javascript">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

$(document).ready(function () {
    //
});
</script>
@endpush
