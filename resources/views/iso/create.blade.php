@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $judul }}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Iso</a></li>
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

                {{-- form seminar --}}
                <form class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="{{ $save_method == 'edit' ? $data->id : '' }}">
                    @csrf
                        <div class="box-body">

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input name="nama_bu" id="nama_bu" type="text" class="form-control" value="{{ $save_method == 'edit' ? $data->nama_bu : old('nama_bu') }}" placeholder="Nama Seminar">
                                        <span id="nama_bu" class="help-block"> {{ $errors->first('nama_bu') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat Lengkap Tanpa Kota dan Provinsi">{{ $save_method == 'edit' ? $data->alamat : old('alamat') }}</textarea>
                                        <span id="alamat" class="help-block"> {{ $errors->first('alamat') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="id_prov" class="form-control select2" id="id_prov" style="width: 100%;">
                                            <option></option>
                                            @foreach($provinsi as $key)
                                            <option {{ $save_method == 'edit' ? $key->id == $data->id_prov ? 'selected' : ''  : '' }} value="{{ $key->id }}">{{ $key->nama }}</option>
                                            @endforeach
                                        </select>
                                        <span id="id_prov" class="help-block customspan"> {{ $errors->first('id_prov') }}</span>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="id_kota" class="form-control select2" id="id_kota" style="width: 100%;">
                                            <option></option>
                                            @foreach($kota as $key)
                                            <option {{ $save_method == 'edit' ? $key->id == $data->id_kota ? 'selected' : ''  : '' }} value="{{ $key->id }}">{{ $key->nama }}</option>
                                            @endforeach
                                        </select>
                                        <span id="id_kota" class="help-block customspan"> {{ $errors->first('id_kota') }}</span>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="id_negara" class="form-control select2" id="id_negara" style="width: 100%;">
                                            <option></option>
                                            @foreach($negara as $key)
                                            <option {{ $key->id == '102' ? 'selected' : '' }} value="{{ $key->id }}">{{ $key->country_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="id_negara" class="help-block customspan"> {{ $errors->first('id_negara') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input name="tipe_iso" id="tipe_iso" type="text" class="form-control" value="{{ $save_method == 'edit' ? $data->tipe_iso : old('tipe_iso') }}" placeholder="Tipe ISO">
                                        <span id="tipe_iso" class="help-block customspan"> {{ $errors->first('tipe_iso') }}</span>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="scope" class="form-control" id="scope" placeholder="Ruang Lingkup/Scope">{{ $save_method == 'edit' ? $data->scope : old('scope') }}</textarea>
                                        <span id="scope" class="help-block customspan">{{ $errors->first('scope') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input value="{{ $save_method == 'edit' ? $data->no_sert : old('no_sert') }}" name="no_sert" id="no_sert" type="text" class="form-control" placeholder="No Sertifikat">
                                        <span id="no_sert" class="help-block customspan">{{ $errors->first('no_sert') }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input value="{{ $save_method == 'edit' ? $data->tgl_sert : old('tgl_sert') }}" name="tgl_sert" id="tgl_sert" autocomplete="off" data-provide="datepicker" data-date-format="yyyy/mm/dd" type="text" class="form-control" placeholder="Tanggal Sertifikat">
                                        <span id="tgl_sert" class="help-block customspan">{{ $errors->first('tgl_sert') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <button type="button" class="btn btn-default">Cancel</button>
                                <button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Menyimpan..." id="btnSave">Simpan</button>
                            </div>

                        </div>
                </form>
                {{-- end of form seminar --}}

            <div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>

<script>
// var tema = $('#tema');
// CKEDITOR.replace('tema')
// $('#biaya').prop('disabled',true)

var save_method = "{{ $save_method }}";

$(function(){

    $("#id_prov").select2({
        placeholder: "Pilih Provinsi",
    });

    $("#id_kota").select2({
        placeholder: "Pilih Kota",
    });

    $("#id_negara").select2({
        placeholder: "Pilih Negara",
    });

    $("#ttd_pemangku").select2({
        placeholder: "Tanda Tangan Pemangku",
    });

    $('#is_free_c').change(function(){
        if ($(this).prop('checked')) {
            $('#biaya').prop('disabled',false)
            $('#is_free').val('1')
        }
        else {
            $('#biaya').prop('disabled',true)
            $('#is_free').val('0')
        }
    });

    // onclick tombol simpan
    $('#btnSave').on('click', function(){
       if (save_method == 'add') {
           add()
       }
       else{
           update()
       }

        
    })

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

  function add(){
    $('#btnSave').button('loading');
        var formData = new FormData($('#formAdd')[0])
        var url = "{{ route('isos.store') }}";
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
                $('#btnSave').button('reset')
                Swal.fire({
                title: response.message,
                type: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor: '#AAA',
                onClose: function() {
                    window.location.reload();
                }
                })
            }
            else {
                $('#btnSave').button('reset')
                $('#alert').text(response.message).show();
            }
            },
            error: function(xhr, status) {
            $('#btnSave').button('reset')
            var a = JSON.parse(xhr.responseText);
            // reset to remove error
            $('.form-group').removeClass('has-error');

            $('.help-block').hide(); // hide error span message
            $.each(a.errors, function(key, value) {
                $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('span[id^="' + key + '"]').show(); // show error message span
                // for select2
                if ($('[name="' + key + '"]').hasClass("select2")) {
                    $('[name="' + key + '"]').parent().addClass('has-error-select'); //select parent twice to select div form-group class and add has-error class
                    $('[name="' + key + '"]').next().next().text(value); //select span help-block class set text error string
                }else {
                    $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string

                }
            });
            }
        });
  }

  function update(){
    $('#btnSave').button('loading');
        var formData = new FormData($('#formAdd')[0])
        formData.append('_method', 'patch');
        var id = $('#id').val()
        var url = "{{ url('isos') }}/"+id;
        var home = "{{ url('isos') }}";
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
                $('#btnSave').button('reset')
                Swal.fire({
                title: response.message,
                type: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor: '#AAA',
                onClose: function() {
                    window.location.replace(home);
                }
                })
            }
            else {
                $('#btnSave').button('reset')
                $('#alert').text(response.message).show();
            }
            },
            error: function(xhr, status) {
            $('#btnSave').button('reset')
            var a = JSON.parse(xhr.responseText);
            // reset to remove error
            $('.form-group').removeClass('has-error');

            $('.help-block').hide(); // hide error span message
            $.each(a.errors, function(key, value) {
                $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('span[id^="' + key + '"]').show(); // show error message span
                // for select2
                if ($('[name="' + key + '"]').hasClass("select2")) {
                    $('[name="' + key + '"]').parent().addClass('has-error-select'); //select parent twice to select div form-group class and add has-error class
                    $('[name="' + key + '"]').next().next().text(value); //select span help-block class set text error string
                }else {
                    $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string

                }
            });
            }
        });
  }

  $('.select2').select2()
  $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });



</script>
@endpush
