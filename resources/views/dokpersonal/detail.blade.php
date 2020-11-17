@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail Data Dokumen Personal PPKB P3S Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="/dokpersonal">Dok Personal</a></li>
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

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <select class="form-control select2" name="id_nama_pjk3" id="id_nama_pjk3" style="width: 100%;"
                            placeholder="Nama PJK3">
                            <option value="" disabled selected>Nama PJK3</option>
                            @foreach($pjk3 as $key)
                            <option value="{{ $key->kode_pjk3 }}"
                                {{ $key->kode_pjk3 == old('id_nama_pjk3') ? 'selected' : '' }}>
                                {{ $key->badan_usaha->nama_bu }} </option>
                            @endforeach
                        </select>
                        <span id="id_nama_pjk3"
                            class="help-block customspan">{{ $errors->first('id_nampa_pjk3') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <select class="form-control select2" id_bidangdok="id_bidangdok" name="id_namadok"
                            id="id_namadok" style="width: 100%;" placeholder="Nama Dokumen">
                            <option value="" disabled selected>Nama Dokumen</option>
                            @foreach($jenisdoksrtf as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('id_namadok') ? 'selected' : '' }}>
                                {{ $key->nama_srft_alat }} </option>
                            @endforeach
                        </select>
                        <span id="id_namadok" class="help-block customspan">{{ $errors->first('id_namadok') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <select id_jenisdok="id_jenisdok" id_namadok="id_namadok" name="id_bidangdok" id="id_bidangdok"
                            type="text" class="form-control select2" style="width: 100%;" placeholder="Bidang Dok">
                            <option value="" disabled selected>Bidang Dok</option>
                            {{-- @foreach($bidang as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('id_namadok') ? 'selected' : '' }}>
                            {{ $key->kode_bidang }} </option>
                            @endforeach --}}
                        </select>
                        <span id="id_bidangdok"
                            class="help-block customspan">{{ $errors->first('id_bidangdok') }}</span>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control select2" name="id_jenisdok" id="id_jenisdok" style="width: 100%;"
                            placeholder="Jenis Dok">
                            <option value="" disabled selected>Jenis Dok</option>
                            {{-- @foreach($jenisdok as $key)
                            <option value="{{ $key->id }}" {{ $key->id == old('id_jenisdok') ? 'selected' : '' }}>
                            {{ $key->Nama_jns_dok }} </option>
                            @endforeach --}}
                        </select>
                        <span id="id_jenisdok" class="help-block customspan">{{ $errors->first('id_jenisdok') }}</span>
                    </div>
                </div>

                <br>
                <b>Data Personil Yang Memiliki Dok :</b>

                <table id="data-dokpersonil"
                    class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                    <thead>
                        <tr role="row">
                            <th style="width:2%">No</th>
                            <th style="width:12%">Nama</th>
                            <th style="width:8%">Prov</th>
                            <th style="width:10%">Instansi_Dok</th>
                            <th style="width:14%">No_Dok</th>
                            <th style="width:9%">Tgl_Terbit</th>
                            <th style="width:9%">Tgl_Akhir</th>
                            <th style="width:12%">Sekolah_P</th>
                            <th style="width:10%">Ket_P</th>
                            <th style="width:4%">Pdf_Dok</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <input type="hidden" name='id_detail_dokpersonil' id='id_detail_dokpersonil' value=''>

            <div class="box-footer" style="text-align:center">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ url('dokpersonal/detail') }}" class="btn btn-md btn-danger"> <i
                                class="fa fa-refresh"></i>
                            Reset</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('dokpersonal') }}" class="btn btn-md btn-default"><i
                                class="fa fa-reply"></i>
                            Kembali</a>
                    </div>
                </div>
            </div>

             {{-- <div class="box-footer">
                <a href="{{ url('dokpersonil') }}" class="btn btn-md btn-success pull-left"><i class="fa fa-reply"></i>
                    Kembali</a>
                <a href="{{ url('dokpersonil/detail') }}" class="btn btn-md btn-danger"> <i class="fa fa-refresh"></i>
                    Reset</a>
            </div> --}}

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->

@endsection

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

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">
    var home = "{{ url('dokpersonal') }}";

    $(function () {
        // Filter bidang dok berdasarkan nama dok
        $(document).on('change', '#id_namadok', function (e) {
            id_namadok = $(this).val();
            id_bidangdok = $(this).attr('id_bidangdok');

            $('#' + id_bidangdok).empty();

            namadokchange(id_namadok, id_bidangdok);
        });

        // Fungsi ketika memilih nama dok otomatis menampilkan bidang dok
        function namadokchange(id_namadok, id_bidangdok) {
            var url = "{{ url('select_temp_namadok_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_namadok: id_namadok
                },
                success: function (data) {
                    $("#" + id_bidangdok).html(
                        "<option value='' selected disabled>Pilih Bidang</option>");
                    $("#" + id_bidangdok).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Filter jns dok berdasarkan bidang dok
        $(document).on('select2:select', '#id_bidangdok', function (e) {
            id_bidangdok = $(this).val();
            id_jnsdok = $(this).attr('id_jenisdok');
            id_namadok = $(this).attr('id_namadok');

            $('#' + id_jnsdok).empty();

            bidangdokchange(id_bidangdok, id_jnsdok, id_namadok);
        });

        // Fungsi ketika memilih nama dok otomatis menampilkan jns dok
        function bidangdokchange(id_bidangdok, id_jnsdok, id_namadok) {
            nama_dok = $("#" + id_namadok).val();
            var url = "{{ url('select_temp_bidangdok_skp_ak3') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jnsdok: id_jnsdok,
                    id_namadok: nama_dok
                },
                success: function (data) {
                    $("#" + id_jnsdok).html(
                        "<option value='' selected disabled>Pilih Jenis Dok</option>");
                    $("#" + id_jnsdok).select2({
                        data: data
                    }).val(null).trigger('refresh');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi Jenis Dok on Change memunculkan data
        $(document).on('change', '#id_jenisdok', function (e) {
            var id = $(this).val();
            id_nama_pjk3 = $("#id_nama_pjk3").val();
            id_namadok = $('#id_namadok').val();
            id_bidangdok = $('#id_bidangdok').val();
            console.log('ID Jenis Dok');
            console.log(id);
            console.log('ID kode pjk3');
            console.log(id_nama_pjk3);
            console.log('ID nama dok');
            console.log(id_namadok);
            console.log('ID bidang dok');
            console.log(id_bidangdok);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('dokpersonal/get_skpak3') }}/" + id,
                method: 'POST',
                data: {
                    id_nama_pjk3: id_nama_pjk3,
                    id_namadok: id_namadok,
                    id_bidangdok: id_bidangdok
                },
                success: function (response) {
                    console.log(response);
                    var dataSkpAk3 = response['dataSkpAk3'].length;
                    if (dataSkpAk3 == 0) {
                        Swal.fire({
                            title: "Tidak ada data untuk di tampilkan !",
                            type: 'error',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#AAA'
                        });
                    } else {
                        // Hapus semua data detail & ulangi dari awal
                        $('#data-dokpersonil > tbody').html("");
                        no = 1;
                        id_detail = [];

                        // Menambahkan baris data detail sebanyak data yang ada
                        for (var i = 0; i < dataSkpAk3; i++) {
                            var tgl_skp = tanggal_indonesia(response['dataSkpAk3'][i][
                                'tgl_skp'
                            ]);
                            var tgl_akhir_skp = response['dataSkpAk3'][i]['tgl_akhir_skp'];
                            if (tgl_akhir_skp == '' || tgl_akhir_skp == null) {
                                tgl_akhir_skp = 'Berlaku Seumur Hidup'
                            } else {
                                tgl_akhir_skp = tanggal_indonesia(tgl_akhir_skp);
                            }
                            var sekolah = response['dataSkpAk3'][i]['personal']['sekolah'];
                            if (sekolah == '' || sekolah == null) {
                                ket = '';
                                jp = '';
                                nama_sekolah = '';
                                tahun_tamat = '';
                                prodi = '';
                            } else {
                                ket = response['dataSkpAk3'][i]['personal']['sekolah'][
                                    'keterangan'
                                ];
                                jp = response['dataSkpAk3'][i]['personal']['sekolah']['jp'][
                                    'deskripsi'
                                ];
                                nama_sekolah = response['dataSkpAk3'][i]['personal'][
                                    'sekolah'
                                ]['nama_sekolah'];
                                tahun_tamat = response['dataSkpAk3'][i]['personal'][
                                    'sekolah'
                                ]['tahun'];
                                prodi = response['dataSkpAk3'][i]['personal']['sekolah'][
                                    'jurusan'
                                ];
                            }
                            $('#data-dokpersonil > tbody:last').append(`
                                <tr>
                                    <td style="text-align:center;">` + no + `</td>
                                    <td>
                                        <input disabled value="` + response['dataSkpAk3'][i]['personal']['nama'] + `" type="text" class="form-control" placeholder="Nama"
                                            name="id_namapersonil_` + no + `" id="id_namapersonil_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + response['dataSkpAk3'][i]['personal']['kota'][
                                'provinsi'
                            ]['nama'] + `" type="text" class="form-control" placeholder="Prov"
                                            name="id_provpersonil_` + no + `" id="id_provpersonil_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + response['dataSkpAk3'][i]['instansi_skp'] + `" type="text" class="form-control" placeholder="Instansi Dok"
                                            name="id_instansi_` + no + `" id="id_instansi_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + response['dataSkpAk3'][i]['no_skp'] + `" type="text" class="form-control" placeholder="No Dok"
                                            name="id_nodokumen_` + no + `" id="id_nodokumen_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + tgl_skp + `" type="text" class="form-control" placeholder="Tgl Terbit"
                                            name="id_tglterbit_` + no + `" id="id_tglterbit_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + tgl_akhir_skp + `" type="text" class="form-control" placeholder="Tgl Akhir"
                                            name="id_tglakhir_` + no + `" id="id_tglakhir_` + no + `">
                                    </td>
                                    <td>
                                        <input disabled value="` + jp + ` ` + prodi + ` ` + tahun_tamat + `" type="text" class="form-control" placeholder="Sekolah_P"
                                            name="id_sekolahp_` + no + `" id="id_sekolahp_` + no + `">
                                    </td>
                                    <td style="width:10%">
                                        <input disabled value="` + cekNull(ket) + `"type="text" class="form-control"
                                            name="id_ketp_` + no + `" id="id_ketp_` + no + `">
                                    </td>
                                    <td >
                                        <a target="_blank" href="/uploads/` + response['dataSkpAk3'][i][
                                'pdf_skp_ak3'
                            ] + `" type="button" class="btn btn-primary btn-sm"
                                            placeholder="Pdf Dok" name="id_pdfdok_` + no + `" id="id_pdfdok_` + no + `" style="margin-top:2px;margin-left:6px;">
                                            <i class="fa fa-file-pdf-o" ></i> Lihat</a>
                                    </td>
                                </tr>
                            `);
                            no++;
                        }
                    }

                },
                error: function (xhr) {
                    swal.fire('terjadi error ketika menampilkan data');
                }
            });
        });

    });

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
