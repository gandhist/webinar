@extends('templates.header')

@section('content')
<style>
    .horizontal-line {
        width:30%;
        height:0px;
        border-top:
        1px solid gray;
        margin:45px auto;
    }
    label {
        margin-top:15px;
    }
</style>

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Detail Instansi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Instansi</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron"  style='padding-top:1px'>
                <div class="box-tools pull-right" style="margin-top:25px; margin-right:35px;">
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

                <form >

                    <h1 style="margin-bottom:50px;">Data Instansi</h1>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->nama_bu}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->email}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->telp}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->web}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->alamat}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Negara</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="Indonesia">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$provinsi->nama}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kabupaten / Kota</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$kota->nama}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Singkat</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->singkat_bu}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom:10px">Logo Instansi</label>
                                <div>
                                    <a data-toggle="modal" data-target="#myModal">
                                        Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="horizontal-line"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Pimpinan</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->nama_pimp}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan Pimpinan</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->jab_pimp}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Pimpinan</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->email_pimp}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon Pimpinan</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->hp_pimp}}">
                            </div>
                        </div>
                    </div>


                    @if($instansi->is_actived == "1")
                        <button type="submit" class="btn btn-info pull-right">
                            <a href="{{url('personals/'.$instansi->id_personal_pimp.'/edit')}}" style="color:white">
                                Edit Pimpinan
                            </a>
                        </button>
                    @else
                        <button type="submit" class="btn btn-info pull-right">
                            <a href="{{url('instansi/lengkapi/'.$instansi->id.'/'.$instansi->id_personal_pimp)}}" style="color:white">
                                Lengkapi
                            </a>
                        </button>
                    @endif

                    <div class="horizontal-line"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->kontak_p}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan Contact Person</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->jab_kontak_p}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Contact Person</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->email_kontak_p}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon Contact Person</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->no_kontak_p}}">
                            </div>
                        </div>
                    </div>

                    <div class="horizontal-line"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Rekening</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->no_rek}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{isset($bank->Nama_Bank) ? $bank->Nama_Bank : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama pada Rekening</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->nama_rek}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="text" disabled="disabled" class="form-control"
                                value="{{$instansi->npwp}}">
                            </div>
                        </div>
                    </div>

                    <div class="horizontal-line"></div>

                    @if($instansi->npwp_pdf)

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lampiran</label>
                                <div style="margin-top: 10px;">
                                    <a href="{{ url($instansi->npwp_pdf) }}">
                                        Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    @endif

                </form>
            </div> {{-- Jumbotron --}}
        </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
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

</section>
{{-- end of modal konfirmasi hapus --}}


{{-- Modal Foto --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Logo Instansi</h4>
        </div>
        <div class="modal-body">
            <center>
            <img src="{{isset($instansi->logo) ? url($instansi->logo) : '/'}}" alt="Logo Instansi">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- Akhir Modal Foto --}}

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
        window.location.href = "{{ url('instansi') }}/" + id + "/edit";
    });
</script>
@endpush
