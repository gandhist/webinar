@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Keuangan (Midtrans)
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Laporan</a></li>
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

            {{-- sub menu  --}}
            <form action="{{ url('keu') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="get">
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row">
                    <div class="col-sm-5">

                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl_Awal_Kgt &nbsp;&nbsp;</span>
                                            <input id="f_awal_terbit" name="f_awal_terbit"
                                            value="{{ request()->get('f_awal_terbit') }}" autocomplete="off"
                                            data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                            class="form-control customInput" placeholder="Tgl Awal">
                                                <input id="f_akhir_terbit" name="f_akhir_terbit"
                                                value="{{ request()->get('f_akhir_terbit') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir" style="margin-left: 100px;margin-top: -28px;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJK3</option>
                                                {{-- @foreach($pj_srtf as $key)
                                                <option value="{{ $key->pjk3_r->id_pjk3 }}"
                                                    {{ request()->get('f_pjk3') == $key->id_pjk3 ? 'selected' : '' }}>
                                                {{ $key->pjk3_r->singkat_bu }}
                                                    ({{ $key->pjk3_r->nama_bu }})</option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_bidang" id="f_bidang">
                                                <option selected value="">Bidang</option>
                                                {{-- @foreach($bidang as $key)
                                                <option value="{{ $key->bidang_r->id }}"
                                                    {{ request()->get('f_bidang') == $key->bidang_r->id ? 'selected' : '' }}>
                                                    {{ $key->bidang_r->kode_bidang }}
                                                </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi_Kgt</option>
                                                {{-- @foreach($provinsi as $key)
                                                <option value="{{ $key->prov_r->id }}"
                                                    {{ request()->get('f_provinsi') == $key->prov_r->id ? 'selected' : '' }}>
                                                    {{ $key->prov_r->nama_singkat }} ({{ $key->prov_r->nama }})</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </td>

                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                            <a href="{{ url('keu')}}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>

                                </tr>
                                <tr>

                                    <td>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <span class="input-group-addon customInput">Tgl_Akhir_Kgt &nbsp;</span>
                                                <input id="f_awal_akhir" name="f_awal_akhir"
                                                value="{{ request()->get('f_awal_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Awal">
                                                <input id="f_akhir_akhir" name="f_akhir_akhir"
                                                value="{{ request()->get('f_akhir_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir" tyle="margin-left: 100px;margin-top: -28px;">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_jenis_usaha"
                                                id="f_jenis_usaha">
                                                <option selected value="">Jenis Usaha</option>
                                                {{-- @foreach($jenis_usaha as $key)
                                                <option value="{{ $key->jenis_usaha_r->id }}"
                                                    {{ request()->get('f_jenis_usaha') == $key->id_jenis_usaha ? 'selected' : '' }}>
                                                    {{ $key->jenis_usaha_r->kode_jns_usaha }} ({{ $key->jenis_usaha_r->nama_jns_usaha }})</option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pembinaan"
                                                id="f_pembinaan">
                                                <option selected value="">Pembinaan</option>
                                                {{-- @foreach($pembinaan as $key)
                                                <option value="{{ $key->sertifikat_alat_r->id }}"
                                                    {{ request()->get('f_pembinaan') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->bidang_r->singkat_bidang }} ({{ $key->sertifikat_alat_r->kode_srtf_alat }})</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_status"
                                                id="f_status">
                                                {{-- @foreach($dt_status as $key => $val)
                                                <option value="{{ $val }}"
                                                    {{ request()->get('f_status') == $val ? 'selected' : '' }}>
                                                    {{ $val }} </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
                    </div>

                    <div class="col-sm-4">

                    </div>


                </div>
            </form>
            <!-- /.box-footer -->
            {{-- end of sub menu  --}}

            <table id="data-tables-payment" class="table table-striped table-bordered dataTable customTable">
                <thead>
                    <tr>
                        <th style="padding-right:8px" >Aksi</th>
                        <th style="padding-right:8px" >No</th>
                        <th>Nama_Kgt</th>
                        <th>Pay_No</th>
                        <th>Tgl_Byr</th>
                        <th>Prov</th>
                        <th>Peserta</th>
                        <th>Sts_Pay</th>
                        <th>Nilai_Tgh</th>
                        <th>By_Midtrans</th>
                        <th>Nilai_Nett</th>
                        <th>TUK</th>
                        <th>U_Tambah</th>
                        <th>U_Ubah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayaran as $key)
                        <tr>
                            <td style="text-align: center">
                                <button class="btn btn-xs btn-success" > <i class="fa fa-eye" ></i> </button>
                            </td>
                            <td style="text-align: center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ isset($key->peserta_seminar_trashed) ?
                                    $key->peserta_seminar_trashed->seminar_trashed->nama_seminar :
                                    '' }}
                            </td>
                            <td>
                                {{$key->no_transaksi}}
                            </td>
                            <td>
                                {{ $key->transaction_time ? (\Carbon\Carbon::parse($key->transaction_time)->translatedFormat('d M Y h:m:s')) : ''}}
                            </td>
                            <td>
                                {{ isset($key->peserta_seminar_trashed) ?
                                    $key->peserta_seminar_trashed->seminar_trashed->prov_r->nama_singkat :
                                    '' }}
                            </td>
                            <td>
                                {{ isset($key->peserta_seminar_trashed) ?
                                    $key->peserta_seminar_trashed->peserta->nama :
                                    '' }}
                            </td>
                            <td>
                                @if ($key->status == 1)
                                    <button class="btn btn-success btn-xs">
                                        Sukses
                                    </button>
                                @elseif ($key->status == 2)
                                    <button class="btn btn-warning btn-xs">
                                        Pending
                                    </button>
                                @endif
                            </td>
                            <td>
                                {{\Rupiah::RupiahNoRp($key->payment_gross)}}
                            </td>
                            <td>
                                {{\Rupiah::RupiahNoRp($key->payment_fee)}}
                            </td>
                            <td>
                                {{ ($key->payment_gross && $key->payment_fee) ? \Rupiah::RupiahNoRp($key->payment_gross - $key->payment_fee) : ''}}
                            </td>
                            <td>
                                {{ isset($key->peserta_seminar_trashed) ?
                                    ( isset($key->peserta_seminar_trashed->seminar_trashed->tuk_r) ? $key->peserta_seminar_trashed->seminar_trashed->tuk_r->nama_tuk : '' ) :
                                    '' }}
                            </td>
                            <td>
                                {{ $key->created_by_r ? $key->created_by_r->name : ''}}
                            </td>
                            <td>
                                {{ $key->updated_by_r ? $key->updated_by_r->name : ''}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script>
$(function(){
    $('.select2').select2()
    $('#data-tables-payment').DataTable({
        "lengthMenu": [
            100, 200, 500,
        ],
        "scrollX": $(window).width() - 100,
        "scrollY": $(window).height() - 255,
    })
});
</script>
@endpush
