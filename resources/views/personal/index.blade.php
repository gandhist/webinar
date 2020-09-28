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
            <div class="box-tools pull-right" style="margin-top:25px; margin-right:35px;">
                <div class="row">
                    <div class="col-12">
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
            <div class="box-body" style="margin:25px 25px 25px 10px;">

                <div class="row" style="margin-top:40px; margin-bottom: 25;">
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
                                    <td>{{ $personal->nama }} </td>
                                    <td style='text-align:center' data-toggle="tooltip" data-placement="top" data-html="true" title="
                                        Provinsi : {{ isset($personal->kota->provinsi->nama) ? $personal->kota->provinsi->nama : '' }} <br>
                                        Kota : {{ $personal->kota_id ? $personal->kota->nama : '' }} <br>
                                        Alamat : {{ $personal->alamat }} <br>
                                        No HP : {{ $personal->no_hp }} <br>
                                        Email : {{ $personal->email }} <br>
                                        NIK : {{ $personal->nik }} <br>">
                                        {{ isset($personal->kota->provinsi->nama) ? $personal->kota->provinsi->nama_singkat : '' }}</td>
                                    <td> . . . </td>
                                    <td> . . . </td>
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
