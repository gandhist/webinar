@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seminar P3SM
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Seminar</a></li>
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
                        <!-- Table Filter -->
                        <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Awal Seminar</span>
                                            <input id="f_awal_terbit" name="f_awal_terbit"
                                                value="{{ request()->get('f_awal_terbit') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Awal">
                                            <span class="input-group-addon customInput">s/d</span>
                                            <input id="f_akhir_terbit" name="f_akhir_terbit"
                                                value="{{ request()->get('f_akhir_terbit') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir">
                                        </div>
                                    </td>
                                    <td>
                                        {{-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_jenis_usaha"
                                                id="f_jenis_usaha">
                                                <option selected value="">Jenis Usaha</option>
                                            </select>
                                        </div> --}}
                                    </td>
                                    <td>
                                        {{-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJK3</option>
                                            </select>
                                        </div> --}}
                                    </td>
                                    <td>
                                        {{-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_instansi" id="f_instansi">
                                                <option selected value="">Instansi_Reff</option>
                                            </select>
                                        </div> --}}
                                    </td>
                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('daftarpjk3') }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon customInput">Tgl Akhir Seminar &nbsp;</span>
                                            <input id="f_awal_akhir" name="f_awal_akhir"
                                                value="{{ request()->get('f_awal_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Awal">
                                            <span class="input-group-addon customInput">s/d</span>
                                            <input id="f_akhir_akhir" name="f_akhir_akhir"
                                                value="{{ request()->get('f_akhir_akhir') }}" autocomplete="off"
                                                data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                class="form-control customInput" placeholder="Tgl Akhir">
                                        </div>
                                    </td>

                                    <td>
                                        {{-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi PJK3</option>
                                            </select>
                                        </div> --}}
                                  </td>

                                    <td>
                                        {{-- <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_bidang" id="f_bidang">
                                                <option selected value="">Bidang</option>
                                            </select>
                                        </div> --}}
                                    </td>
                                    <td>

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

                    <div class="col-sm-2" style='text-align:right'>
                        <div class="row" style="margin-top:-3px;margin-bottom:3px">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <span class="btn btn-primary" id="btnDetailPjk3"><i
                                        class="fa fa-eye"></i>
                                        Detail</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <a href="{{ url('seminar/create') }}" class="btn btn-info"> <i
                                            class="fa fa-plus"></i>
                                        Tambah</a>
                                    <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i
                                            class="fa fa-edit"></i>
                                        Ubah</button>
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
                            <th style="text-indent: 12px;"><i class="fa fa-check-square-o"></i></th>
                            <th style="text-indent: 22px;">No</th>
                            <th>Nama</th>
                            <th>Tema</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $key)
                      <tr>
                          <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                  id="selection[]" name="selection[]"></td>
                          <td style='text-align:center'>{{ $loop->iteration }}</td>
                          <td>{{ $key->nama_seminar }}</td>
                          <td>{{ $key->tema }}</td>
                          <td>
                              <a target="_blank" href="{{ url('seminar/detail', $key->id) }}" class="btn btn-outline-primary my-2 my-sm-0"> Lihat Peserta</a>
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
    <form action="{{ url('seminar/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
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

  });
</script>
@endpush
