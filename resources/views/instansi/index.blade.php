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
        Badan Usaha P3S - Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="{{ url('/instansi') }}"> Badan Usaha</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            {{-- sub menu  --}}
            <form action="{{ url('instansi/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post">
                <!-- @method("PUT") -->
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row" style="margin-top: 25px">
                    <div class="col-sm-4">

                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_status" id="f_status">
                                                <option selected value="">Status Badan Usaha</option>
                                                @foreach($statusmodel as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_status') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi</option>
                                                @foreach($provinsi as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ request()->get('f_provinsi') == $key->id ? 'selected' : '' }}>
                                                    {{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('instansi') }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_instansi" id="f_instansi">
                                                <option selected value="">Instansi_Reff</option>
                                                @foreach($reff as $key)
                                                <option value="{{ $key->instansi_reff }}"
                                                    {{ request()->get('f_instansi') == $key->instansi_reff ? 'selected' : '' }}>
                                                    {{ $key->instansi_reff }}</option>
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

                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
                    </div>



                    <div class="col-sm-5">

                    </div>

                    <div class="col-sm-3" style='text-align:right'>
                        <div class="btn-group">
                            <a href="{{ url('instansi/create') }}" class="btn btn-info"> <i class="fa fa-plus"></i>
                                Tambah</a>
                            <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i class="fa fa-edit"></i>
                                Ubah</button>
                            <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i class="fa fa-trash"></i>
                                Hapus</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="box-body" style="margin:25px 25px 25px 10px;">

                <div class="row" >
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
                                    <th><span>No.</span></th>
                                    <th>Nama_BU</th>
                                    <th>Sts_BU</th>
                                    <th>Prov</th>
                                    <th>Instansi_Reff</th>
                                    <th>Nama_Pimp</th>
                                    <th>Kontak_P</th>
                                    <th>NPWP</th>
                                    <th>Keterangan</th>
                                    <th>User_Tambah</th>
                                    <th>User_Ubah</th>
                                    {{-- <th><span class="indent">Nama Instansi</span></th>
                                    <th><span class="indent">Nomor Telepon</span></th>
                                    <th><span class="indent">Email</span></th>
                                    <th><span class="indent">Alamat</span></th>
                                    <th><span class="indent">Website</span></th>
                                    <th><span class="indent">Nama Pimpinan</span></th>
                                    <th><span class="indent">Aksi</span></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($instansi as $key)
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>

                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                                        Bentuk BU : {{$key->bentukusaha->nama ?? ''}} <br>
                                        Nama Lengkap : {{$key->nama_bu ?? ''}} <br>
                                        Nama Singkat : {{$key->singkat_bu ?? ''}} <br>
                                    ">{{$key->singkat_bu  ?? ''}}</td>

                                    <td data-toggle="tooltip" data-placement="bottom" data-html="true"
                                    title='{{ $key->status ? $key->status->nama : "" }}'>{{ $key->status ? $key->status->singkatan : "" }}</td>

                                    <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                                        title="
                                            Provinsi : {{$key->provinsibu->nama}}<br>
                                            Kab/Kota : {{$key->kota->nama}}<br>
                                            Alamat : {{$key->alamat}}<br>
                                            Telp : {{$key->telp}}<br>
                                            Email : {{$key->email}}<br>
                                            Web : {{$key->web}}">
                                        {{ isset($key->provinsibu->nama) ? $key->provinsibu->nama_singkat : '' }}
                                    </td>

                                    <td>{{ $key->instansi_reff }}</td>
                                    <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                                        Nama : {{ $key->nama_pimp }} <br>
                                        Jabatan : {{ $key->jab_pimp }} <br>
                                        No Hp : {{ $key->hp_pimp }} <br>
                                        Email : {{ $key->email_pimp }} <br>
                                        ">{{ $key->nama_pimp }}</td>
                                    <td data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                                        Nama : {{ $key->kontak_p }} <br>
                                        Jabatan : {{ $key->jab_kontak_p }} <br>
                                        No Hp : {{ $key->no_kontak_p }} <br>
                                        Email : {{ $key->email_kontak_p }} <br>
                                        ">{{ $key->kontak_p }}</td>
                                    <td style="text-align:center" data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                                        NPWP : {{ $key->npwp }} <br>
                                        No Rekening : {{ $key->no_rek  }} <br>
                                        Atas Nama : {{ $key->nama_rek }} <br>
                                        Bank : {{ isset($key->bank->Nama_Bank) ? $key->bank->Nama_Bank : '' }} <br>
                                        ">
                                        @if (isset($key->npwp))
                                        @if (isset($key->npwp_pdf))
                                        <button class="btn btn-success btn-xs"
                                            onclick='tampilLampiran("{{ asset($key->npwp_pdf) }}","NPWP {{$key->nama_bu}}")'> {{ $key->npwp }} </button>
                                        @else
                                        <button class="btn btn-warning btn-xs"> {{ $key->npwp }} </button>
                                        @endif
                                        @endif
                                        </td>
                                    <td>{{ $key->keterangan }}</td>
                                    <td
                                        style='text-align:right'
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-html="true" title="
                                            {{isset($key->user_create) ? $key->user_create->name : ''}}
                                            {{ ( isset($key->user_create) && isset($key->created_at) ) ? ' , ' : '' }}
                                            {{ isset($key->created_at) ? \Carbon\Carbon::parse($key->created_at)->isoFormat("DD MMMM YYYY H:mm:s") : ''}}
                                        ">
                                        @if (isset($key->created_at))
                                        {{ \Carbon\Carbon::parse($key->created_at)->isoFormat("DD MMMM YYYY H:mm:s") }}
                                        @endif
                                    </td>
                                    <td
                                        style='text-align:right'
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-html="true" title="
                                            {{isset($key->user_update) ? $key->user_update->name : ''}}
                                            {{ ( isset($key->user_update) && isset($key->updated_at) ) ? ' , ' : '' }}
                                            {{ isset($key->updated_at) ? \Carbon\Carbon::parse($key->updated_at)->isoFormat("DD MMMM YYYY H:mm:s") : ''}}
                                    ">
                                        @if (isset($key->updated_at))
                                        {{ \Carbon\Carbon::parse($key->updated_at)->isoFormat("DD MMMM YYYY H:mm:s") }}
                                        @endif
                                    </td>
                                    {{-- <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->nama_bu   }}" >
                                        <a href="{{ url('instansi/'.$key->id) }}">
                                            {{ str_limit($key->nama_bu  ,50) }}
                                        </a>
                                    </td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->telp      }}"
                                    style="text-align:center;">
                                        {{ str_limit($key->telp     ,20) }}
                                    </td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->email     }}"
                                    style="text-align:center;">
                                        <a href="mailto:{{ $key->email }}">Kirim Email</a>
                                    </td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->alamat    }}" >
                                        {{ str_limit($key->alamat   ,40) }}
                                    </td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->web       }}"
                                    style="text-align:center;">
                                    @if($key->web)
                                        <a href="{{ url($key->web) }}">Kunjungi</a>
                                    @else
                                        {{''}}
                                    @endif
                                    </td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->nama_pimp }}" >
                                    <a href="{{ url('personals/'.$key->id_personal_pimp) }}">{{ str_limit($key->nama_pimp,40) }}</a>
                                    </td>

                                    <td>
                                        @if($key->is_actived == "1")
                                            {{" "}}
                                        @else
                                            <button type="submit" class="btn btn-success">
                                                <a href="{{url('instansi/lengkapi/'.$key->id.'/'.$key->id_personal_pimp)}}" style="color:white">
                                                    Lengkapi
                                                </a>
                                            </button>
                                        @endif

                                    </td> --}}

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

{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('instansi/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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
    var errHapus = '';
	@if(session()->get('errHapus'))
        errHapus = `{{(session()->get('errHapus'))}}`;
	@endif
    if(errHapus){
        Swal.fire({
            title: errHapus,
            type: 'warning',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            // onClose: function() {
            //     window.location.replace(home_srtf);
            //     }
            // })
        })
    }

    // Filter kota berdasarkan provinsi
    $('#f_provinsi').on('select2:select', function () {
        var url = `{{ url('chain/filterprovbu') }}`;
        chainedProvinsiBu(url, 'f_provinsi', 'f_kota', "Kota");
    });

    $('.select2').select2()
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
            window.location.href = "{{ url('instansi') }}/" + url + "/edit";
        }
    });
</script>
@endpush
