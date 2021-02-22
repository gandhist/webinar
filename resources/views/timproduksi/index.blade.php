@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    <a href="{{ url('/') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Tim Produksi {{$nama_jenis_usaha}} PKB P3S Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Daftar Tim Produksi</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">

            @if(session()->get('message'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- sub menu  --}}
            <form action="{{ url('timproduksi/'.$id_jns_usaha) }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="get">
                <!-- @method("PUT") -->
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row">
                    <div class="col-sm-3">

                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJLPJK</option>
                                                @foreach($badanusaha as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_pjk3') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->singkat_bu.' | '.$key->nama_bu }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_tim_pro" id="f_tim_pro">
                                                <option value="">Tim Produksi</option>
                                                @foreach($timproduksi as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_tim_pro') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->singkat_tim_p }} ({{$key->nama_tim_p}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi</option>
                                                @foreach($prov as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_provinsi') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_instansi_reff"
                                                id="f_instansi_reff">
                                                <option selected value="">Instansi_Reff</option>
                                                @foreach($instansireff as $key)
                                                <option value="{{ $key->instansi_reff }}"
                                                    {{ request()->get('f_instansi_reff') == $key->instansi_reff ? 'selected' : '' }}>
                                                    {{ $key->instansi_reff}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('timproduksi/'.$id_jns_usaha) }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJLPJK</option>
                                                @foreach($badanusaha as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_pjk3') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->singkat_bu.' | '.$key->nama_bu }}</option>
                                                @endforeach
                                            </select>
                                        </div> -->
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_level_tim_pro"
                                                id="f_level_tim_pro">
                                                <option selected value="">Level</option>
                                                @foreach($leveltimpro as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_level_tim_pro') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama_level }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_kota" id="f_kota">
                                                <option selected value="">Kota</option>
                                                @foreach($kota as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_kota') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_jenis_usaha"
                                                id="f_jenis_usaha">
                                                <option selected value="">Jenis Usaha</option>
                                                @foreach($jenisUsaha as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_jenis_usaha') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->kode_jns_usaha.' | '.$key->nama_jns_usaha }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
                    </div>

                    <div class="col-sm-7">

                    </div>
                    @if($id_jns_usaha=="all")
                    <div class="col-sm-2" style='text-align:right'>
                        <div class="btn-group">
                            <a href="{{ url('timproduksi/create') }}" class="btn btn-info"> <i class="fa fa-plus"></i>
                                Tambah</a>
                            {{-- <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i class="fa fa-edit"></i>
                                Ubah</button>
                            <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i class="fa fa-trash"></i>
                                Hapus</button> --}}
                        </div>
                    </div>
                    @endif
                </div>
            </form>
            <!-- /.box-footer -->
            {{-- end of sub menu  --}}
            <!-- <hr> -->
            {{-- table data of car  --}}
            {{-- <div class="table-responsive"> --}}
            <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                <thead>
                    <tr>
                        <th style="text-indent: 12px;">Action</th>
                        <th style="text-indent: 22px;">No</th>
                        <th>Jns_Usaha</th>
                        <th>PJS_LPJK</th>
                        <th>Tim_Prod</th>
                        <th>BU_Tim</th>
                        <!-- <th>Level</th> -->
                        <th>Gol_Hrg_P</th>
                        <th>Provinsi</th>
                        <!-- <th>Kota</th> -->
                        <th>Instansi_Reff</th>
                        <th>Nama_Pimp</th>
                        <th>Kontak_P</th>
                        <th>NPWP</th>
                        <!-- <th>Pdf_NPWP</th> -->
                        <th>Keterangan</th>
                        <th>U_Tambah</th>
                        <!-- <th>User_Tgl_Tambah</th> -->
                        <th>U_Ubah</th>
                        <!-- <th>User_Tgl_Ubah</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td style='text-align:center;width:1%'>
                            <a href="{{ url('timproduksi/'.$key->id.'/edit')}}" type="button" class="btn btn-xs btn-warning"><span class="fa fa-pencil"></span></a>
                            <button type="button" class="btn btn-xs btn-danger" onclick='hapusData("{{ $key->id }}")'><span class="fa fa-trash"></span></button>
                            {{-- <a class="btn btn-xs btn-success"><span class="fa fa-eye"></i></a> --}}
                        </td>
                        <td style='text-align:center;width:1%'>{{ $loop->iteration }}</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="@if($key->jenis_usaha) {{$key->jenisusaha->nama_jns_usaha}} @endif">
                            @if($key->jenis_usaha) {{$key->jenisusaha->kode_jns_usaha}} @endif</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="Nama Lengkap : @if($key->pjk3) {{$key->pjlpjk->nama_bu}} @else - @endif<br>
                        Singkatan : @if($key->pjk3) {{$key->pjlpjk->singkat_bu}} @else - @endif
                        ">@if($key->pjk3) {{ $key->pjlpjk->singkat_bu}} @endif</td>
                        <td style='text-align:center;color:@if($key->level_p==1) green  @elseif($key->level_p==2) orange @elseif($key->level_p==3) #00b5d2 @elseif($key->level_p==4) #cc00ff @endif' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="Nama Lengkap : {{$key->nama_tim_p}}<br>
                            Level : {{$key->leveltim->nama_level}}
                            ">{{$key->singkat_tim_p}}</td>
                        <!-- <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="Level Atas : @if($key->level_p_atas) {{$key->leveltimatas->nama_tim_p}} @else  @endif ">
                            {{$key->leveltim->nama_level}}</td> -->
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="Nama Lengkap : @if($key->id_bu) {{$key->bu_r->nama_bu}} @else - @endif<br>
                        Singkatan : @if($key->id_bu) {{$key->bu_r->singkat_bu}} @else - @endif
                        ">@if($key->id_bu) {{ $key->bu_r->singkat_bu}} @else <span style="color:red">Non BU</span>
                            @endif</td>
                        <td style='text-align:right' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="@if($key->gol_hrg_p) {{$key->golharga_r->keterangan}} @endif">@if($key->gol_hrg_p)
                            {{$key->golharga_r->kode}} @endif</td>
                        <!-- <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="Provinsi : {{$key->provinsi->nama}}
                            ">{{$key->provinsi->nama_singkat}}</td> -->
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                            Provinsi : {{$key->provinsi->nama}}<br>
                            Kab/Kota : {{$key->kota->nama}}<br>
                            Alamat : {{$key->alamat}}<br>
                            Hp/Tlp : {{$key->no_tlp}}<br>
                            Email : {{$key->email}}<br>
                            ">{{$key->provinsi->nama_singkat}}</td>
                        <td>{{$key->instansi_reff}}</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                            Nama : {{$key->nama_pimp}}<br>
                            Jabatan : {{$key->jab_pimp}}<br>
                            Hp/Tlp : {{$key->hp_pimp}}<br>
                            Email : {{$key->email_pimp}}<br>
                            ">{{$key->nama_pimp}}
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                            Nama : {{$key->kontak_p}}<br>
                            Jabatan : {{$key->jab_kontak_p}}<br>
                            Hp/Tlp : {{$key->no_kontak_p}}<br>
                            Email : {{$key->email_kontak_p}}<br>
                            ">{{$key->kontak_p}}
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" style="text-align:center"
                            title="No.Rek : {{$key->no_rek}}<br>
                            Nama Rek : {{$key->nama_rek}}<br>
                            Bank : @if($key->id_bank) {{$key->bank->Nama_Bank}} @else  @endif<br>
                            ">
                            @if (isset($key->no_npwp))
                            @if (isset($key->file_npwp))
                            <button class="btn btn-success btn-xs"
                                onclick='tampilLampiran("{{ asset($key->file_npwp) }}","NPWP")'> {{$key->no_npwp}}
                            </button>
                            @else
                            <button class="btn btn-warning btn-xs"> {{$key->no_npwp}}
                            </button>
                            @endif
                            @endif
                            <!-- {{$key->no_npwp}} -->
                        </td>
                        <!-- <td style="text-align:center">
                            @if (isset($key->file_npwp))
                            <button class="btn btn-success btn-xs"
                                onclick='tampilLampiran("{{ asset($key->file_npwp) }}","NPWP")'><i
                                    class="fa fa-file-pdf-o"></i> Lihat </button>
                            @endif
                        </td> -->
                        <td>{{$key->keterangan}}
                        </td>
                        <td style="width:5%; text-align: center;" data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title=" @if (isset($key->created_at))
                            Tanggal Tambah : {{ \Carbon\Carbon::parse($key->created_at)->isoFormat('DD MMMM YYYY H:mm:s') }} @endif">
                            @if($key->created_by) {{ucfirst($key->created_r->name)}} @endif
                        </td>
                        <td style="width:5%; text-align: center;" data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="  @if (isset($key->updated_at))
                        Tanggal Ubah : {{ \Carbon\Carbon::parse($key->updated_at)->isoFormat('DD MMMM YYYY H:mm:s') }} @endif">
                            @if($key->updated_by) {{ucfirst($key->updated_r->name)}} @endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
            {{-- end of car data  --}}
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer"></div> -->
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<!-- modal konfirmasi -->
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('timproduksi/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
        method="post" enctype="multipart/form-data">
        <!-- @method("DELETE") -->
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
                    Yakin ingin menghapus data?
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
<!-- end of modal konfirmais -->

<!-- modal lampiran -->
<!-- <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
</div> -->
<!-- end of modal lampiran -->

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
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('chained.js') }}"></script> -->
<script type="text/javascript">
    var save_method = "add";

    function hapusData(id) {
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
    }
    $(function () {

        // Rubah Warna Filter
        selectFilter("f_jenis_usaha");
        selectFilter("f_pjk3");
        selectFilter("f_tim_pro");
        selectFilter("f_level_tim_pro");
        selectFilter("f_provinsi");
        selectFilter("f_kota");
        selectFilter("f_instansi_reff");


        // Cache Warna Filter
        if ("{{request()->get('f_jenis_usaha')}}" != "") {
            selectFilterCache("f_jenis_usaha");
        }
        if ("{{request()->get('f_instansi_reff')}}" != "") {
            selectFilterCache("f_instansi_reff");
        }
        if ("{{request()->get('f_pjk3')}}" != "") {
            selectFilterCache("f_pjk3");
        }
        if ("{{request()->get('f_tim_pro')}}" != "") {
            selectFilterCache("f_tim_pro");
        }
        if ("{{request()->get('f_level_tim_pro')}}" != "") {
            selectFilterCache("f_level_tim_pro");
        }
        if ("{{request()->get('f_provinsi')}}" != "") {
            selectFilterCache("f_provinsi");
        }
        if ("{{request()->get('f_kota')}}" != "") {
            selectFilterCache("f_kota");
        }

        // Filter kota berdasarkan provinsi
        $('#f_provinsi').on('select2:select', function () {
            var url = `{{ url('chain/filterproptimp') }}`;
            chainedProvinsiTimP(url, 'f_provinsi', 'f_kota', "Kota","{{$id_jns_usaha}}");
        });

        // Input data mask
        $('[data-mask]').inputmask();

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
                    title: "Harap pilih satu data untuk diubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                url = id[0];
                window.location.href = "{{ url('timproduksi') }}/" + url + "/edit";
            }
        });

        // Button hapus click
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
            } else {
                $('#modal-konfirmasi').modal('show');
            }
        });
    });

    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize datetimepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
