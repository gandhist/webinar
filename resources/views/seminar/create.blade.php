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

                {{-- form seminar --}}
                <form action="{{ url('seminar/store') }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">

                            <div class="col-sm-6">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('nama_seminar')}}" placeholder="Nama Seminar">
                                <span id="nama_seminar" class="help-block customspan">{{ $errors->first('nama_seminar') }}</span>
                            </div>
                            <div class="col-sm-3">
                                <select name="klasifikasi[]" multiple="multiple" class="form-control select2" id="klasifikasi" style="width: 100%;">
                                    <option></option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="sub_klasifikasi[]" multiple="multiple" class="form-control select2" id="sub_klasifikasi" style="width: 100%;">
                                    <option >Sub </option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="tema" class="form-control" id="tema" 
                                placeholder="Tulis Tema Seminar"></textarea>
                                <span id="tema" class="help-block customspan">{{ $errors->first('tema') }}</span>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-2">
                                <input name="kuota" id="kuota" type="number" 
                                class="form-control" value="{{old('kuota')}}" 
                                onkeypress="return /[0-9]/i.test(event.key)" placeholder="Kuota Peserta">
                                <span id="kuota" class="help-block customspan">{{ $errors->first('kuota') }}</span>
                            </div>

                            <div class="col-sm-2">
                                <input name="skpk_nilai" id="skpk_nilai" type="number" class="form-control" value="{{old('skpk_nilai')}}" placeholder="Nilai SKPK">
                                <span id="skpk_nilai" class="help-block customspan">{{ $errors->first('skpk_nilai') }}</span>
                            </div>

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        Berbayar?
                                      <input type="checkbox" name="is_free_c" id="is_free_c">
                                      <input type="hidden" name="is_free" id="is_free">
                                    </span>
                                    <input name="biaya" id="biaya" type="number"
                                    onkeypress="return /[0-9]/i.test(event.key)"
                                    class="form-control" value="{{old('biaya')}}" placeholder="Biaya">
                                </div>
                                <span id="biaya" class="help-block customspan"> {{ $errors->first('biaya') }}</span>
                            </div>

                            <div class="col-sm-2">
                                <select name="inisiator" class="form-control select2" id="inisiator"  style="width: 100%;">
                                    <option></option>
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <select name="penyelenggara" class="form-control select2" id="penyelenggara"  style="width: 100%;">
                                    <option></option>
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <select name="pendukung" class="form-control select2" id="pendukung"  style="width: 100%;">
                                    <option></option>
                                    @foreach($inisiator as $key)
                                        <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-4">
                                <input placeholder="Tanggal Mulai Seminar" type="text" autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" class="form-control" id="tgl_awal" name="tgl_awal" > 
                                <span id="tgl_awal" class="help-block" > {{ $errors->first('tgl_awal') }} </span>
                            </div>
                            <div class="col-sm-2">
                                <input name="jam_awal" id="jam_awal" type="text" class="form-control" value="{{old('jam_awal')}}" placeholder="Jam Mulai Seminar">
                                <span id="jam_awal" class="help-block customspan">{{ $errors->first('jam_awal') }}</span>
                            </div>

                            <div class="col-sm-6">
                                <select name="id_prop" class="form-control select2" id="id_prop" style="width: 100%;">
                                    <option></option>
                                    @foreach($provinsi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-4">
                                <input placeholder="Tanggal Berakhir Seminar" type="text" autocomplete="off" data-provide="datepicker" data-date-format="dd/mm/yyyy" class="form-control" id="tgl_akhir" name="tgl_akhir" > 
                                <span id="tgl_akhir" class="help-block" > {{ $errors->first('tgl_akhir') }} </span>
                            </div>
                            <div class="col-sm-2">
                                <input name="jam_akhir" id="jam_akhir" type="text" class="form-control" value="{{old('jam_akhir')}}" placeholder="Jam Berakhir Seminar">
                                <span id="jam_akhir" class="help-block customspan">{{ $errors->first('jam_akhir') }}</span>
                            </div>

                            <div class="col-sm-6">
                                <select name="ttd_pemangku[]" multiple="multiple" class="form-control select2" id="ttd_pemangku" style="width: 100%;">
                                    <option></option>
                                    @foreach($provinsi as $key)
                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    <button type="submit">kirjm</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script> -->

<script>
var tema = $('#tema');
CKEDITOR.replace('tema')
$('#biaya').prop('disabled',true)
// $('#biaya').mask('0.000.000.000.000', {reverse:true})

$(function(){

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

  // onclick button hapus
    $('#btnHapus').on('click', function (e)
    {
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

    // placeholder klasifikasi multiple
    $("#klasifikasi").select2({
        placeholder: "Klasifikasi"
    })

    // placeholder sub klasifikasi multiple
    $("#sub_klasifikasi").select2({
        placeholder: "Sub Klasifikasi"
    })

    // placeholder inisiator
    $("#inisiator").select2({
        placeholder: "Inisiator Penyelenggara",
        allowClear: true
    })

    // placeholder provinsi seminar
    $("#id_prop").select2({
        placeholder: "Provinsi",
        allowClear: true
    })

    // placeholder ttd_pemangku
    $("#ttd_pemangku").select2({
        placeholder: "Tanda Tangan Pemangku",
        allowClear: true
    })

    // placeholder ttd_pemangku
    $("#penyelenggara").select2({
        placeholder: "Instansi Penyelenggara",
        allowClear: true
    })

    // placeholder ttd_pemangku
    $("#pendukung").select2({
        placeholder: "Instansi Pendukung",
        allowClear: true
    })



});



  $('.select2').select2()
  $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });



</script>
@endpush
