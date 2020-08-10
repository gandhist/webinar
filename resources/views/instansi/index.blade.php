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
        Daftar Instansi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="{{ url('/instansi') }}"> Instansi</a></li>
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
                        <div>
                            <a href="{{ url('instansi/create') }}" class="btn btn-info">
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
                                    <th><span class="indent"><i class="fa fa-check-square-o"></i></span></th>
                                    <th><span class="indent">No.</span></th>
                                    <th><span class="indent">Nama Instansi</span></th>
                                    <th><span class="indent">Nomor Telepon</span></th>
                                    <th><span class="indent">Email</span></th>
                                    <th><span class="indent">Alamat</span></th>
                                    <th><span class="indent">Website</span></th>
                                    <th><span class="indent">Nama Pimpinan</span></th>
                                    <th><span class="indent">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($instansi as $key)
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>

                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td data-toggle="tooltip" data-placement="bottom" title="{{ $key->nama_bu   }}" >
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
