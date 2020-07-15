@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Master Barang & Jasa
    {{-- <small>it all starts here</small>  --}}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="#">Master</a></li>
    <li class="active"><a href="#">Barang & Jasa</a></li>
  </ol>


</section>

<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-body">

      @if(session()->get('success'))
      <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      </div>
      @endif

      {{-- sub menu  --}}
      <div class="row">
        <form action="javascript:void(0)" enctype="multipart/form-data" name="formAdd" id="formAdd" method="post">
          @csrf
          <input type="hidden" name="key" id="key">
          <input type="hidden" name="_method" id="_method">
          <!-- bilah kiri -->
          <div class="col-xs-4">
          <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                    <label for="kode_barang">Part Number</label>
                    <input type="text" autocomplete="off" class="form-control" id="kode_barang" name="kode_barang">
                    <span id="kode_barang" class="help-block"> {{ $errors->first('kode_barang') }} </span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                    <label for="nama">Nama Barang / Jasa</label>
                    <input type="text" autocomplete="off" class="form-control" id="nama" name="nama">
                    <span id="nama" class="help-block"> {{ $errors->first('nama') }} </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                    <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" autocomplete="off" class="form-control" id="satuan" name="satuan">
                    <span id="satuan" class="help-block"> {{ $errors->first('satuan') }} </span>
                    </div>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control select2" name="kategori" id="kategori" style="width: 100%;">
                    <option value="BARANG"> BARANG</option>
                    <option value="JASA"> JASA</option>
                </select>
                <span id="kategori" class="help-block"> {{ $errors->first('kategori') }} </span>
            </div>
         
            <div class="form-group" id="alert-form">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="alert" class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                            
                        </div>
                    </div>
                </div> 
            </div>
            
          </div>
          <!-- end of bilah kiri -->
         
          <!-- /.box-body -->
      </div>
      <div class="box-footer">
        <button type="button" id="reset" onclick="resett()" class="btn btn-default">Cancel</button>
        <button type="submit" id="btnSave" onclick="save()" name="btnSave" class="btn btn-info">Simpan</button>
      </div>
      </form>

      <!-- /.box-footer -->
      {{-- end of sub menu  --}}
      <hr>
      {{-- table data of car  --}}
      <div class="table-responsive">
        <table id="data-table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
            <tr>
              <!-- <th width="6%"><input type="checkbox" id="selectAllDelete" name="selectAllDelete"> <button class="btn btn-danger" id="btnDeleteAll" name="btnDeleteAll"><span class="fa fa-trash"></span></button></th> -->
              <th>No.</th>
              <th>Part Number</th>
              <th>Nama</th>
              <th>Satuan </th>
              <th>Kategori</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($stock as $key)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td> {{ $key->kode_barang }} </td>
            <td> {{ $key->nama }} </td>
            <td> {{ $key->qty_satuan }} </td>
            <td> {{ $key->kategori }} </td>
            <td>
                <button class='btn btn-warning btn-xs' onclick="edit('{{ route('master_stock.edit',[$key->id]) }}')" ><span class='glyphicon glyphicon-pencil'></span></button>
                <button class='btn btn-xs btn-danger delete' data-id="{{$key->id}}"><span class='glyphicon glyphicon-trash'></span></button>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      {{-- end of car data  --}}
    </div>
    <!-- /.box-body -->
    <div class="box-footer"></div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->

<!-- modal konfirmasi -->

<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
        </div>
        <div class="modal-body" id="konfirmasi-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" data-id="" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Deleting..." id="confirm-delete">Delete</button>
        </div>
        </div>
      </div>
    </div>
<!-- end of modal konfirmais -->
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">
  var save_method = "add";
  $(function() {
    $('.select2').val(null).trigger('change');
    $('#alert').hide();
    $('[data-mask]').inputmask()

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var mainTable = $('#data-table').DataTable();
    var selectedRow;

    $('#data-table').on('click', '.delete', function(e) {
      e.preventDefault();
      selectedRow = mainTable.row($(this).parents('tr'));

      $("#modal-konfirmasi").modal('show');

      $("#modal-konfirmasi").find("#confirm-delete").data("id", $(this).data('id'));
      $("#konfirmasi-body").text("Hapus Data Stock?");
    });

    $('#confirm-delete').click(function(){
      var deleteButton = $(this);
      var id           = deleteButton.data("id");
      var home = "{{ route('master_stock.index') }}";


      deleteButton.button('loading');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax(
      {
        url: "master_stock/"+id,
        type: 'DELETE',
        dataType: "JSON",
        data: {
          // _method:"DELETE"
          // "id": id
        },
        success: function (response)
        {
          deleteButton.button('reset');

          selectedRow.remove().draw();

          $("#modal-konfirmasi").modal('hide');

          Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function(){
                window.location.replace(home);
            }
          })
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
  });

    

  });


  // fungsi save decissions
  function save() {
    if (save_method === "add") {
      store();
    } else {
      update();
    }

  }

  // fungsi store with ajax
  function store() {
    var formData = new FormData($('#formAdd')[0]);
    var url = "{{ route('master_stock.store') }}";
    var home = "{{ route('master_stock.index') }}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "JSON",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        $('.form-group').removeClass('has-error');
        if (response.status) {
          Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {}
          })
          // $('#data-table').DataTable().ajax.reload(); // reload datatables
          window.location.replace(home);

        }
        else {
            $('#alert').text(response.message).show();
        }
      },
      error: function(xhr, status) {
          var a = JSON.parse(xhr.responseText);
            // reset to remove error
            $('.form-group').removeClass('has-error');
            $('.help-block').hide(); // hide error span message
            $.each(a.errors, function(key, value) {
            $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('span[id^="' + key + '"]').show(); // show error message span
            // for select2
            if (!$('[name="' + key + '"]').is("select")) {
                $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
            });
      }
    });
  }

  // edit button show data
  function edit(url) {
    save_method = "update";
    //var formData = new FormData($('#formAdd')[0]);
    //var url = "{{ url('petty_cash/transaksi') }}/" + id + "";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#key').val(data.id);
        $('#_method').val('PATCH');
        $('#kode_barang').val(data.kode_barang);
        $('#nama').val(data.nama);
        $('#qty').val(data.qty);
        $('#satuan').val(data.qty_satuan);
        $('#harga').val(data.harga);
        $('#kategori').val(data.kategori).trigger('change');
      },
      error: function(xhr, status) {
        alert('Oops.. Something went wrong!!');
      }
    });
  }

  // fungsi update data
  function update() {
    var id = $('#key').val();
    var formData = new FormData($('#formAdd')[0]);

    var url = "{{ url('master_stock') }}/" + id + "";
    var home = "{{ route('master_stock.index') }}";

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "JSON",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        save_method = "add";
        $('.form-group').removeClass('has-error');
        if (response.status) {
          Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                window.location.replace(home);

            }
          })
        }
        $('#_method').val(null);
//        $('#data-table').DataTable().ajax.reload(); // reload datatables
      },
      error: function(xhr, status) {
        var a = JSON.parse(xhr.responseText);
        // reset to remove error
        $('.form-group').removeClass('has-error');
        $('.help-block').hide(); // hide error span message
        $.each(a.errors, function(key, value) {
          $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
          $('span[id^="' + key + '"]').show(); // show error message span
          // for select2
          if (!$('[name="' + key + '"]').is("select")) {
            $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
          }
        });

      }
    });


  }

  //Initialize Select2 Elements
  $('.select2').select2()

  $('.datepicker').datepicker({
    format: 'yyyy/mm/dd',
    autoclose: true
  })
</script>
@endpush