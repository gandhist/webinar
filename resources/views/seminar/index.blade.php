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
    a { color: inherit; }
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
                                    <td style='text-align:center'>{{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }}</td>
                                    <td style='text-align:center'>{{ $key->seminar_r->count() }} Peserta</td>
                                    <td style='text-align:center'>@if ($key->is_free == '0') Gratis @else {{$key->seminar_paid->count()}} Peserta @endif</td>
                                    <td>
                                        @if($key->is_actived == "0")
                                            <button type="submit" class="btn btn-success">
                                                <a href="{{url('seminar/'.$key->id.'/publish')}}" style="color:white">
                                                    Publish
                                                </a>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-info">
                                                <a data-toggle="modal" data-target="#myModal"  data-link="{{isset($key->qr_code) ? url($key->qr_code) : 'not-set' }}"
                                                data-filename="{{'QR_Code-'.$key->id.'-'.$key->nama_seminar}}">
                                                    QR Code
                                                </a>
                                            </button>
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">QR Code Seminar</h4>
        </div>
        <div class="modal-body">
            <center>
            <img alt="QR Code Seminar" class="img-thumbnail center" style="width:50%">
          </center>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="qrBtn"><a href="" class="download-link" download="">Download</a></button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

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
    $('#myModal').on('show.bs.modal', function(e) {
        let link = $(e.relatedTarget).data('link');
        let filename = $(e.relatedTarget).data('filename');
        // console.log(link);
        $(e.currentTarget).find('img').attr('src',link);
        $(e.currentTarget).find('img').on('error', function() {
            $(e.currentTarget).find('#qrBtn').hide();
        }).on('load', function() {
            $(e.currentTarget).find('.download-link').attr('href',link).attr('download',filename);
            $(e.currentTarget).find('#qrBtn').show();
        });
    });

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
        // var table = $('#data-tables').DataTable();
        // $.fn.dataTable.ext.search.pop();
        // table.search('').columns().search('').draw();
        window.location.href = "{{ url('seminar') }}";
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
