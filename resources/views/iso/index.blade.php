@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Daftar Sertifikat ISO
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> ISO</a></li>
    </ol>

</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}  
            </div>
            <br />
            @endif
            {{-- form filter --}}
            <form action="{{ url('isos/index') }}" enctype="multipart/form-data" name="filterData"
            id="filterData" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <!-- Table Filter -->
                    {{-- <table class="table table-condensed table-filter">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon customInput">Tgl Terbit SKP</span>
                                        <input id="f_awal_terbit" name="f_awal_terbit"
                                            value="{{ request()->get('f_awal_terbit') }}" autocomplete="off"
                                            data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                            class="form-control customInput" placeholder="Tgl Awal">
                                        <span class="input-group-addon customInput">s/d</span>
                                        <input id="f_akhir_terbit" name="f_akhir_terbit"
                                            value="{{ request()->get('f_akhir_terbit') }}" autocomplete="off"
                                            data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                            class="form-control customInput" placeholder="Tgl Akhir">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group customSelect2md">
                                        <select class="form-control select2" name="f_jenis_usaha"
                                            id="f_jenis_usaha">
                                            <option selected value="">Jenis Usaha</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group customSelect2md">
                                        <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                            <option selected value="">PJK3</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group customSelect2md">
                                        <select class="form-control select2" name="f_instansi" id="f_instansi">
                                            <option selected value="">Instansi_Reff</option>
                                        </select>
                                    </div>
                                </td>
                                <td style="padding-right: 0px">
                                    <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                        Filter</button>
                                </td>
                                <td style="padding-left: 0px">
                                    <a href="{{ url('daftarpjk3') }}" class="btn btn-sm btn-default"> <i
                                            class="fa fa-refresh"></i>
                                        Reset</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon customInput">Tgl Akhir SKP &nbsp;</span>
                                        <input id="f_awal_akhir" name="f_awal_akhir"
                                            value="{{ request()->get('f_awal_akhir') }}" autocomplete="off"
                                            data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                            class="form-control customInput" placeholder="Tgl Awal">
                                        <span class="input-group-addon customInput">s/d</span>
                                        <input id="f_akhir_akhir" name="f_akhir_akhir"
                                            value="{{ request()->get('f_akhir_akhir') }}" autocomplete="off"
                                            data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                            class="form-control customInput" placeholder="Tgl Akhir">
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group customSelect2md">
                                        <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                            <option value="">Provinsi PJK3</option>
                                        </select>
                                    </div>
                              </td>

                                <td>
                                    <div class="input-group customSelect2md">
                                        <select class="form-control select2" name="f_bidang" id="f_bidang">
                                            <option selected value="">Bidang</option>
                                        </select>
                                    </div>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                        </tbody>
                    </table> --}}
                    <!-- End -->
                </div>

                <div class="col-sm-4">

                </div>

                <div class="col-sm-2" style='text-align:right'>
                    <div class="row" style="margin-top:-3px;margin-bottom:3px">
                        <div class="col-xs-12">
                            <div class="btn-group">
                                <span class="btn btn-primary" id="printIso"><i
                                    class="fa fa-print"></i>
                                    Iso Digital</span>
                                <span class="btn btn-warning" id="printIso_blanko"><i
                                    class="fa fa-file"></i>
                                    Blanko Iso</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group">
                                <a href="{{ route('isos.create') }}" class="btn btn-info"> <i
                                        class="fa fa-plus"></i>
                                    Tambah</a>
                                <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i
                                        class="fa fa-edit"></i>
                                    Ubah</button>
                                <button type="button" class="btn btn-danger" id="btnHapus" name="btnHapus"> <i
                                        class="fa fa-trash"></i>
                                    Hapus</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </form>
          {{-- end of form filter --}}
          <br>

    {{-- <div class="table-responsive"> --}}
    <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
        <thead>
            <tr>
                <th style="text-indent: 12px;"><i class="fa fa-check-square-o"></i></th>
                <th style="text-indent: 22px;">No.</th>
                <th>Status</th>
                <th>Nama_Bu</th>
                <th>Alamat</th>
                {{-- <th>Prov</th> --}}
                <th>No_srtf</th>
                <th>tgl_srtf</th>
                <th>Tipe_ISO</th>
                <th>Scope</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key)
            <tr>
                <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                    id="selection[]" name="selection[]"></td>
                <td>{{ $loop->iteration }}</td>
                <td align='center'>
                    @if($key->status == "1")
                        <span class="label label-warning">{{ $key->status_r->nama }}</span>
                    @elseif($key->status == 2)
                        <span class="label label-success">{{ $key->status_r->nama }}</span>
                    @endif
                </td>
                <td>{{ $key->nama_bu }}</td>
                <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->alamat }}">{{ str_limit($key->alamat,20) }}</td>
                {{-- <td
                data-toggle="tooltip" data-placement="top" data-html="true" title="
                            negara : {{ $key->id_negara ? $key->negara_r->country_name : '' }} <br>
                            kota : {{ $key->id_kota ? $key->kota_r->nama : '' }} <br>
                            "
                 >{{ $key->prov_r->nama_singkat }}</td> --}}
                <td>{{ $key->no_sert }}</td>
                <td><span style="display:none;"> {{ $key->tgl_sert }} </span>{{ \Carbon\Carbon::parse($key->tgl_sert)->isoFormat('DD MMMM YYYY') }}</td>
                <td>{{ $key->iso_r->kode }}</td>
                <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->scope }}">
                    @if($key->lap_r)
                        @foreach($key->lap_r->scope_r as $key)
                            {{-- {{ $key->scope_r->nama_en }},  --}}
                            @if($loop->last)
                                {{ $key->scope_r->nama_en }}
                            @else
                                {{ $key->scope_r->nama_en }}, 
                            @endif
                        @endforeach
                    @endif
                    {{-- {{ str_limit($key->scope, 20) }} --}}
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    </div> <!-- /.box-body -->
    </div> <!-- /.box -->
    </div>
</section>
<!-- /.content -->


<!-- modal lampiran -->
<div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="lampiranTitle"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <iframe src="" id="iframeLampiran" width="100%" height="500px" frameborder="0"
                            allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
<!-- end of modal lampiran -->

{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('isos/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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
    $(function () {

        // Rubah Warna Filter
        selectFilter("f_awalakhir");
        selectFilter("f_prov_prush");
        selectFilter("f_kota_prush");
        selectFilter("f_jenis_permohonan");
        selectFilter("f_status_sk");
        selectFilter("f_isactive");
        inputFilter("tgl_awal");
        inputFilter("tgl_akhir");
        inputFilter("jenis_usaha");

        
        // Cache Warna Filter
        if ("{{request()->get('f_awalakhir')}}" != "") {
            selectFilterCache("f_awalakhir");
        }
        if ("{{request()->get('f_prov_prush')}}" != "") {
            selectFilterCache("f_prov_prush");
        }
        if ("{{request()->get('f_kota_prush')}}" != "") {
            selectFilterCache("f_kota_prush");
        }
        if ("{{request()->get('f_jenis_permohonan')}}" != "") {
            selectFilterCache("f_jenis_permohonan");
        }
        if ("{{request()->get('f_status_sk')}}" != "") {
            selectFilterCache("f_status_sk");
        }
        if ("{{request()->get('f_isactive')}}" != "") {
            selectFilterCache("f_isactive");
        }
        if ("{{request()->get('tgl_awal')}}" != "") {
            inputFilterCache("tgl_awal");
        }
        if ("{{request()->get('tgl_akhir')}}" != "") {
            inputFilterCache("tgl_akhir");
        }
        if ("{{request()->get('jenis_usaha')}}" != "") {
            inputFilterCache("jenis_usaha");
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mainTable = $('#data-table').DataTable({
            "lengthMenu": [
                [100, 200, 500],
                [100, 200, 500]
            ],
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,
            "autowidth": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 1]
            }],
            "aaSorting": []

        });
        $(".dataTables_scrollHeadInner").css({
            "width": "100%"
        });
        mainTable.columns.adjust().draw();

        // hideen group by class
        // mainTable.columns('.group-1').visible(false);
        // mainTable.columns('.group-2').visible(false);
        // mainTable.columns('.group-3').visible(false);



        // column visibility by id

        $('#btnFilt1').on('click', function (e) {
            var group1 = [5, 6, 7, 8, 9, 10, 11, 12];
            var col = mainTable.columns(group1);
            if ($(this).hasClass('active')) {
                $(this).removeClass("btn-primary")
                $(this).addClass("btn-default")
                $(this).removeClass('active');
                col.visible(!col.visible(), false)
                // alert("active")
            } else {
                // akan di eksekusi pertama krn awal tombol tidak aktive
                $(this).addClass('active');
                $(this).addClass("btn-primary")
                col.visible(col.visible(), false)
            }
            // mainTable.columns.adjust().draw(false);
            e.preventDefault();
        })

        $('#btnFilt2').on('click', function (e) {
            var group2 = [13, 14, 15, 16];
            var col2 = mainTable.columns(group2);
            if ($(this).hasClass('active')) {
                $(this).removeClass("btn-primary")
                $(this).addClass("btn-default")
                $(this).removeClass('active');
                col2.visible(!col2.visible(), false)
                // alert("active")
            } else {
                // akan di eksekusi pertama krn awal tombol tidak aktive
                $(this).addClass('active');
                $(this).addClass("btn-primary")
                col2.visible(col2.visible(), false)
            }
            mainTable.columns.adjust().draw(false);
            e.preventDefault();
        })

        $('#btnFilt3').on('click', function (e) {
            var group3 = [17, 18, 19, 20, 21];
            var col3 = mainTable.columns(group3);
            if ($(this).hasClass('active')) {
                $(this).removeClass("btn-primary")
                $(this).addClass("btn-default")
                $(this).removeClass('active');
                col3.visible(!col3.visible(), false)
                // alert("active")
            } else {
                // akan di eksekusi pertama krn awal tombol tidak aktive
                $(this).addClass('active');
                $(this).addClass("btn-primary")
                col3.visible(col3.visible(), false)
            }
            mainTable.columns.adjust().draw(false);
            e.preventDefault();
        })


        // chained dropdown provinsi vs kabupatenkota
        $('#provinsi').on("select2:select", function () {
            chainedProvinsi();
        });

        // chained dropdown kabupatenkota vs provinsi
        $('#kota').on("select2:select", function () {
            chainedKota();
        });

          // onclick button hapus
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

         // Button edit click
        $('#btnEdit').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                alert('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                alert('Harap pilih satu data untuk di ubah');
            } else {
                url = id[0];
                window.location.href = "{{ url('isos') }}/" + url + "/edit";
            }
        });

        // Button print iso click
        $('#printIso').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                alert('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                alert('Harap pilih satu data untuk di ubah');
            } else {
                url = id[0];
                window.open("{{ url('iso/print') }}/" + url,'_blank');
            }
        });

        // Button print iso click
        $('#printIso_blanko').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                alert('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                alert('Harap pilih satu data untuk di ubah');
            } else {
                url = id[0];
                window.open("{{ url('iso/print_blanko') }}/" + url,'_blank');
            }
        });

    }); // end function

    // Initialize Select2 Elements
    $('.select2').select2()
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
