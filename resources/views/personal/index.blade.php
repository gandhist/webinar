@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    span.indent{
        text-indent: 25px;
    }
</style>
<section class="content-header">
    <h1>
        Daftar Personal
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="{{ url('/personals') }}"> Personal</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="box-body" style="margin:25px 25px 25px 10px;">
                {{-- sub menu  --}}
                <form action="{{ url('personals/filter') }}" enctype="multipart/form-data" name="filterData" id="filterData"
                method="post">
                @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Table Filter -->
                            <table class="table table-condensed table-filter">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon customInput">Tgl Ijasah</span>
                                                <input id="f_awal_ijasah" name="f_awal_ijasah"
                                                    value="{{ request()->get('f_awal_ijasah') }}" autocomplete="off"
                                                    data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                    class="form-control customInput" placeholder="Tgl Awal">
                                                <span class="input-group-addon customInput">To</span>
                                                <input id="f_akhir_ijasah" name="f_akhir_ijasah"
                                                    value="{{ request()->get('f_akhir_ijasah') }}" autocomplete="off"
                                                    data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                    class="form-control customInput" placeholder="Tgl Akhir">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group customSelect2md">
                                                <select class="form-control select2" name="f_status" id="f_status">
                                                    <option selected value="">Status_Personil</option>
                                                    <option value="1"
                                                        {{ request()->get('f_status') == "1" ? 'selected' : '' }}>Internal
                                                    </option>
                                                    <option value="2"
                                                        {{ request()->get('f_status') == "2" ? 'selected' : '' }}>External
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group customSelect2md">
                                                <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                    <option selected value="">Prov_Domisili</option>
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
                                                <select class="form-control select2" name="f_jenjang_pendidikan"
                                                    id="f_jenjang_pendidikan" placeholder="Jenjang Pendidikan">
                                                    <option selected value="">Jenjang Pendidikan</option>
                                                    @foreach($jenjang_pendidikan as $key)
                                                    <option value="{{ $key->id_jenjang }}"
                                                        {{ request()->get('f_jenjang_pendidikan') == $key->id_jenjang ? 'selected' : '' }}>
                                                        {{ $key->deskripsi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-filter"></i>
                                                    Filter</button>
                                                <button type="button" class="btn btn-default"><a
                                                        href="{{ url('personals') }}"> <i class="fa fa-refresh"></i>
                                                        Reset</a></button>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <div class="input-group customSelect2md">
                                                <select class="form-control select2" name="f_kota" id="f_kota">
                                                    <option selected value="">Kota_Domisili</option>
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
                                                <select class="form-control select2" name="f_program_studi"
                                                    id="f_program_studi">
                                                    <option value="">Program Studi</option>
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

                        <div class="col-sm-3">
                        </div>

                        <div class="col-sm-3" style='text-align:right'>
                            <div class="row" style="margin-top:-3px;margin-bottom:3px">
                                <div class="col-xs-12">
                                    <div class="btn-group">
                                        <span class="btn btn-primary" id="btnDetail"></i>
                                            Detail_Personil</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="btn-group">
                                        <a href="{{ url('personals/create') }}" class="btn btn-info">
                                            <i class="fa fa-plus"></i> Tambah</a>
                                        <button class="btn btn-success" id="btnEdit" name="btnEdit">
                                            <i class="fa fa-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger" id="btnHapus" name="btnHapus">
                                            <i class="fa fa-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
                    <div class="col-12">
                        <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                            <thead>
                                <tr>
                                    <th style="text-indent: 12px;"><i class="fa fa-check-square-o"></i></th>
                                    <th style="text-indent: 22px;">No</th>
                                    <!-- <th>Reff</th> -->
                                    <th>Status</th>
                                    <th>Nama</th>
                                    <th>Prov</th>
                                    {{-- <th>Kota</th> --}}
                                    <th>Sekolah_P</th>
                                    <th>Ket_P</th>
                                    <th>Lahir</th>
                                    <th>NPWP</th>
                                    {{-- <th>No_Rek</th>
                                    <th>Nama_Rek</th>
                                    <th>Bank_Rek</th> --}}
                                    <th>Pdf_Foto</th>
                                    <th>Pdf_KTP</th>
                                    <th>BPJS_Kes</th>
                                    <!-- <th>Pdf_NPWP</th> -->
                                    <th>User_Tambah</th>
                                    <th>User_Ubah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($personals as $personal)
                                @php
                                    $username =  preg_replace('/[^a-zA-Z0-9()]/', '_', $personal->nama);
                                @endphp
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $personal->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>
                                    <td style='text-align:center'>{{ $loop->iteration }}</td>
                                    <td>@if ($personal->status_p =='1') Internal @elseif ($personal->status_p =='2') External @endif</td>
                                    <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        Jenis Kelamin : @if ($personal->jenis_kelamin =='L') Laki-laki @elseif ($personal->jenis_kelamin =='P') Perempuan @endif<br>
                                        Agama : {{ ucfirst($personal->agama) }}<br>
                                        Sts Pernikahan : @if ($personal->status_pernikahan =='BK') Belum Kawin @elseif ($personal->status_pernikahan =='K') Kawin @elseif ($personal->status_pernikahan =='CH') Cerai Hidup @elseif ($personal->status_pernikahan =='CM') Cerai Mati @endif<br>
                                        Sts PTKP : {{ $personal->ptkp_r->nama_ptkp ?? '' }}<br>
                                        Alamat KTP : {{ $personal->alamat_ktp }}<br>
                                        Prov KTP : {{ isset($personal->kota_ktp->provinsi->nama) ? $personal->kota_ktp->provinsi->nama : '' }}<br>
                                        Kota KTP : {{ $personal->kota_id_ktp ? $personal->kota_ktp->nama : '' }}<br>">
                                        {{ $personal->nama }}
                                    </td>
                                    <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        Provinsi Domisili : {{ isset($personal->kota->provinsi->nama) ? $personal->kota->provinsi->nama : '' }} <br>
                                        Kota Domisili : {{ $personal->kota_id ? $personal->kota->nama : '' }} <br>
                                        Alamat Domisili : {{ $personal->alamat }} <br>
                                        No HP : {{ $personal->no_hp }} <br>
                                        Email : {{ $personal->email }} <br>
                                        NIK : {{ $personal->nik }} <br>">
                                        {{ isset($personal->kota->provinsi->nama) ? $personal->kota->provinsi->nama_singkat : '' }}</td>
                                    <td data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        No Ijasah : {{ isset($personal->sekolah_p) ? $personal->sekolah_p->no_ijazah : '' }} <br>
                                        Tgl Ijasah : {{ isset($personal->sekolah_p) ? \Carbon\Carbon::parse($personal->sekolah_p->tgl_ijasah)->isoFormat("DD MMMM YYYY") : '' }} <br>
                                        Nama Sekolah : {{ isset($personal->sekolah_p) ? $personal->sekolah_p->nama_sekolah : '' }}">
                                        {{-- {{$personal->sekolah_p}} --}}
                                        @if ( empty($personal->sekolah_p->id_jenjang)&&
                                        empty($personal->sekolah_p->jurusan) &&
                                        empty($personal->sekolah_p->tahun) )
                                        @else
                                        {{ isset($personal->sekolah_p->jp) ? $personal->sekolah_p->jp->deskripsi : '' }},
                                        {{ isset($personal->sekolah_p->jurusan) ? $personal->sekolah_p->jurusan : '' }},
                                        {{ isset($personal->sekolah_p->tahun) ? $personal->sekolah_p->tahun : '' }}
                                        @endif
                                    </td>
                                    <td data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        @foreach ($sklh as $select)
                                            @if($personal->id == $select->id_personal)
                                            No Ijasah : {{ isset($personal->sekolah->no_ijazah) ? $select->no_ijazah : '' }} <br>
                                            Tgl Ijasah : {{ isset($personal->sekolah) ? \Carbon\Carbon::parse($select->tgl_ijasah)->isoFormat("DD MMMM YYYY") : '' }} <br>
                                            Nama Sekolah : {{ isset($personal->sekolah->nama_sekolah) ? $select->nama_sekolah : '' }} <br>
                                            @endif
                                        @endforeach ">
                                        @foreach ($sklh as $select)
                                            {{-- {{$personal->sekolah_p}} --}}
                                            @if($personal->id == $select->id_personal)
                                                @if ( empty($personal->sekolah_p->id_jenjang)&&
                                                empty($personal->sekolah_p->jurusan) &&
                                                empty($personal->sekolah_p->tahun) )
                                                @else
                                                {{ isset($personal->sekolah->jp) ? $select->jp->deskripsi : '' }},
                                                {{ isset($personal->sekolah->jurusan) ? $select->jurusan : '' }},
                                                {{ isset($personal->sekolah->tahun) ? $select->tahun : '' }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($personal->temp_lahir == '' || $personal->temp_lahir ==null && $personal->tgl_lahir== '' ||
                                        $personal->tgl_lahir==null)
                                        @else
                                        {{ isset($personal->temp_lahir) ? $personal->tempLahir->ibu_kota : '' }},
                                        {{ isset($personal->tgl_lahir) ? \Carbon\Carbon::parse($personal->tgl_lahir)->isoFormat("DD MMMM YYYY") : '' }}
                                        @endif
                                    </td>
                                    <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        Nama_Rek : {{ isset($personal->no_rek) ? $personal->no_rek : '' }} <br>
                                        Nama_Rek: {{ isset($personal->nama_rek) ? $personal->nama_rek : '' }} <br>
                                        Bank_Rek : {{ isset($personal->id_bank) ? $personal->bank->Nama_Bank : '' }}">

                                        @if (isset($personal->npwp))
                                        @if (isset($personal->lampiran_npwp))
                                        <button type="button" id="btnNpwpPdf"
                                            onclick='tampilLampiran("{{ asset($personal->lampiran_npwp) }}","NPWP")'
                                            class="btn btn-success btn-xs">
                                            {{ $personal->npwp }}</button>
                                        @else
                                        <button type="button"
                                            class="btn btn-warning btn-xs">
                                            {{ $personal->npwp }}</button>
                                        @endif
                                        @endif
                                    </td>
                                    {{-- <td>{{ $personal->no_rek }}</td>
                                    <td>{{ $personal->nama_rek }}</td>
                                    <td>{{ isset($personal->bank->id_bank) ? $personal->bank->Nama_Bank : ''}}</td> --}}
                                    <td style='text-align:center'>
                                        @if (isset($personal->lampiran_foto))
                                        <button type="button" id="btnKtpPdf"
                                            onclick='tampilLampiran("{{ asset($personal->lampiran_foto) }}","Foto")'
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-file-pdf-o"></i> Lihat</button>
                                        @endif
                                    </td>
                                    <td style='text-align:center'>
                                        @if (isset($personal->lampiran_ktp))
                                        <button type="button" id="btnKtpPdf"
                                            onclick='tampilLampiran("{{ asset($personal->lampiran_ktp) }}","KTP")'
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-file-pdf-o"></i> Lihat</button>
                                        @endif
                                    </td>
                                    <td style='text-align:center'>
                                        @if (isset($personal->lampiran_bpjs))
                                        <button type="button" id="btnKtpPdf"
                                            onclick='tampilLampiran("{{ asset($personal->lampiran_bpjs) }}","BPJS")'
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-file-pdf-o"></i> Lihat</button>
                                        @endif
                                    </td>
                                    {{-- <td data-toggle="tooltip" data-placement="bottom" title="{{ $personal->nama }}">
                                        <a href="{{ url('personals/'.$personal->id) }}">
                                            {{ str_limit($personal->nama,20) }}
                                        </a>
                                    </td>
                                    <td> {{ $personal->no_hp }} </td>
                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $personal->email }}">
                                        {{ str_limit($personal->email,20) }} </td>
                                    @if(isset($personal->instansi, $bu))
                                        <td data-toggle="tooltip" data-placement="bottom" title="{{ $bu[$personal->instansi] }}">
                                            {{ str_limit($bu[$personal->instansi],20 )}}
                                        </td>
                                    @else
                                        <td>Tidak Bisa Menampilkan</td>
                                    @endif

                                    <td> {{ str_limit($personal->jabatan, 20)}} </td>
                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $personal->alamat }}">
                                        {{ str_limit($personal->alamat, 20) }} </td>
                                    <td>
                                        {{ $kotas[$personal->temp_lahir] }}, {{ isset($personal->tgl_lahir) ? \Carbon\Carbon::parse($personal->tgl_lahir)->isoFormat("DD MMMM YYYY") : ''  }}
                                    </td>
                                    <td class="text-center">
                                         <a href="{{ url(urlencode($personal->lampiran_foto))}}">Lihat</a>
                                        <a data-toggle="modal" data-target="#myModal" data-link="{{isset($personal->lampiran_foto) ? url($personal->lampiran_foto) : '' }}">
                                            Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                    </td> --}}
                                    <td
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-html="true" title="
                                            {{isset($personal->user_create) ? $personal->user_create->name : ''}}
                                            {{ ( isset($personal->user_create) && isset($personal->created_at) ) ? ' , ' : '' }}
                                            {{ isset($personal->created_at) ? \Carbon\Carbon::parse($personal->created_at)->isoFormat("DD MMMM YYYY") : ''}}
                                    ">
                                        @if (isset($personal->created_at))
                                        {{ \Carbon\Carbon::parse($personal->created_at)->isoFormat("DD MMMM YYYY") }}
                                        @else
                                        {{''}}
                                        @endif
                                    </td>
                                    <td
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-html="true" title="
                                            {{isset($personal->user_update) ? $personal->user_update->name : ''}}
                                            {{ ( isset($personal->user_update) && isset($personal->updated_at) ) ? ' , ' : '' }}
                                            {{ isset($personal->updated_at) ? \Carbon\Carbon::parse($personal->updated_at)->isoFormat("DD MMMM YYYY") : ''}}
                                    ">
                                        @if (isset($personal->updated_at))
                                        {{ \Carbon\Carbon::parse($personal->updated_at)->isoFormat("DD MMMM YYYY") }}
                                        @else
                                        {{''}}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
          <h4 class="modal-title" id="myModalLabel">Brosur Seminar</h4>
        </div>
        <div class="modal-body">
            <center>
            <img alt="Brosur Seminar" class="img-thumbnail center" style="width:50%">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('personals/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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

 <!-- Modal Detail Personil-->
 <div class="modal fade" id="modaldetail" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1500px">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                <h4 class="modal-title"><b>Detail Data Personal PJK3 Mandiri</b></h4>
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
    $('.select2').select2();

    // Filter kota berdasarkan provinsi
    $('#f_provinsi').on('select2:select', function () {
        var id = $(this).val();
        var url = `{{ url('chain/filterprovpersonil') }}`;
        chainedProvinsiPersonil(url, 'f_provinsi', 'f_kota', "Kota_Domisili");
    });

    // Fungsi Button Show Detail
    $('#btnDetail').on('click', function (e) {
        e.preventDefault();
        var id = [];
        $('.selection:checked').each(function () {
            id.push($(this).data('id'));
        });
        if (id.length == 0) {
            Swal.fire('Tidak ada data yang terpilih untuk di tampilkan',
                '',
                'warning');
        } else if (id.length > 1) {
            Swal.fire('Harap pilih satu data untuk di tampilkan',
                '',
                'warning');
        } else {
            url = id[0];
            // window.location.href = "{{ url('personil') }}/" + url + "/show";
            getDataDetail(id[0]);
            // $('#modaldetail').modal('show');
        }
    });

    // Fungsi Get Data Detail
    function getDataDetail(id) {
        var url = "{{ url('detail_personil_modal') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                id_personal: id
            },
            success: function (data) {
                console.log(data);
                $('#tableModalDetail > tbody').html(`
                    <tr>
                        <th>No</th>
                        <th>Jenjang Pendidikan</th>
                        <th>Nama Sekolah</th>
                        <th>Negara Sekolah</th>
                        <th>Prov Sekolah</th>
                        <th>Kota Sekolah</th>
                        <th>Prodi</th>
                        <th>Tahun_Tamat</th>
                        <th>No_Ijasah</th>
                        <th>Tgl_Ijasah</th>
                        <th>Default</th>
                    </tr>
                `);
                if (data.length > 0) {
                    data.forEach(function (item, index) {
                        // if (index > 0) {
                        changedata(index, data);
                        // }
                        add_row(index, data);
                    });
                    $('#modaldetail').modal('show');
                } else {
                    Swal.fire('Data Personil  tidak ditemukan !',
                        '',
                        'error')
                }
            },
            error: function (xhr, status) {
                Swal.fire('terjadi Error');
            }
        });
    }


    // Fungsi Change Data Modal
    function changedata(index, data) {
        if (data[index]['personil']['status_p'] == 1) {
            data[index]['personil']['status_p'] = 'Internal';
        } else {
            data[index]['personil']['status_p'] = 'External';
        }

        if (data[index]['personil']['jns_kelamin'] == 'L') {
            data[index]['personil']['jns_kelamin'] = 'Laki-laki';
        } else {
            data[index]['personil']['jns_kelamin'] = 'Perempuan';
        }

        if (data[index]['personil']['bank'] == '' || data[index]['personil']['bank'] == null) {
            namaBank = '';
        } else {
            namaBank = data[index]['personil']['bank']['Nama_Bank'];
        }

        $('#masterModal > tbody').html(`

            <tr>

                <th colspan="5" style="text-align:center">` + cekNull(data[index]['personil']['nama']) + `</th>


            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Refferensi : </th>
                <td style="width:20%">` + cekNull(data[index]['personil']['reff_p']) + `</td>
                <th style="width:15%;text-align:right">Status : </th>
                <td style="width:35%">` + cekNull(data[index]['personil']['status_p']) + `</td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Jenis Kelamin : </th>
                <td style="width:20%">` + cekNull(data[index]['personil']['jns_kelamin']) + `</td>
                <th style="width:15%;text-align:right">Pdf_Foto : </th>
                <td style="width:35%"><a target="_blank" href="uploads/` + cekNull(data[index]['personil'][
            'foto_pdf'
        ]) + `"><i class="fa fa-file-pdf-o"></i></a></td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">NIK : </th>
                <td style="width:20%">` + cekNull(data[index]['personil']['nik']) + `</td>
                <th style="width:15%;text-align:right">Pdf_KTP : </th>
                <td style="width:35%"><a target="_blank" href="uploads/` + cekNull(data[index]['personil'][
            'ktp_pdf'
        ]) + `"><i class="fa fa-file-pdf-o"></i></a></td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Alamat : </th>
                <td style="width:20%">` + cekNull(data[index]['personil']['alamat']) + `</td>
                <th style="width:15%;text-align:right"></th>
                <td style="width:35%"></td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Provinsi Alamat :</th>
                <td style="width:20%">` + cekNull(data[index]['personil']['kota']['provinsi']['nama']) + `</td>
                <th style="width:15%;text-align:right">Kota Alamat :</th>
                <td style="width:35%">` + cekNull(data[index]['personil']['kota']['nama']) + `</td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">No HP :</th>
                <td style="width:20%">` + cekNull(data[index]['personil']['hp_wa']) + `</td>
                <th style="width:15%;text-align:right">Email :</th>
                <td style="width:35%">` + cekNull(data[index]['personil']['email_p']) + `</td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Tempat Lahir :</th>
                <td style="width:20%">` + cekNull(data[index]['personil']['temp_lahir']['ibu_kota']) + `</td>
                <th style="width:15%;text-align:right">Tgl Lahir :</th>
                <td style="width:35%">` + cekNull(tanggal_indonesia(data[index]['personil']['tgl_lahir'])) + `</td>
            </tr>
            <tr>git pull
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">NPWP :</th>
                <td style="width:20%">` + cekNull(data[index]['personil']['npwp']) + `</td>
                <th style="width:15%;text-align:right">Pdf_NPWP :</th>
                <td style="width:35%"><a target="_blank" href="uploads/` + cekNull(data[index]['personil'][
            'npwp_pdf'
        ]) + `"><i class="fa fa-file-pdf-o"></i></a></td>
            </tr>
            <tr>
            <td style="width:15%"></td>
                <th style="width:15%;text-align:right">No Rekening Bank :</th>
                <td style="width:20%">` + cekNull(data[index]['personil']['no_rek']) + `</td>
                <th style="width:15%;text-align:right">Nama Rekening Bank :</th>
                <td style="width:35%">` + cekNull(data[index]['personil']['nama_rek']) + `</td>
            </tr>
            <tr>
                <td style="width:15%"></td>
                <th style="width:15%;text-align:right">Nama Bank :</th>
                <td style="width:20%">` + cekNull(namaBank) + `</td>
                <th style="width:15%;text-align:right"></th>
                <td style="width:35%"></td>
            </tr>
        `);
    }

    // Fungsi menambah baris modal detail
    function add_row(index, data) {
        if (data[index]['jp'] == null || data[index]['jp'] == "") {
            jp = "-";
        } else {
            jp = data[index]['jp']['deskripsi'];
        }

        if (data[index]['negara_s'] == null || data[index]['negara_s'] == "") {
            namaNegara = "-";
        } else {
            namaNegara = data[index]['negara_s']['country_name'];
        }

        if (data[index]['kota_s'] == null || data[index]['kota_s'] == "") {
            namaKota = "-";
            namaProv = "-";
        } else {
            namaKota = data[index]['kota_s']['nama'];
            namaProv = data[index]['kota_s']['provinsi']['nama'];
        }

        if (data[index]['default'] == 1) {
            dflt = 'Default';
        } else {
            dflt = '';
        }

        if (data[index]['pdf_ijasah'] == null || data[index]['pdf_ijasah'] == "") {
            pdf = `<span>`+cekNull(data[index]['no_ijazah'])+`</span>`;
        } else {
            pdf = `<a target="_blank" href="uploads/` + data[index]['pdf_ijasah'] +`">`+cekNull(data[index]['no_ijazah'])+`</a>`;
        }

        $('#tableModalDetail > tbody:last').append(`
            <tr>
                <td>` + (index + 1) + `</td>
                <td align="center">` + cekNull(jp) + `</td>
                <td align="center">` + cekNull(data[index]['nama_sekolah']) + `</td>
                <td align="center">` + cekNull(namaNegara) + `</td>
                <td align="center">` + cekNull(namaProv) + `</td>
                <td align="center">` + cekNull(namaKota) + `</td>
                <td align="center">` + cekNull(data[index]['jurusan']) + `</td>
                <td align="center">` + cekNull(data[index]['tahun']) + `</td>
                <td align="center">` + pdf + `</td>
                <td align="center">` + cekNull(tanggal_indonesia(data[index]['tgl_ijasah'])) + `</td>
                <td align="center">` + dflt + `</td>
            </tr>
        `);
    }


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

    $('#myModal').on('show.bs.modal', function(e) {
        let link = $(e.relatedTarget).data('link');
        $(e.currentTarget).find('img').attr('src',link);
    });
    // pop up pdf
    function tampilLampiran(url, title) {
        // alert('dumbass');
        $('#modalLampiran').modal('show');
        $('#iframeLampiran').attr('src', url);
        // $('#lampiranTitle').text(title);
        $('#lampiranTitle').html(` <a href="` + url + `" target="_blank" > ` + title + ` </a> `);
    }

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
            // alert('Tidak ada data yang terpilih');
        } else if (id.length > 1) {
            Swal.fire({
                    title: "Harap pilih satu data untuk di ubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
            // alert('Harap pilih satu data untuk di ubah');
        } else {
            url = id[0];
            window.location.href = "{{ url('personals') }}/" + url + "/edit";
        }
    });
</script>
@endpush
