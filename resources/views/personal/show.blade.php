@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    span.indent{
        text-indent: 25px;
    }
}
</style>

<section class="content-header">
    <h1>
        Detail Personal
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Personal</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="box box-content">
            <div class="box-tools pull-right" style="margin:25px;">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <button class="btn btn-success" id="btnEdit" name="btnEdit">
                                <i class="fa fa-edit"></i> Ubah</button>
                            <button type="button" class="btn btn-danger" id="btnHapus" name="btnHapus">
                                <i class="fa fa-trash"></i> Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body" style="margin-top:45px;">
            {{-- Body --}}
            <h1 style="margin-top:45px; margin-bottom: 25px;">Data Diri</h1>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input value="{{ $personal->nama }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>NIK</label>
                        <input value="{{ $personal->nik }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $personal->email }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input value="{{ $personal->no_hp}}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Instansi</label>
                        <input value="{{ $bu->nama_bu }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input value="{{ $personal->jabatan }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input value="{{ (($personal->jenis_kelamin) == 'L') ? 'Laki-laki' : 'Perempuan' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $personal->alamat }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input value="{{ $provinsi->nama }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Kota</label>
                        <input value="{{ $kota->nama }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input value="{{ $temp_lahir->nama }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input value="{{ isset($personal->tgl_lahir) ? \Carbon\Carbon::parse($personal->tgl_lahir)->isoFormat("DD MMMM YYYY") : '' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input value="{{ $personal->no_rek }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Bank</label>
                        <input value="{{ isset($bank) ? $bank->Nama_Bank : ''}}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nama Pada Rekening</label>
                        <input value="{{ $personal->nama_rek }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>NPWP</label>
                        <input value="{{ $personal->npwp }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Referensi</label>
                        <input value="{{ $personal->reff_p }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                </div>

            </div>


            <h1 style="margin-top:45px; margin-bottom: 25px;">
                Lampiran
            </h1>
            @if($personal->lampiran_foto)
                <div class="row">

                    <div class="col-lg-6">

                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="margin-bottom:25px">Foto Diri</label>
                                    <div>
                                        <a data-toggle="modal" data-target="#myModal">
                                            Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                @if($personal->lampiran_ktp)
                                    <div class="form-group">
                                        <label style="margin-bottom:25px">Foto KTP</label>
                                        <div>
                                            <a data-toggle="modal" data-target="#myModalKtp">
                                                Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="col-lg-4">

                                @if($personal->lampiran_npwp)
                                    <div class="form-group">
                                        <label style="margin-bottom:25px">Foto NPWP</label>
                                        <div>
                                            <a data-toggle="modal" data-target="#myModalNpwp">
                                                Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>

                </div>
            @endif

            {{-- Akhir Body --}}

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


{{-- Modal Foto --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Foto Diri</h4>
	      </div>
	      <div class="modal-body">
	      	<center>
              <img src="{{ isset($personal->lampiran_foto) ? url($personal->lampiran_foto) : '/'}}" alt="Foto Diri">
	        </center>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

{{-- Akhir Modal Foto --}}

{{-- Modal Foto KTP--}}
<!-- Modal -->
<div class="modal fade" id="myModalKtp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">KTP</h4>
        </div>
        <div class="modal-body">
            <center>
            <img src="{{ isset($personal->lampiran_ktp) ? url($personal->lampiran_ktp) : '/'}}" alt="KTP">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- Akhir Modal Foto KTP --}}

{{-- Modal Foto NPWP --}}
<!-- Modal -->
<div class="modal fade" id="myModalNpwp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">NPWP</h4>
        </div>
        <div class="modal-body">
            <center>
            <img src="{{ isset($personal->lampiran_npwp) ? url($personal->lampiran_npwp) : '/'}}" alt="NPWP">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- Akhir Modal Foto NPWP --}}

</section>

@endsection

@push('script')
<script type="text/javascript">
    $('#btnHapus').on('click', function (e) {
            e.preventDefault();
            var id = {{ $id }};
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
        var id = "{{$id}}";
        window.location.href = "{{ url('personals') }}/" + id + "/edit";
    });
</script>
@endpush
