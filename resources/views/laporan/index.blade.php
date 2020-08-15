@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan ISO
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

            {{--  table data Seminar  --}}
            <div>
              {{-- form filter --}}
              <form action="{{ url('seminar') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                      
                    </div>

                    <div class="col-sm-4">

                    </div>

                    <div class="col-sm-2" style='text-align:right'>
                        <div class="row" style="margin-top:-3px;margin-bottom:3px">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <span class="btn btn-primary" id="printIso"><i
                                        class="fa fa-print"></i>
                                        Print</span>
                                    {{-- <span class="btn btn-warning" id="btnTenagaAhli"></i>
                                        Tenaga Ahli</span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <a href="{{ url('laporan/create') }}" class="btn btn-info"> <i
                                            class="fa fa-plus"></i>
                                        Tambah</a>
                                    <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i
                                            class="fa fa-pencil"></i>
                                        Edit</button>
                                    <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i
                                            class="fa fa-trash"></i>
                                        Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
              {{-- end of form filter --}}
                <table id="data-tables" class="table table-striped table-bordered dataTable customTable" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-indent: 5px;"><i class="fa fa-check-square-o"></i></th>
                            <th style="text-indent: 22px;">No</th>
                            <th>Badan Usaha</th>
                            <th>Iso</th>
                            <th>Id Number</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($data as $key)
                     <tr>
                         <td style='text-align:center'>
                            <input  type="checkbox" data-id="{{ $key->id }}" class="selection"
                            id="selection[]" name="selection[]">
                         </td>
                         <td>{{ $loop->iteration }}</td>
                         <td>{{ $key->bu_r ? $key->bu_r->nama_bu : '' }}</td>
                         <td>{{ $key->iso_r->kode }}</td>
                         <td>{{ $key->id_number }}</td>
                         <td>{{ $key->audit_date }}</td>
                         <td align='center'>
                            @if($key->status == 1)
                                <span class="label label-warning">{{ $key->status_r->nama }}</span>
                            @elseif($key->status == 2)
                                <span class="label label-success">{{ $key->status_r->nama }}</span>
                            @endif
                        </td>
                     </tr>
                     @endforeach
                    </tbody>
                </table>
            </div>
            {{--  end of table seminar  --}}
            

{{-- modal konfirmasi hapus --}}
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('laporan/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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


  // onclick button hapus
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
        alert('Tidak ada data yang terpilih');
        } else if (id.length > 1) {
        alert('Harap pilih satu data untuk di ubah');
        } else {
        url = id[0];
        window.location.href = "{{ url('laporan') }}/" + url + "/edit";
        }
    });

    // Button print iso click
    $('#printIso').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            if (id.length == 0) {
                alert('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                alert('Harap pilih satu data untuk di ubah');
            } else {
                url = id[0];
                window.open("{{ url('laporan/print') }}/" + url,'_blank');
            }
        });

  });
</script>
@endpush
