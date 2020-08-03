@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    span.indent{
        text-indent: 25px;
    }
    .btn-bermargin {
        margin-left: 5px;
    }
</style>
<section class="content-header">
    <h1>
        Daftar Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="{{ url('/seminar') }}"> Seminar</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body" style="margin:25px;">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <div class="btn-group">
                            <span class="form-group">
                                <input type="text" style="padding-bottom:5px;" name="tgl_awal" id="tgl_awal">

                                <span style="margin: 10px;"> s/d </span>

                                <input type="text" style="padding-bottom:5px;" name="tgl_akhir" id="tgl_akhir">

                                <button class="btn btn-info btn-bermargin" id="btnFilter" name="btnFilter">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <button class="btn btn-success btn-bermargin" id="btnReset" name="btnReset">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </button>

                                {{-- https://datatables.net/examples/plug-ins/range_filtering.html --}}

                            </span>
                        </div>
                        <button type="button" class="btn btn-primary pull-right" id="btnDetail" name="btnDetail">
                            <i class="fa fa-eye"></i> Detail</button>
                    </div>
                    <div class="col-12" style="margin-top:10px">
                        <div class="pull-right">

                            <a href="{{ url('seminar/create') }}" class="btn btn-info">
                                <i class="fa fa-plus"></i> Tambah</a>
                            <button class="btn btn-success" id="btnEdit" name="btnEdit">
                                <i class="fa fa-edit"></i> Ubah</button>
                            <button type="button" class="btn btn-danger" id="btnHapus" name="btnHapus">
                                <i class="fa fa-trash"></i> Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if(session()->get('pesan'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session()->get('pesan') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                            <thead>
                                <tr>
                                    <th><span class="indent"><i class="fa fa-check-square-o"></i></span></th>
                                    <th><span class="indent">No</th>
                                    <th><span class="indent">Title</th>
                                    <th><span class="indent">Tema</th>
                                    <th><span class="indent">Tanggal</th>
                                    <th><span class="indent">Jml_Daftar</th>
                                    <th><span class="indent">Jml_Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($seminar as $key)
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                            id="selection[]" name="selection[]"></td>
                                    <td style='text-align:center'>{{ $loop->iteration }}</td>
                                    <td>{{ $key->nama_seminar }}</td>
                                    <td>{{ strip_tags(html_entity_decode($key->tema)) }}</td>
                                    <td>{{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }}</td>
                                    <td style='text-align:center'>{{ $key->seminar_r->count() }} Peserta</td>
                                    <td style='text-align:center'>@if ($key->is_free == '0') Gratis @else Rp {{ format_uang($key->biaya)}} @endif</td>
                                    <td>
                                        @if($key->is_actived == "0")
                                            <button type="submit" class="btn btn-success">
                                                <a href="{{url('seminar/'.$key->id.'/publish')}}" style="color:white">
                                                    Publish
                                                </a>
                                            </button>
                                        @else
                                            {{" "}}
                                        @endif
                                        {{-- <a target="_blank" href="{{ url('seminar/detail', $key->id) }}"> Lihat Peserta</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</section>

{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('seminar/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
        method="post" enctype="multipart/form-data">
        @method("DELETE")
        @csrf
        <input type="hidden" value="" name="idHapusData" id="idHapusData">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                </div>
                <div class="modal-body" id="konfirmasi-body">
                    Yakin ingin menghapus data terpilih?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" data-id=""
                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Deleting..."
                        id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- end of modal konfirmasi hapus --}}

@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">

    $("#tgl_awal").datepicker();
    $("#tgl_akhir").datepicker();
    $('#btnHapus').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idHapusData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            // Swal.fire('Tidak ada data yang terpilih');
            } else {
                $('#modal-konfirmasi').modal('show');
            }
    });
    // BtnFIlterOnclick
    $('#btnFilter').on('click', function () {
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#tgl_awal').datepicker("getDate");
                var max = $('#tgl_akhir').datepicker("getDate");

                // need to change str order before making  date obect since it uses a new Date("mm/dd/yyyy") format for short date.
                var d = data[4].split(" ");
                if(d[1] != null) {d[1] = moment().month(d[1]).format("M");}
                // var startDate = new Date(d[1]+ "/" +  d[0] +"/" + d[2]);
                var startDate = new Date(d[2],d[1]-1,d[0]);

                if (min == null && max == null) { return true; }
                if (min == null && startDate <= max) { return true;}
                if(max == null && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            });


            $("#tgl_awal").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , dateFormat:"dd/mm/yy"});
            $("#tgl_akhir").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, dateFormat:"dd/mm/yy" });
            var table = $('#data-tables').DataTable();


            // Event listener to the two range filtering inputs to redraw on input
            // $('#tgl_awal, #tgl_akhir').change(function () {
            //     table.draw();
            // });
        table.draw();
    });

    // Button edit click
    $('#btnReset').on('click', function (e) {
        e.preventDefault();
        var table = $('#data-tables').DataTable();
        $.fn.dataTable.ext.search.pop();
        table.search('').columns().search('').draw();
    });


    // Button edit click
    $('#btnEdit').on('click', function (e) {
        e.preventDefault();
        var id = [];
        $('.selection:checked').each(function () {
            id.push($(this).data('id'));
        });
        if (id.length == 0) {
            Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
        } else if (id.length > 1) {
            Swal.fire({
                    title: "Harap pilih satu data untuk di ubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
        } else {
            url = id[0];
            window.location.href = "{{ url('seminar') }}/" + url + "/edit";
        }
    });

    // Button Detail click
    $('#btnDetail').on('click', function (e) {
        e.preventDefault();
        var id = [];
        $('.selection:checked').each(function () {
            id.push($(this).data('id'));
        });
        if (id.length == 0) {
            Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
        } else if (id.length > 1) {
            Swal.fire({
                    title: "Harap pilih satu data untuk di tampilkan",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
        } else {
            url = id[0];
            window.location.href = "{{ url('seminar/detail') }}/" + url ;
        }
    });
</script>
@endpush
