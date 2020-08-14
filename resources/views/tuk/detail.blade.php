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
        Detail TUK
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> TUK</a></li>
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
            <h1 style="margin-top:45px; margin-bottom: 25px;">Tempat Uji Personal</h1>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nama TUK</label>
                        <input value="{{ $tuk->nama_tuk }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Jenis TUK</label>
                        <input value="{{ $tuk->is_online == '0' ? 'Offline' : 'Online' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            @if($tuk->is_online == '0')

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <input value="{{ isset($provinsi) ? $provinsi->nama : '' }}"
                            type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Kota</label>
                            <input value="{{ isset($kota) ? $kota->nama : '' }}"
                            type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <input value="{{ isset($tuk->alamat) ? $tuk->alamat : '' }}"
                            type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

            @endif

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Pengelola</label>
                        <input value="{{ isset($tuk->pengelola) ? $tuk->pengelola : '' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ isset($tuk->email) ? $tuk->email : '' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input value="{{ isset($tuk->no_hp) ? $tuk->no_hp : '' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Website</label>
                        <input value="{{ isset($tuk->web) ? $tuk->web : '' }}"
                        type="text" class="form-control" disabled>
                    </div>
                </div>

            </div>

            {{-- Akhir Body --}}

        </div>
    </div>
{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('tuk/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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
        window.location.href = "{{ url('tuk') }}/" + id + "/edit";
    });
</script>
@endpush
