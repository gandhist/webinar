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
                        <div class="btn-group">
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
            <h1 style="margin-top:45px; margin-bottom: 25;">Data Diri</h1>
            <form>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input value="{{ $personal[0]['nama'] }}" id="nama" name="nama" type="text" required class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ $personal[0]['email'] }}" id="email" name="email" type="email" class="form-control" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="no_hp">No Handphone</label>
                        <input value="{{ $personal[0]['no_hp'] }}" id="no_hp" name="no_hp" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input value="{{ $provinsi[0]['nama'] }}" id="provinsi" name="provinsi" type="text" class="form-control" disabled>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input value="{{ $personal[0]['alamat'] }}" id="alamat" name="alamat" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="kota">Kota / Kabupaten</label>
                        <input value="{{ $kota[0]['nama']}}" id="kota" name="kota" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input value="{{ $personal[0]['pekerjaan'] }}" id="pekerjaan" name="pekerjaan" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="instansi">Instansi</label>
                        <input value="{{ $bu[0]['nama_bu'] }}" id="instansi" name="instansi" type="text" class="form-control" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="nik">Nomor NIK</label>
                        <input value="{{ $personal[0]['no_nik'] }}" id="nik" name="nik" type="text" required class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="npwp">Nomor NPWP</label>
                        <input value="{{ $personal[0]['no_npwp'] }}" id="npwp" name="npwp" type="npwp" class="form-control" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input value="{{ $personal[0]['tgl_lahir']}}" id="tgl_lahir" name="tgl_lahir" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="instansi">Foto</label>
                        @php
                            $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $personal[0]['nama']);
                        @endphp
                        <div class="w-100">
                            <img class="img-responsive" src="{{url('/uploads/foto/personal/'.$dir_name.'/'.$personal[0]['foto'])}}" alt="Foto">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
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
