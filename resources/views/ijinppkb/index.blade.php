@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="{{ url('/') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Ijin PJS_PPKB Mandiri ({{count($hitungjenisusaha)}} Badan Usaha)
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Ijin PJS_PPKB Mandiri</a></li>
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
            <form action="{{ url('ijinppkb/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post"  style="margin-top: 2rem">
                <!-- @method("PUT") -->
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Terbit Ijin</span>
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
                                                @foreach($jenisusaha as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_jenis_usaha') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->kode_jns_usaha }} ({{ $key->nama_jns_usaha }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJS_LPJK</option>
                                                @foreach($pjk3 as $key)
                                                <option value="{{ $key->kode_pjk3 }}"
                                                    {{ request()->get('f_pjk3') == $key->kode_pjk3 ? 'selected' : '' }}>
                                                    {{ $key->badan_usaha->singkat_bu }}
                                                    ({{ $key->badan_usaha->nama_bu }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_instansi" id="f_instansi">
                                                <option selected value="">Instansi_Reff</option>
                                                @foreach($instansi as $key)
                                                <option value="{{ $key->instansi_reff }}"
                                                    {{ request()->get('f_instansi') == $key->instansi_reff ? 'selected' : '' }}>
                                                    {{ $key->instansi_reff }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('ijinppkb') }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Akhir Ijin &nbsp;</span>
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
                                            <select class="form-control select2" name="f_bidang" id="f_bidang">
                                                <option selected value="">Jenis_Kgt</option>
                                                @foreach($bidang as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_bidang') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->jenis_usaha->kode_jns_usaha }} - {{ $key->nama_bidang }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi PJS_LPJK</option>
                                                @foreach($prov as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_provinsi') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama_singkat }} ({{ $key->nama }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
                    </div>

                    <div class="col-sm-3">

                    </div>

                    <div class="col-sm-3" style='text-align:right'>
                        <div class="row" style="margin-top:-3px;margin-bottom:3px">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <span class="btn btn-primary" id="btnDetailPjk3"></i>
                                        Detail_PJS_PPKB</span>
                                    <span class="btn btn-warning" id="btnTenagaAhli"></i>
                                        Tenaga Ahli</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <a href="{{ route('ijinppkb.create') }}" class="btn btn-info"> <i
                                            class="fa fa-plus"></i>
                                        Tambah</a>
                                    <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i
                                            class="fa fa-edit"></i>
                                        Ubah</button>
                                    <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i
                                            class="fa fa-trash"></i>
                                        Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <th style="text-indent: 12px;"><i class="fa fa-check-square-o"></i></th>
                        <th style="text-indent: 22px;">No</th>
                        <th>Jns_Usaha</th>
                        <th>PJS_LPJK</th>
                        {{-- <th>Kualfks</th>
                        <th>Sub_Kualfks</th>
                        <th>Klasfks</th>
                        <th>Sub_Klasfks</th> --}}
                        <th>No_Ijin</th>
                        <th>Tgl_Terbit</th>
                        <th>Tgl_Akhir</th>
                        <!-- <th>Alamat</th> -->
                        <th>Prov</th>
                        <!-- <th>Kota</th> -->
                        <!-- <th>No_Tlp</th>
                        <th>Email</th>
                        <th>Web</th> -->
                        <th>Instansi_Reff</th>
                        <th>Nama_Pimp</th>
                        <!-- <th>Jab_Pimp</th>
                        <th>Hp_Pimp</th>
                        <th>Email_Pimp</th> -->
                        <th>Kontak_P</th>
                        <!-- <th>No_Kontak_P</th>
                        <th>Jab_Kontak_P</th>
                        <th>Email_Kontak_P</th> -->
                        {{-- <th>Pdf_SKP</th> --}}
                        <th>NPWP</th>
                        <th>User_Waktu_Tambah</th>
                        <th>User_Waktu_Ubah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                id="selection[]" name="selection[]"></td>
                        <td style='text-align:center'>{{ $loop->iteration }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Jenis Usaha : {{$key->bidang->jenis_usaha->kode_jns_usaha}} <br>
                            ({{$key->bidang->jenis_usaha->nama_jns_usaha}}) <br>
                            Jenis_Kgt : {{$key->bidang->kode_bidang}} <br>
                            ({{$key->bidang->nama_bidang}}) <br>
                            ">
                            {{ $key->bidang->jenis_usaha->kode_jns_usaha }}</td>
                        <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                            {{$key->badan_usaha->singkat_bu}} <br>
                            ({{$key->badan_usaha->nama_bu}}) <br>
                            ">
                            {{ $key->badan_usaha->singkat_bu }}</td>
                        {{-- <td></td>
                        <td></td>
                        <td></td>
                        <td></td> --}}
                        <td>
                            @if (isset($key->no_sk))
                            @if (isset($key->pdf_skp_pjk3))
                            <button style="width:100%" class="btn btn-success btn-xs"
                                onclick='tampilLampiran("{{ asset("uploads/$key->pdf_skp_pjk3") }}","SKP {{$key->bidang->nama_bidang}}")'>
                                {{ $key->no_sk }} </button>
                            @else
                            <button style="width:100%" class="btn btn-warning btn-xs">
                                {{ $key->no_sk }} </button>
                            @endif
                            @endif
                        </td>
                        <td style='text-align:right'>
                            @if($key->tgl_sk === null)
                            <span style="display:none;">Selamanya</span>
                            Selamanya
                            @else
                            <span style="display:none;">{{$key->tgl_sk}}</span>
                            {{ \Carbon\Carbon::parse($key->tgl_sk)->isoFormat("DD MMMM YYYY") }}
                            @endif
                        </td>
                        <td style='text-align:right'>
                            @if($key->tgl_sk === null)
                            <span style="display:none;">Selamanya</span>
                            Selamanya
                            @else


                            <span style="display:none;">{{$key->tgl_akhir_sk}}</span>

                            @php
                            $warnatulisan = "black";
                            $hari = "";
                            @endphp

                            @if(\Carbon\Carbon::parse($key->tgl_akhir_sk)->toDateTimeString() < \Carbon\Carbon::now()->
                                toDateTimeString())
                                @php
                                $warnatulisan = "red";
                                $hari = "Masa berlaku sudah habis";
                                @endphp
                                @elseif(\Carbon\Carbon::parse($key->tgl_akhir_sk)->toDateTimeString() <
                                    \Carbon\Carbon::now()->addMonths(3)->toDateTimeString())
                                    @php
                                    $warnatulisan = "#a64dff";
                                    $now = \Carbon\Carbon::now();
                                    $habis = \Carbon\Carbon::parse($key->tgl_akhir_sk);
                                    $hari = "Berlaku ".$habis->diffInDays($now)." hari lagi";
                                    @endphp
                                    @endif
                                    <span data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{$hari}}"
                                        style="color:{{$warnatulisan}}">{{ \Carbon\Carbon::parse($key->tgl_akhir_sk)->isoFormat("DD MMMM YYYY") }}</span>
                                    @endif
                        </td>
                        <!-- <td>{{ $key->badan_usaha->alamat }}</td> -->
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Provinsi : {{$key->badan_usaha->provinsi->nama}} <br>
                            Kab/Kota : {{$key->badan_usaha->kota->nama}} <br>
                            Alamat : {{$key->badan_usaha->alamat}} <br>
                            Telp : {{$key->badan_usaha->telp}} <br>
                            Email : {{$key->badan_usaha->email}} <br>
                            ">
                            {{ $key->badan_usaha->provinsi->nama_singkat }}</td>
                        <!-- <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Kota : {{$key->badan_usaha->kota->nama}} <br>
                            Alamat : {{$key->badan_usaha->alamat}} <br>
                            Telp : {{$key->badan_usaha->telp}} <br>
                            Email : {{$key->badan_usaha->email}} <br>
                            ">
                            {{ $key->badan_usaha->kota->singkatan_kota }}</td> -->
                        <!-- <td>{{ $key->badan_usaha->telp }}</td>
                        <td>{{ $key->badan_usaha->email }}</td>
                        <td>{{ $key->badan_usaha->web }}</td> -->
                        <td>{{ $key->badan_usaha->instansi_reff }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Nama : {{$key->nama_pimp}} <br>
                            Jabatan : {{$key->jab_pimp}} <br>
                            No Hp : {{$key->no_pimp}} <br>
                            Email : {{$key->email_pimp}} <br>
                            ">
                            {{ $key->nama_pimp }}</td>
                        <!-- <td>{{ $key->badan_usaha->jab_pimp }}</td>
                        <td>{{ $key->badan_usaha->hp_pimp }}</td>
                        <td>{{ $key->badan_usaha->email_pimp }}</td> -->
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="
                            Nama : {{$key->nama_kp}} <br>
                            Jabatan : {{$key->jab_kp}} <br>
                            No Hp : {{$key->hp_kp}} <br>
                            Email : {{$key->email_kp}} <br>
                            ">
                            {{ $key->nama_kp }}</td>

                        <!-- <td>{{ $key->badan_usaha->no_kontak_p }}</td>
                        <td>{{ $key->badan_usaha->jab_kontak_p }}</td>
                        <td>{{ $key->badan_usaha->email_kontak_p }}</td> -->
                        {{-- <td style='text-align:center'>
                            @if (isset($key->pdf_skp_pjk3))
                            <button class="btn btn-success btn-xs"
                                onclick='tampilLampiran("{{ asset("uploads/$key->pdf_skp_pjk3") }}","SKP
                        {{$key->bidang->nama_bidang}}")'><i class="fa fa-file-pdf-o"></i> Lihat </button>
                        @endif
                        </td> --}}
                        <td style="text-align:center" data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                            NPWP : {{ $key->badan_usaha->npwp }} <br>
                            No Rekening : {{ $key->badan_usaha->no_rek  }} <br>
                            Atas Nama : {{ $key->badan_usaha->nama_rek }} <br>
                            Bank : {{ isset($key->badan_usaha->bank->Nama_Bank) ? $key->badan_usaha->bank->Nama_Bank : '' }} <br>
                        ">
                            @if (isset($key->badan_usaha->npwp))
                                @if (isset($key->badan_usaha->npwp_pdf))
                                    <button class="btn btn-success btn-xs"
                                        onclick='tampilLampiran("{{ asset($key->badan_usaha->npwp_pdf) }}","NPWP {{$key->badan_usaha->nama_bu}}")'> {{ $key->badan_usaha->npwp }} </button>
                                @else
                                    <button class="btn btn-warning btn-xs"> {{ $key->badan_usaha->npwp }} </button>
                                @endif
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($key->badan_usaha->created_at)->isoFormat("DD MMMM YYYY H:mm:s") }}</td>
                        <td>{{ \Carbon\Carbon::parse($key->badan_usaha->updated_at)->isoFormat("DD MMMM YYYY H:mm:s") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
            {{-- end of car data  --}}
        </div>

        <!-- Modal Detail PJK3 -->
        <div class="modal fade" id="modaldetailPjk3" role="dialog">
            <div class="modal-dialog modal-lg" style="width:1500px">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Detail Data PJK3</b></h4>
                    </div>
                    <div class="modal-body">
                        <!-- Modal Body -->
                        <div class="box" style="margin-top:-15px">
                            <div class="box-body no-padding">
                                <table id="masterModalPjk3" class="table table-condensed tableModal">
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-body no-padding">
                                <table class="table table-condensed tableModalDetail" id="tableModalDetail">
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- End -->

        <!-- Modal Detail PJK3 -->
        <div class="modal fade" id="modaldetailAhli" role="dialog">
            <div class="modal-dialog modal-lg" style="width:1500px">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Detail Data Tenaga Ahli PJK3</b></h4>
                    </div>
                    <div class="modal-body">
                        <!-- Modal Body -->
                        <div class="box" style="margin-top:-15px">
                            <div class="box-body no-padding">
                                <table id="masterModalAhli" class="table table-condensed tableModal">
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-body no-padding withscroll">
                                <table class="table table-condensed tableModalDetail" id="tableModalDetailAhli">
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- End -->

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

        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<!-- modal konfirmasi -->

<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('ijinppkb/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- <script type="text/javascript" src="{{ asset('chained.js') }}"></script> -->
<script type="text/javascript">
    var save_method = "add";
    $(function () {

        // Rubah Warna Filter
        selectFilter("f_jenis_usaha");
        selectFilter("f_provinsi");
        selectFilter("f_pjk3");
        selectFilter("f_bidang");
        selectFilter("f_instansi");
        inputFilter("f_awal_terbit");
        inputFilter("f_awal_akhir");
        inputFilter("f_akhir_terbit");
        inputFilter("f_akhir_akhir");

        // Cache Warna Filter
        if ("{{request()->get('f_jenis_usaha')}}" != "") {
            selectFilterCache("f_jenis_usaha");
        }
        if ("{{request()->get('f_provinsi')}}" != "") {
            selectFilterCache("f_provinsi");
        }
        if ("{{request()->get('f_pjk3')}}" != "") {
            selectFilterCache("f_pjk3");
        }
        if ("{{request()->get('f_bidang')}}" != "") {
            selectFilterCache("f_bidang");
        }
        if ("{{request()->get('f_instansi')}}" != "") {
            selectFilterCache("f_instansi");
        }

        if ("{{request()->get('f_awal_terbit')}}" != "") {
            inputFilterCache("f_awal_terbit");
        }
        if ("{{request()->get('f_akhir_terbit')}}" != "") {
            inputFilterCache("f_akhir_terbit");
        }
        if ("{{request()->get('f_awal_akhir')}}" != "") {
            inputFilterCache("f_awal_akhir");
        }
        if ("{{request()->get('f_akhir_akhir')}}" != "") {
            inputFilterCache("f_akhir_akhir");
        }

        $('#btnDetailPjk3').on('click', function (e) {
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
                // Swal.fire('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk di tampilkan",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // Swal.fire('Harap pilih satu data untuk di tampilkan');
            } else {
                url = id[0];
                getDataDetail(id[0]);
                $('#modaldetailPjk3').modal('show');
            }
        });

        $('#btnTenagaAhli').on('click', function (e) {
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
                // Swal.fire('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk di tampilkan",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // Swal.fire('Harap pilih satu data untuk di tampilkan');
            } else {
                url = id[0];
                getDataDetailAhli(id[0]);
            }
        });

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
                // Swal.fire('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk diubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                url = id[0];
                window.location.href = "{{ url('ijinppkb') }}/" + url + "/edit";
            }
        });

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

        // Mengambil data Detail PJK3
        function getDataDetail(id) {
            var url = "{{ url('data_skp_pjk3_modal') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_pjk3: id
                },
                success: function (data) {
                    console.log(data);
                    $('#tableModalDetail > tbody').html(`
                    <tr>
                                            <th>No</th>
                                            <th>Jenis Usaha</th>
                                            <th>Bidang SKP</th>
                                            <th>No SKP</th>
                                            <th>Tgl Terbit SKP</th>
                                            <th>Tgl Akhir SKP</th>
                                        </tr>
                    `);
                    data.forEach(function (item, index) {
                        if (index == 0) {
                            changedatapjk3(index, data);
                        }
                        add_row(index, data);
                    });
                },
                error: function (xhr, status) {
                    alert('terjadi error ketika menampilkan data');
                }
            });
        }

        // Mengambil data detail tenaga ahli
        function getDataDetailAhli(id) {
            var url = "{{ url('data_ahli_pjk3_modal') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_pjk3: id
                },
                success: function (data) {
                    console.log(data);
                    $('#tableModalDetailAhli > tbody').html(`
                    <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Bidang Srtf_Alat</th>
                                            <th>Jns_Dok</th>
                                            <th>Nama_Dok</th>
                                            <th>Instansi_Dok</th>
                                            <th>Penyelenggara</th>
                                            <th>No_Dok</th>
                                            <th>Tgl_Terbit</th>
                                            <th>Tgl_Akhir</th>
                                            <th>Prov</th>
                                            <th>Kota</th>
                                            <th>Sekolah_P</th>
                                            <th>Ket_P</th>
                                            <th>NPWP</th>
                                            <th>Pdf_NPWP</th>
                                        </tr>
                    `);
                    if (data.length > 0) {
                        data.forEach(function (item, index) {
                            if (index == 0) {
                                changedataahli(index, data);
                            }
                            add_row_ahli(index, data);
                        });
                        $('#modaldetailAhli').modal('show');
                    } else {
                        Swal.fire({
                            title: "Data tenaga ahli tidak ditemukan !",
                            type: 'error',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#AAA'
                        });
                        // Swal.fire('Data tenaga ahli tidak ditemukan !')
                    }

                },
                error: function (xhr, status) {
                    alert('terjadi error ketika menampilkan data');
                }
            });
        }

        // Fungsi Change Data Modal
        function changedatapjk3(index, data) {
            $('#masterModalPjk3 > tbody').html(`
            <tr>
                                            <th colspan="5" style="text-align:center">` + data[index]['badan_usaha'][
                'nama_bu'
            ] + `</th>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                            <th style="width:15%;text-align:right">Provinsi Naker :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['provinsi']['nama'] + `</td>
                                            <th style="width:15%;text-align:right">Alamat :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['alamat'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Provinsi Badan Usaha :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['provinsibu'][
                'nama'
            ] + `</td>
                                            <th style="width:15%;text-align:right">Kota Badan Usaha :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['kota']['nama'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Tlp :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['telp'] + `</td>
                                            <th style="width:15%;text-align:right">Email :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['email'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Instansi Reff :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['instansi_reff'] + `</td>
                                            <th style="width:15%;text-align:right">Web :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['web'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Nama Pimpinan :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['nama_pimp'] + `</td>
                                            <th style="width:15%;text-align:right">Jabatan Pimpinan :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['jab_pimp'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Hp Pimpinan :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['hp_pimp'] + `</td>
                                            <th style="width:15%;text-align:right">Email Pimpinan :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['email_pimp'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Nama Kontak Person :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['kontak_p'] + `</td>
                                            <th style="width:15%;text-align:right">Jabatan Kontak Person :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['jab_kontak_p'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No HP Kontak Person :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['no_kontak_p'] + `</td>
                                            <th style="width:15%;text-align:right">Email Kontak Person :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['email_kontak_p'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">NPWP :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['npwp'] + `</td>
                                            <th style="width:15%;text-align:right">Pdf_NPWP :</th>
                                            <td style="width:35%;">
                                            <a class="fa fa-file-pdf-o" target="_blank" href="uploads/` + data[index][
                'badan_usaha'
            ]['npwp_pdf'] + `"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Rekening Bank :</th>
                                            <td style="width:20%;">` + data[index]['badan_usaha']['no_rek'] + `</td>
                                            <th style="width:15%;text-align:right">Nama Rekening Bank :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['nama_rek'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right"></th>
                                            <td style="width:20%;"></td>
                                            <th style="width:15%;text-align:right">Nama Bank :</th>
                                            <td style="width:35%;">` + data[index]['badan_usaha']['bank'][
                'Nama_Bank'
            ] + `</td>
                                        </tr>
            `);
        }

        // Fungsi Change Data Modal
        function changedataahli(index, data) {
            $('#masterModalAhli > tbody').html(`
            <tr>
                                            <th colspan="5" style="text-align:center">` + data[index]['skp_pjk3'][
                    'badan_usaha'
                ][
                    'nama_bu'
                ] + `</th>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                            <th style="width:15%;text-align:right">Provinsi Naker :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'provinsi'
                ]['nama'] + `</td>
                                            <th style="width:15%;text-align:right">Alamat :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'alamat'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Provinsi Badan Usaha :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'provinsibu'
                ]['nama'] + `</td>
                                            <th style="width:15%;text-align:right">Kota Badan Usaha :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha']['kota'][
                    'nama'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Tlp :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha']['telp'] + `</td>
                                            <th style="width:15%;text-align:right">Email :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'email'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Instansi Reff :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'instansi_reff'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Web :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha']['web'] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Nama Pimpinan :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'nama_pimp'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Jabatan Pimpinan :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'jab_pimp'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Hp Pimpinan :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'hp_pimp'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Email Pimpinan :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'email_pimp'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">Nama Kontak Person :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'kontak_p'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Jabatan Kontak Person :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'jab_kontak_p'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No HP Kontak Person :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'no_kontak_p'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Email Kontak Person :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'email_kontak_p'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">NPWP :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha']['npwp'] +
                `</td>
                                            <th style="width:15%;text-align:right">Pdf_NPWP :</th>
                                            <td style="width:35%;"><a class="fa fa-file-pdf-o" target="_blank" href="uploads/` +
                data[index][
                    'skp_pjk3'
                ]['badan_usaha']['npwp_pdf'] + `"></a></td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right">No Rekening Bank :</th>
                                            <td style="width:20%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'no_rek'
                ] + `</td>
                                            <th style="width:15%;text-align:right">Nama Rekening Bank :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha'][
                    'nama_rek'
                ] + `</td>
                                        </tr>
                                        <tr>
                                        <td style="width:15%"></td>
                                        <th style="width:15%;text-align:right"></th>
                                            <td style="width:20%;"></td>
                                            <th style="width:15%;text-align:right">Nama Bank :</th>
                                            <td style="width:35%;">` + data[index]['skp_pjk3']['badan_usaha']['bank'][
                    'Nama_Bank'
                ] + `</td>
                                        </tr>
            `);
        }

        // Fungsi menambah baris modal detail PJK3
        function add_row(index, data) {
            if (data[index]['pdf_skp_pjk3'] == null || data[index]['pdf_skp_pjk3'] == "") {
                npwpPdf = `<span>` + cekNull(data[index]['no_sk']) + `</span>`;
            } else {
                npwpPdf = `<a target="_blank" href="uploads/` + data[index][
                        'pdf_skp_pjk3'
                    ] +
                    `">` + cekNull(data[index]['no_sk']) + `</a>`;
            }

            $('#tableModalDetail > tbody:last').append(`
            <tr>
                                            <td align="center">` + (index + 1) + `</td>
                                            <td>` + cekNull(data[index]['bidang']['jenis_usaha']['nama_jns_usaha']) + `</td>
                                            <td>` + cekNull(data[index]['bidang']['nama_bidang']) + `</td>
                                            <td>` + npwpPdf + `</td>
                                            <td align="right">` + cekNull(data[index]['tgl_sk']) + `</td>
                                            <td align="right">` + cekNull(data[index]['tgl_akhir_sk']) + `</td>
                                        </tr>
            `);
        }

        // Fungsi menambah baris modal detail ahli
        function add_row_ahli(index, data) {
            if (data[index]['personal']['kota'] == null || data[index]['personal']['kota'] == "") {
                namaKota = "null";
                namaProv = "null";
            } else {
                namaKota = data[index]['personal']['kota']['nama'];
                namaProv = data[index]['personal']['kota']['provinsi']['nama'];
            }

            if (data[index]['personal']['sekolah'] == null || data[index]['personal']['sekolah'] == "") {
                namaSekolah = "null";
            } else {
                namaSekolah = data[index]['personal']['sekolah']['nama_sekolah'];
            }

            if (data[index]['personal']['npwp_pdf'] == null || data[index]['personal']['npwp_pdf'] == "") {
                npwpPdf = "null";
            } else {
                npwpPdf = `<a class="fa fa-file-pdf-o" target="_blank" href="uploads/` + data[index]['personal']
                    ['npwp_pdf'] +
                    `"></a>`;
            }

            $('#tableModalDetailAhli > tbody:last').append(`
            <tr>
                                            <td align="center">` + (index + 1) + `</td>
                                            <td>` + cekNull(data[index]['personal']['nama']) + `</td>
                                            <td data-toggle="tooltip" data-placement="bottom" title="` + cekNull(data[
                index]['bid_sertifikat_alat']['kode_srtf_alat']) + ` | ` + cekNull(data[index][
                'bid_sertifikat_alat'
            ]['nama_srtf_alat']) + `">` + cekNull(data[index]['bid_sertifikat_alat'][
                'kode_srtf_alat'
            ]) + `</td>
                                            <td>` + cekNull(data[index]['jenisdok_ak3']['Nama_jns_dok']) + `</td>
                                            <td></td>
                                            <td>` + cekNull(data[index]['instansi_skp']) + `</td>
                                            <td>` + cekNull(data[index]['penyelenggara']) + `</td>
                                            <td>` + cekNull(data[index]['no_skp']) + `</td>
                                            <td align="right">` + cekNull(tanggal_indonesia(data[index]['tgl_skp'])) + `</td>
                                            <td align="right">` + cekNull(tanggal_indonesia(data[index][
                'tgl_akhir_skp'
            ])) + `</td>
                                            <td>` + cekNull(namaProv) + `</td>
                                            <td>` + cekNull(namaKota) + `</td>
                                            <td>` + cekNull(namaSekolah) + `</td>
                                            <td>` + cekNull(data[index]['keterangan']) + `</td>
                                            <td>` + cekNull(data[index]['personal']['npwp']) + `</td>
                                            <td align="center">` + cekNull(npwpPdf) + `</td>
                                        </tr>
            `);
        }

        // $('#confirm-delete').click(function () {
        //     var deleteButton = $(this);
        //     var id = deleteButton.data("id");
        //     var home = "{{ url('/') }}";

        //     deleteButton.button('loading');

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "master_stock/" + id,
        //         type: 'DELETE',
        //         dataType: "JSON",
        //         data: {
        //             // _method:"DELETE"
        //             // "id": id
        //         },
        //         success: function (response) {
        //             deleteButton.button('reset');

        //             selectedRow.remove().draw();

        //             $("#modal-konfirmasi").modal('hide');

        //             Swal.fire({
        //                 title: response.message,
        //                 // text: response.success,
        //                 type: 'success',
        //                 confirmButtonText: 'Close',
        //                 confirmButtonColor: '#AAA',
        //                 onClose: function () {
        //                     window.location.replace(home);
        //                 }
        //             })
        //         },
        //         error: function (xhr) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // });
        // $('.selection').on('click', function () {
        //     var cb = $(this).data("id");
        //     alert(cb);
        //     $('#btnEdit').attr('href', `{{ url('riksauji/` + id + `/edit ') }}`)
        //     $('#btnPrintLaporan').attr('href', `{{ url('riksauji/` + id + `/edit ') }}`)
        //     $('#btnPrintEva').attr('href', `{{ url('riksauji/cetak/eva/` + id + `') }}`)
        //     $('#btnPrintSuket').attr('href', `{{ url('riksauji/cetak/suket/` + id + `') }}`)
        //     $('#btnPrintSuketEva').attr('href', `{{ url('riksauji/cetak/suketeva/` + id + `') }}`)
        //     alert(cb.data("id"))
        // });
    });

    // function btnHapus() {
    //     var url = "{{ url('riksauji/bulkdelete') }}";
    //     var id = [];
    //     $('.selection:checked').each(function () {
    //         id.push($(this).data('id'));
    //     });
    //     if (id.length == 0) {
    //         alert('tidak ada data yang terpilih untuk di hapus');
    //     } else {

    //     }
    // }

    // edit button show data
    // function edit(url) {
    //     save_method = "update";
    //     //var formData = new FormData($('#formAdd')[0]);
    //     //var url = "{{ url('petty_cash/transaksi') }}/" + id + "";
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: url,
    //         type: 'GET',
    //         dataType: 'JSON',
    //         success: function (data) {
    //             $('#key').val(data.id);
    //             $('#_method').val('PATCH');
    //             $('#kode_barang').val(data.kode_barang);
    //             $('#nama').val(data.nama);
    //             $('#qty').val(data.qty);
    //             $('#satuan').val(data.qty_satuan);
    //             $('#harga').val(data.harga);
    //             $('#kategori').val(data.kategori).trigger('change');
    //         },
    //         error: function (xhr, status) {
    //             alert('Oops.. Something went wrong!!');
    //         }
    //     });
    // }

    //Initialize Select2 Elements
    $('.select2').select2();

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
