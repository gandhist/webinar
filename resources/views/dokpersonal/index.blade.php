@extends('templates.header')
<style>
    .head-center{
        margin-left: 2px;
        margin-right: -20px;
    }
    .customInputLg {
        height: 28px;
        border-radius: 4px !important;
        border-color: #a5a5a0;
        width: 270px !important;
    }
    .input-group-addon{
        text-align:right !important;
    }
    .customSelect2dp .select2-container {
        width: 160px !important;
    }
</style>
@section('content')
<section class="content-header">
    <h1>
    <a href="{{ url('/') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Dokumen Personil PKB P3S Mandiri (<span class="text-blue">{{ $data->groupBy('id_personal')->count() }} Orang</span>)
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Dok Personil</a></li>
    </ol>

</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">

            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- sub menu  --}}
            <form action="{{ url('dokpersonal/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post">
                <!-- @method("PUT") -->
                @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Terbit</span>
                                            <input id="f_awal_terbit" name="f_awal_terbit"
                                                value="{{ request()->get('f_awal_terbit') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Awal">
                                            <span class="input-group-addon customInput">To</span>
                                            <input id="f_akhir_terbit" name="f_akhir_terbit"
                                                value="{{ request()->get('f_akhir_terbit') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_jenis_usaha"
                                                id="f_jenis_usaha">
                                                <option selected value="">Jenis_Usaha</option>
                                                @foreach($jenisusaha as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_jenis_usaha') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->kode_jns_usaha }} ({{ $key->nama_jns_usaha }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option selected value="">Prov_Personil</option>
                                                @foreach($prov as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_provinsi') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_bidang_dok" id="f_bidang_dok">
                                                <option selected value="">Bidang_Dok</option>
                                                @foreach($bidang as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_bidang_dok') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->jenis_usaha->kode_jns_usaha }} - {{ $key->nama_bidang }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_nama_dok" id="f_nama_dok">
                                                <option selected value="">Nama_Srtf</option>
                                                @foreach($jenisdoksrtf as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_nama_dok') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->bid_srft_alat->kode_srtf_alat }} ({{ $key->nama_srft_alat }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <input style="height:11px !important;margin-left: 163px;margin-top: -26px;" id="ck_nama_dok" name="ck_nama_dok" type="checkbox" {{ request()->get('ck_nama_dok') == "on" ? 'checked' : '' }}>
                                        </div>
                                        <div class="input-group" style="margin-left: 163px;margin-top: -16px;font-size: 12px;">
                                            <span class="text-danger">Belum Ada</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_instansi_dok"
                                                id="f_instansi_dok">
                                                <option selected value="">Instansi_Dok</option>
                                                @foreach($instansidok as $key)
                                                <option value="{{ $key->instansi_skp }}"
                                                    {{ request()->get('f_instansi_dok') == $key->instansi_skp ? 'selected' : '' }}>
                                                    {{ $key->instansi_skp }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_jenjang_pendidikan"
                                                id="f_jenjang_pendidikan" placeholder="Jenjang Pendidikan">
                                                <option selected value="">Jenjang_Pddk</option>
                                                @foreach($jp as $key)
                                                <option value="{{ $key->id_jenjang }}"
                                                    {{ request()->get('f_jenjang_pendidikan') == $key->id_jenjang ? 'selected' : '' }}>
                                                    {{ $key->deskripsi }}</option>
                                                @endforeach
                                                <option value="sma" {{ request()->get('f_jenjang_pendidikan') == "sma" ? 'selected' : '' }}>SMA & Jenjang Di atasnya</option>
                                                <option value="d3" {{ request()->get('f_jenjang_pendidikan') == "d3" ? 'selected' : '' }}>D3 & Jenjang Di atasnya</option>
                                                <option value="s1" {{ request()->get('f_jenjang_pendidikan') == "s1" ? 'selected' : '' }}>S1 & Jenjang Di atasnya</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group" style="margin-top: 0px">
                                            <button type="submit" class="btn btn-sm btn-info"> <i
                                                    class="fa fa-filter"></i>
                                                Filter</button>
                                            <a href="{{ url('dokpersonal') }}" class="btn btn-sm btn-default"> <i
                                                    class="fa fa-refresh"></i>
                                                Reset</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Akhir</span>
                                            <input id="f_awal_akhir" name="f_awal_akhir"
                                                value="{{ request()->get('f_awal_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Awal">
                                            <span class="input-group-addon customInput">To</span>
                                            <input id="f_akhir_akhir" name="f_akhir_akhir"
                                                value="{{ request()->get('f_akhir_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJK3</option>
                                                @foreach($instansi as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_pjk3') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->singkat_bu }} ({{ $key->nama_bu }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_kota" id="f_kota">
                                                <option selected value="">Kota_Personil</option>
                                                @foreach($kota as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_kota') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_jenis_dok" id="f_jenis_dok">
                                                <option selected value="">Jenis_Dok</option>
                                                @foreach($jenisdok as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_jenis_dok') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->kode_jns_dok }} ({{ $key->Nama_jns_dok }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_dok_ahli" id="f_dok_ahli">
                                                <option selected value="">Dok_Ahli</option>
                                                <option value="1"
                                                    {{ request()->get('f_dok_ahli') == "1" ? 'selected' : '' }}>Ahli
                                                </option>
                                                <option value="2"
                                                    {{ request()->get('f_dok_ahli') == "2" ? 'selected' : '' }}>Non-Ahli
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_penyelenggara"
                                                id="f_penyelenggara">
                                                <option selected value="">Penyelenggara</option>
                                                @foreach($penyelenggara as $key)
                                                <option value="{{ $key->penyelenggara }}"
                                                    {{ request()->get('f_penyelenggara') == $key->penyelenggara ? 'selected' : '' }}>
                                                    {{ $key->penyelenggara }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2dp">
                                            <select class="form-control select2" name="f_program_studi"
                                                id="f_program_studi">
                                                <option value="">Program_Studi</option>
                                                @foreach($prodi as $key)
                                                <option value="{{ $key->jurusan }}"
                                                    {{ request()->get('f_program_studi') == $key->jurusan ? 'selected' : '' }}>
                                                    {{ $key->jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8">
                    </div>
                    <div class="col-sm-2" style='text-align:right'>
                        <div class="row" style="margin-top:-3px;margin-bottom:3px">
                            <div class="col-xs-12">
                                {{-- <div class="btn-group">
                                    <span class="btn btn-primary" id="btnDetail"></i>
                                        Detail_Dok</span>
                                    <a href="{{ url('dokpersonal/detail') }}" class="btn btn-primary">
                                        Detail_Dok</a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <a href="{{ url('dokpersonal/create') }}" class="btn btn-info"> <i
                                            class="fa fa-user-plus"></i>
                                        Tambah</a>
                                    {{-- <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i
                                            class="fa fa-edit"></i>
                                        Ubah</a>
                                        <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i
                                                class="fa fa-trash"></i>
                                            Hapus</button> --}}
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
                        <th>Jns_Ush</th>
                        <th>PJK3</th>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th>Jns_Dok</th>
                        <th>Nama_Srtf</th>
                        <th>Instansi_Dok</th>
                        <th>No_Dok</th>
                        <th>Tgl_Terbit</th>
                        <th>Tgl_Akhir</th>
                        <th>Prov</th>
                        <th>Sekolah_P</th>
                        <th>Ket_P</th>
                        <th>NPWP</th>
                        <th>U_Tambah</th>
                        <!-- <th>User_Tgl_Tambah</th> -->
                        <th>U_Ubah</th>
                        <!-- <th>User_Tgl_Ubah</th> -->
                        <!-- <th>Pdf_Dok</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td style='text-align:center'>
                            <a href="{{ url('dokpersonal/'.$key->id.'/edit')}}" type="button" class="btn btn-xs btn-warning"><span class="fa fa-pencil"></span></a>
                            <button type="button" class="btn btn-xs btn-danger" onclick='hapusData("{{ $key->id }}")'><span class="fa fa-trash"></span></button>
                            <a class="btn btn-xs btn-success" href="{{ url('dokpersonal/detail') }}"><span class="fa fa-eye"></i></a>
                        </td>
                        <td style='text-align:center'>{{ $loop->iteration }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            @if($key->id_skp_pjk3)
                            {{isset($key->id_skp_pjk3) ? $key->bidang_ak3->jenis_usaha->kode_jns_usaha  : ''}} <br>
                            ({{isset($key->id_skp_pjk3) ? $key->bidang_ak3->jenis_usaha->nama_jns_usaha  : ''}})
                            @endif ">
                            {{ isset($key->id_skp_pjk3) ? $key->bidang_ak3->jenis_usaha->kode_jns_usaha  : '' }}
                        </td>
                        <td data-toggle="tooltip" data-placement="top" data-html="true" title="
                            @if($key->id_skp_pjk3)
                            {{isset($key->id_skp_pjk3) ? $key->badan_usaha_ak3->singkat_bu  : ''}} <br>
                            ({{isset($key->id_skp_pjk3) ? $key->badan_usaha_ak3->nama_bu  : ''}})
                            @endif ">
                            {{ isset($key->id_skp_pjk3) ? $key->badan_usaha_ak3->singkat_bu  : '' }}</td>
                        <td data-toggle="tooltip" data-placement="top" data-html="true" title="
                            Nama Personil : <br>
                            {{ isset($key->personal->id) ? $key->personal->nama : '' }}">
                            {{ isset($key->personal->id) ? str_limit($key->personal->nama,12) : '' }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            @if($key->id_bid_skp)
                            {{ isset($key->id_bid_skp) ? $key->bidang_ak3->kode_bidang : '' }} <br>
                            ({{ isset($key->id_bid_skp) ? $key->bidang_ak3->nama_bidang : '' }})
                            @endif ">
                            {{ isset($key->id_bid_skp) ? $key->bidang_ak3->kode_bidang : '' }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            @if($key->jns_dok)
                            {{ isset($key->jns_dok) ? $key->jenisdok_ak3->kode_jns_dok : '' }} <br>
                            ({{isset($key->jns_dok) ? $key->jenisdok_ak3->Nama_jns_dok  : ''}})
                            @endif ">
                            {{ isset($key->jns_dok) ? $key->jenisdok_ak3->kode_jns_dok : '' }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            @if($key->id_srtf_alat)
                            {{ isset($key->id_srtf_alat) ? $key->bid_sertifikat_alat->kode_srtf_alat : '' }} <br>
                            ({{ isset($key->id_srtf_alat) ? $key->bid_sertifikat_alat->nama_srtf_alat : '' }})
                            @endif ">
                            {{ isset($key->id_srtf_alat) ? $key->bid_sertifikat_alat->kode_srtf_alat : '' }}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                            @if($key->instansi_skp || $key->penyelenggara)
                            Nama Instansi : {{ $key->instansi_skp }} <br>
                            Nama Penyelenggara : {{ isset($key->penyelenggara) ? $key->penyelenggara : '' }}
                            @endif ">
                            {{ str_limit($key->instansi_skp,12) }}
                        </td>
                        <td style='text-align:center' style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                            @if($key->no_skp)
                            Nomor Dokumen : <br>{{$key->no_skp}}
                            @endif">
                            @if (isset($key->no_skp))
                                @if (isset($key->pdf_skp_ak3))
                                <button type="button" id="btnDokPdf" style="width:100%"
                                    onclick='tampilLampiran("{{ asset("uploads/$key->pdf_skp_ak3") }}","Dokumen")'
                                    class="btn btn-success btn-xs">
                                    {{str_limit($key->no_skp,12)}}</button>
                                @endif
                            @endif
                        </td>
                        <td style='text-align:right'>
                            {{ isset($key->tgl_skp) ? \Carbon\Carbon::parse($key->tgl_skp)->isoFormat("DD MMMM YYYY") : '' }}
                        </td>
                        <td style='text-align:right'>
                            @if($key->tgl_akhir_skp =='' || $key->tgl_akhir_skp == null) Berlaku Seumur Hidup
                            @elseif($key->tgl_akhir_skp == "x")
                            @else
                                @if($key->tgl_akhir_skp)
                                    @php
                                        $now =  \Carbon\Carbon::now();
                                        $habis = \Carbon\Carbon::parse($key->tgl_akhir_skp);
                                        $hari = $habis->diffInDays($now);
                                    @endphp
                                    @if(\Carbon\Carbon::parse($key->tgl_akhir_skp)->toDateTimeString() < \Carbon\Carbon::now()->toDateTimeString())
                                    <span class="text-danger" data-toggle="tooltip" data-placement="top" title="Tidak Berlaku dari {{ \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat('DD MMMM YYYY') }}">
                                    {{ isset($key->tgl_akhir_skp) ? \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat("DD MMMM YYYY") : ''}} </span>
                                    @elseif(\Carbon\Carbon::parse($key->tgl_akhir_skp)->toDateTimeString() < \Carbon\Carbon::now()->addMonths(3)->toDateTimeString())
                                    <span class="text-purple" data-toggle="tooltip" data-placement="top" title="Berlaku sampai {{ \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat('DD MMMM YYYY') }}, {{ $hari }} hari lagi">
                                    {{ isset($key->tgl_akhir_skp) ? \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat("DD MMMM YYYY") : ''}} </span>
                                    @else
                                    <span data-toggle="tooltip" data-placement="top" title="Berlaku sampai {{ \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat('DD MMMM YYYY') }}, {{ $hari }} hari lagi">
                                    {{ isset($key->tgl_akhir_skp) ? \Carbon\Carbon::parse($key->tgl_akhir_skp)->isoFormat("DD MMMM YYYY") : ''}} </span>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                            Prov : {{ isset($key->personal->kota_id) ? $key->personal->kota->provinsi->nama : '' }} <br>
                            Nama Kota : {{ isset($key->personal->kota_id) ? $key->personal->kota->nama : '' }} <br>
                            Alamat : {{ isset($key->personal->alamat) ? $key->personal->alamat : '' }} <br>
                            No HP : {{ isset($key->personal->no_hp) ? $key->personal->np_hp : '' }} <br>
                            Email : {{ isset($key->personal->email) ? $key->personal->email : '' }}">
                            {{ isset($key->personal->kota_id) ? $key->personal->kota->provinsi->nama_singkat : '' }}
                        </td>
                        <td data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            @if($key->personal->sekolah_p)
                            Nama Sekolah : {{ isset($key->personal->sekolah_p) ? $key->personal->sekolah_p->nama_sekolah : '' }} <br>
                            Jenjang : {{ isset($key->personal->sekolah_p) ? $key->personal->sekolah_p->jp->deskripsi : '' }} <br>
                            Prodi : {{ isset($key->personal->sekolah_p) ? $key->personal->sekolah_p->jurusan : '' }} <br>
                            Tahun : {{ isset($key->personal->sekolah_p) ? $key->personal->sekolah_p->tahun : '' }} <br>
                            No Ijasah : {{ isset($key->personal->sekolah_p) ? $key->personal->sekolah_p->no_ijazah : '' }} <br>
                            Tgl Ijasah : {{ isset($key->personal->sekolah_p) ? \Carbon\Carbon::parse($key->personal->sekolah_p->tgl_ijasah)->isoFormat("DD MMMM YYYY") : '' }}
                            @endif ">
                            @php
                                $jp = isset($key->personal->sekolah_p->jp) ? $key->personal->sekolah_p->jp->deskripsi : '';
                                $prodi = isset($key->personal->sekolah_p->jurusan) ? $key->personal->sekolah_p->jurusan : '';
                                $tahun =  isset($key->personal->sekolah_p->tahun) ? $key->personal->sekolah_p->tahun : '';
                                $sekolah_p = $jp.", ".$prodi.", ".$tahun;
                            @endphp
                            @if (isset($key->personal->sekolah_p))
                            {{ str_limit($sekolah_p,30) }}
                            @endif
                        </td>
                        <td data-toggle="tooltip" data-placement="top" data-html="true" title="
                                @foreach ($sklh as $select)
                                    @if($key->id_personal == $select->id_personal)
                                    Nama Sekolah : {{ isset($key->personal->sekolah) ? $select->nama_sekolah : '' }} <br>
                                    Jenjang : {{ isset($key->personal->sekolah) ? $select->jp->deskripsi : '' }} <br>
                                    Prodi : {{ isset($key->personal->sekolah) ? $select->jurusan : '' }} <br>
                                    Tahun : {{ isset($key->personal->sekolah) ? $select->tahun : '' }} <br>
                                    No Ijasah : {{ isset($key->personal->sekolah) ? $select->no_ijazah : '' }} <br>
                                    Tgl Ijasah : {{ isset($key->personal->sekolah) ? \Carbon\Carbon::parse($select->tgl_ijasah)->isoFormat("DD MMMM YYYY") : '' }} <br>
                                    @endif
                                @endforeach ">

                            @foreach ($sklh as $select)
                                @if($key->id_personal == $select->id_personal)
                                    @php
                                        $ket_p = $select->jp->deskripsi.", ".$select->jurusan.", ".$select->tahun;
                                    @endphp
                                    @if (isset($key->personal->sekolah))
                                    {{ str_limit($ket_p,30) }}
                                    @endif
                                @endif
                            @endforeach
                        </td>
                        {{-- <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true"
                            title="
                            NPWP : {{ isset($key->id_skp_pjk3) ? $key->skp_pjk3->badan_usaha->npwp : '' }} <br>
                        No Rek :
                        {{ isset($key->skp_pjk3->badan_usaha->no_rek) ? $key->skp_pjk3->badan_usaha->no_rek : '' }} <br>
                        Nama Rek :
                        {{ isset($key->skp_pjk3->badan_usaha->nama_rek) ? $key->skp_pjk3->badan_usaha->nama_rek : '' }}
                        <br>
                        Nama Bank :
                        {{ isset($key->skp_pjk3->badan_usaha->id_bank) ? $key->skp_pjk3->badan_usaha->bank->Nama_Bank : '' }}">
                        {{ isset($key->id_skp_pjk3) ? $key->skp_pjk3->badan_usaha->npwp  : '' }}</td> --}}
                        <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                            NPWP : {{ isset($key->id_personal) ? $key->personal->npwp : '' }} <br>
                            No Rek : {{ isset($key->id_personal) ? $key->personal->no_rek : '' }} <br>
                            Nama Rek : {{ isset($key->id_personal) ? $key->personal->nama_rek : '' }} <br>
                            Nama Bank : {{ isset($key->personal->bank) ? $key->personal->bank->Nama_Bank : '' }}">
                            @if (isset($key->id_personal))
                            @if (isset($key->personal->npwp_pdf))
                            <button type="button" id="btnDokPdf"
                                onclick='tampilLampiran("/uploads/{{$key->personal->npwp_pdf}}","NPWP")'
                                class="btn btn-success btn-xs">
                                </i>{{$key->personal->npwp}}</button>
                            @else
                            <button type="button" id="btnDokPdf" class="btn btn-warning btn-xs">
                                </i>{{$key->personal->npwp}}</button>
                            @endif
                            @endif
                        </td>
                        <td style="width:5%; text-align: center; " data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title=" @if (isset($key->created_at))
                            Tanggal Tambah : {{ \Carbon\Carbon::parse($key->created_at)->isoFormat('DD MMMM YYYY H:mm:s') }} @endif">
                            @if($key->created_by) {{ucfirst($key->created_r->name)}} @endif
                        </td>
                        <td style="width:5%; text-align: center;" data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="  @if (isset($key->updated_at))
                        Tanggal Ubah : {{ \Carbon\Carbon::parse($key->updated_at)->isoFormat('DD MMMM YYYY H:mm:s') }} @endif">
                            @if($key->updated_by) {{ucfirst($key->updated_r->name)}} @endif</td>
                        <!-- <td style='text-align:center'>

                            @if (isset($key->pdf_skp_ak3))
                            <button type="button" id="btnDokPdf"
                                onclick='tampilLampiran("{{ asset("uploads/$key->pdf_skp_ak3") }}","Dokumen")'
                                class="btn btn-success btn-xs">
                                <i class="fa fa-file-pdf-o"></i> Lihat</button>
                            @endif
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
            {{-- end of car data  --}}


            <!-- Modal Detail Personil-->
            <div class="modal fade" id="modaldetail" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <h4 class="modal-title"><b>Detail Data Dokumen Personil PJK3 Mandiri</b></h4>
                        </div>
                        <div class="modal-body">
                            <!-- Modal Body -->
                            <div class="box" style="margin-top:-15px">
                                <div class="box-body no-padding">
                                    <table id="masterModal" class="table table-condensed tableModal">
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
                            <button type="button" class="btn btn-default btn-lg center-block" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i> Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Modal Detail Personil-->

            <!-- /.box-body -->
            <div class="box-footer"></div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('dokpersonal/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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
<!-- End Modal Konfirmasi Delete -->

<!-- Modal Lampiran -->
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
<!-- End of Modal Lampiran -->
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

    function showData(id) {
        url = id;
        // window.location.href = "{{ url('personil') }}/" + url + "/show";
        getDataDetail(id);

    }

    $(function () {
        //Pilih Filter Jns Usaha on Change
        $(document).on('change', '#f_jenis_usaha', function (e) {
            id_jnsusaha = $(this).val();

            jnsusahachange(id_jnsusaha);
        });

        // Fungsi Filter ketika memilih jenis usaha menampilkan bidang
        function jnsusahachange(id_jnsusaha) {
            var url = "{{ url('select_jns_usaha_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jnsusaha: id_jnsusaha
                },
                success: function (data) {
                    for (let index = 0; index < data['dataBidang'].length; index++) {
                        data['dataBidang'][index]['text'] = data['dataJnsUsaha']['kode_jns_usaha'] +
                            ' - ' + data['dataBidang'][index]['text'];
                    }
                    $("#f_bidang_dok").empty();
                    $("#f_bidang_dok").html(
                        "<option value='' selected>Bidang_Dok</option>");
                    $("#f_bidang_dok").select2({
                        data: data['dataBidang']
                    }).val(null).trigger('trigger');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        //Pilih Filter Jns Usaha on Change
        $(document).on('change', '#f_bidang_dok', function (e) {
            id_bidangdok = $(this).val();

            bidangdokchange(id_bidangdok);
        });


        // Fungsi Get Data Detail
        function getDataDetail(id) {
            var url = "{{ url('detail_dokpersonil_modal') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_skp_ak3: id
                },
                success: function (data) {
                    console.log(data);
                    $('#tableModalDetail > tbody').html(`
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Prov</th>
                            <th>Instansi_Dok</th>
                            <th>No_Dok</th>
                            <th>Tgl_Terbit</th>
                            <th>Tgl_Akhir</th>
                            <th>Sekolah_P</th>
                            <th>Ket_P</th>
                            <th>Pdf_Dok</th>
                        </tr>
                    `);

                    if (data.length > 0) {
                        data.forEach(function (item, index) {
                            // if(index == 0) {
                            changedata(index, data);
                            // add_row(index, data);
                            // }
                        });
                        $('#modaldetail').modal('show');
                    } else {
                        Swal.fire({
                            title: "Data Dokumen Personil tidak ditemukan !",
                            type: 'error',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#AAA'
                        });
                    }
                },
                error: function (xhr, status) {
                    Swal.fire('terjadi Error');
                }
            });
        }
        // Fungsi Filter ketika memilih jenis usaha menampilkan bidang
        function bidangdokchange(id_bidangdok) {
            var url = "{{ url('select_bidang_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_bidangdok: id_bidangdok
                },
                success: function (data) {
                    for (let index = 0; index < data['data1'].length; index++) {
                        data['data1'][index]['text'] = data['data1'][index]['text'] +
                            ' (' + data['data2'][index]['text'] + ')';
                    }
                    $("#f_jenis_dok").empty();
                    $("#f_jenis_dok").html(
                        "<option value='' selected>Jenis_Dok</option>");
                    $("#f_jenis_dok").select2({
                        data: data['data1']
                    }).val(null).trigger('trigger');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Cache Warna Filter
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
        if ("{{request()->get('f_jenis_usaha')}}" != "") {
            selectFilterCache("f_jenis_usaha");
        }
        if ("{{request()->get('f_pjk3')}}" != "") {
            selectFilterCache("f_pjk3");
        }
        if ("{{request()->get('f_provinsi')}}" != "") {
            selectFilterCache("f_provinsi");
        }
        if ("{{request()->get('f_kota')}}" != "") {
            selectFilterCache("f_kota");
        }
        if ("{{request()->get('f_jenis_dok')}}" != "") {
            selectFilterCache("f_jenis_dok");
        }
        if ("{{request()->get('f_bidang_dok')}}" != "") {
            selectFilterCache("f_bidang_dok");
        }
        if ("{{request()->get('f_nama_dok')}}" != "") {
            selectFilterCache("f_nama_dok");
        }
        if ("{{request()->get('f_dok_ahli')}}" != "") {
            selectFilterCache("f_dok_ahli");
        }
        if ("{{request()->get('f_instansi_dok')}}" != "") {
            selectFilterCache("f_instansi_dok");
        }
        if ("{{request()->get('f_penyelenggara')}}" != "") {
            selectFilterCache("f_penyelenggara");
        }
        if ("{{request()->get('f_jenjang_pendidikan')}}" != "") {
            selectFilterCache("f_jenjang_pendidikan");
        }
        if ("{{request()->get('f_program_studi')}}" != "") {
            selectFilterCache("f_program_studi");
        }

        // Rubah Warna Filter
        inputFilter("f_awal_terbit");
        inputFilter("f_akhir_terbit");
        inputFilter("f_awal_akhir");
        inputFilter("f_akhir_akhir");
        selectFilter("f_jenis_usaha");
        selectFilter("f_pjk3");
        selectFilter("f_provinsi");
        selectFilter("f_kota");
        selectFilter("f_jenis_dok");
        selectFilter("f_bidang_dok");
        selectFilter("f_nama_dok");
        selectFilter("f_dok_ahli");
        selectFilter("f_instansi_dok");
        selectFilter("f_penyelenggara");
        selectFilter("f_jenjang_pendidikan");
        selectFilter("f_program_studi");

        // Filter kota berdasarkan provinsi
        $('#f_provinsi').on('select2:select', function () {
            var id = $(this).val();
            var url = `{{ url('chain/filterprovdokperson') }}`;
            chainedProvinsiDokpersonil(url, 'f_provinsi', 'f_kota', "Kota Personil");
        });

        // format input
        $('[data-mask]').inputmask()

        // Fungsi Button Show Detail
        $('#btnDetail').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih untuk di tampilkan",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk di tampilkan",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                url = id[0];
                window.location.href = "{{ url('dokpersonal') }}/detail";
                // getDataDetail(id[0]);
            }
        });

        // Fungsi Button Edit
        $('#btnEdit').on('click', function (e) {
            e.preventDefault();
            var id = [];

            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih untuk di ubah",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk di ubah",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else if(id[0] == 0){
                Swal.fire({
                    title: "Personil harus di tambah terlebih dahulu",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            }
            else {
                url = id[0];
                window.location.href = "{{ url('dokpersonal') }}/" + url + "/edit";
            }
        });

        // Fungsi Button Hapus
        $('#btnHapus').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idHapusData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih untuk di hapus",
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            } else {
                $('#modal-konfirmasi').modal('show');
            }
        });


        // Fungsi Change Data Modal
        function changedata(index, data) {
            $('#masterModal > tbody').html(`
                <tr>
                    <th colspan="5" style="text-align:center">` + cekNull(data[index]['skp_pjk3']['badan_usaha'][
                'nama_bu'
            ]) + `</th>
                </tr>
                <tr>
                <td style="width:15%"></td>
                    <th style="width:15%;text-align:right">Nama Dokumen :</th>
                    <td style="width:20%">` + cekNull(data[index]['jenisdok_ak3']['Nama_jns_dok']) + `</td>
                    <th style="width:15%;text-align:right"</th>
                    <td style="width:35%"></td>
                </tr>
                <tr>
                <td style="width:15%"></td>
                    <th style="width:15%;text-align:right">Bidang Dok : </th>
                    <td style="width:20%">` + cekNull(data[index]['bidang_ak3']['nama_bidang']) + `</td>
                    <th style="width:15%;text-align:right">Jenis Dok : </th>
                    <td style="width:35%">` + cekNull(data[index]['jenisdok_ak3']['kode_jns_dok']) + `</td>
                </tr>

            `);
        }

        // Fungsi menambah baris modal detail
        function add_row(index, data) {
            var jp = data[index]['personal']['sekolah']['id_jenjang'];
            if (jp == '' || jp == null) {
                jp = "-";
            } else {
                jp = data[index]['personal']['sekolah']['jp']['deskripsi'];
            }
            var prov_s = data[index]['personal']['sekolah']['prop_sekolah'];
            if (prov_s == '' || prov_s == null) {
                prov_s = "-";
            } else {
                prov_s = data[index]['personal']['sekolah']['prov_s']['nama'];
            }
            var kota_s = data[index]['personal']['sekolah']['kota_sekolah'];
            if (kota_s == '' || kota_s == null) {
                kota_s = "-";
            } else {
                kota_s = data[index]['personal']['sekolah']['kota_s']['nama'];
            }
            if (data[index]['personal']['sekolah']['default'] == 1) {
                dflt = 'Default';
            } else {
                dflt = '';
            }
            $('#tableModalDetail > tbody:last').append(`
                <tr>
                    <td align="center">` + (index + 1) + `</td>
                    <td align="center">` + cekNull(jp) + `</td>
                    <td align="center">` + cekNull(data[index]['personal']['sekolah']['nama_sekolah']) + `</td>
                    <td align="center">` + cekNull(prov_s) + `</td>
                    <td align="center">` + cekNull(kota_s) + `</td>
                    <td align="center">` + cekNull(data[index]['personal']['sekolah']['jurusan']) + `</td>
                    <td align="center">` + cekNull(data[index]['personal']['sekolah']['tahun']) + `</td>
                    <td align="center">` + cekNull(data[index]['personal']['sekolah']['no_ijazah']) + `</td>
                    <td align="center">` + cekNull(tanggal_indonesia(data[index]['personal']['sekolah'][
                'tgl_ijasah'
            ])) + `</td>
                    <td align="center">` + cekNull(dflt) + `</td>
                    <td align="center"><a target="_blank" class="fa fa-file-pdf-o" href="uploads/` + data[index][
                'personal'
            ]['sekolah']['pdf_ijasah'] + `"></a></td>
                </tr>
            `);

            var tgl_skp = tanggal_indonesia(data[index]['tgl_skp']);
            var tgl_akhir_skp = data[index]['tgl_akhir_skp'];
            if (tgl_akhir_skp == '' || tgl_akhir_skp == null) {
                tgl_akhir_skp = 'Berlaku Seumur Hidup';
            } else {
                tgl_akhir_skp = tanggal_indonesia(tgl_akhir_skp);
            }
            $('#tableModalDetailAk3 > tbody:last').append(`
                <tr>
                    <td align="center">` + (index + 1) + `</td>
                    <td align="center">` + cekNull(data[index]['bidang_ak3']['kode_bidang']) + `</td>
                    <td align="center">` + cekNull(data[index]['bid_sertifikat_alat']['kode_srtf_alat']) + `</td>
                    <td align="center">` + cekNull(data[index]['jenisdok_ak3']['kode_jns_dok']) + `</td>
                    <td align="center">` + cekNull(data[index]['jenisdok_ak3']['Nama_jns_dok']) + `</td>
                    <td align="center">` + cekNull(data[index]['instansi_skp']) + `</td>
                    <td align="center">` + cekNull(data[index]['penyelenggara']) + `</td>
                    <td align="center">` + cekNull(data[index]['no_skp']) + `</td>
                    <td align="center">` + cekNull(tgl_skp) + `</td>
                    <td align="center">` + cekNull(tgl_akhir_skp) + `</td>
                    <td align="center"><a target="_blank" class="fa fa-file-pdf-o" href="uploads/` + data[index][
                'pdf_skp_ak3'
            ] + `"></a></td>
                </tr>
            `);
        }

    });

    //Initialize Select2 Elements
    $('.select2').select2();

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
