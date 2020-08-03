@extends('templates.header')

@section('content')

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Edit</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron">
              
                <h1 style="margin-bottom:50px;">Seminar</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('nama_seminar') ? 'has-error' : '' }}">
                            <label for="nama_seminar" class="label-control required">Title</label>
                            <input type="text" id="nama_seminar" class="form-control" name="nama_seminar"
                                placeholder="Nama Seminar" value="{{$seminar->nama_seminar ? $seminar->nama_seminar : ''}}"  readonly>
                            <div id="nama_seminar" class="invalid-feedback text-danger">
                                {{ $errors->first('nama_seminar') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('klasifikasi') ? 'has-error' : '' }}">
                            <label for="klasifikasi" class="label-control required">Klasifikasi</label>
                            <input type="text" id="klasifikasi" class="form-control" name="klasifikasi" placeholder=""
                                value="" readonly>
                            <div id="klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('klasifikasi') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('sub_klasifikasi') ? 'has-error' : '' }}">
                            <label for="sub_klasifikasi" class="label-control required">Sub-klasifikasi</label>
                            <input type="text" id="sub_klasifikasi" class="form-control" name="sub_klasifikasi"
                                placeholder="" value="" readonly>
                            <div id="sub_klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('sub_klasifikasi') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->first('tema') ? 'has-error' : '' }}">
                            <label for="tema" class="label-control required">Tema</label>
                            <input type="text" id="tema_seminar" class="form-control" name="tema_seminar" placeholder=""
                                value="{{ $seminar->tema ? $seminar->tema : '' }}" readonly>
                            <div id="tema" class="invalid-feedback text-danger">
                                {{ $errors->first('tema') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('tgl_awal') ? 'has-error' : '' }} ">
                            <label for="tgl_awal" class="label-control required">Tanggal</label>
                            <input type="text" class="form-control" name="tgl_awal" id="tgl_awal" 
                            value='{{ isset($seminar->tgl_awal) ? \Carbon\Carbon::parse($seminar->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }}'
                                placeholder="" readonly>
                            <div id="tgl_awal" class="invalid-feedback text-danger">
                                {{ $errors->first('tgl_awal') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('jam_awal') ? 'has-error' : '' }} ">
                            <label for="jam_awal" class="label-control required">Jam</label>
                            <input type="text" class="form-control" name="jam_awal" id="jam_awal" value="{{ $seminar->jam_awal }}"
                                placeholder="" readonly>
                            <div id="tgl_akhir" class="invalid-feedback text-danger">
                                {{ $errors->first('jam_awal') }}
                            </div>
                        </div>
                    </div>
  
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('skpk_nilai') ? 'has-error' : '' }} ">
                            <label for="skpk_nilai" class="label-control required">SKPK</label>
                            <input type="text" class="form-control" name="skpk_nilai" id="skpk_nilai" value=""
                                placeholder="{{ $seminar->skpk_nilai ? $seminar->skpk_nilai : '' }}" readonly>
                            <div id="skpk_nilai" class="invalid-feedback text-danger">
                                {{ $errors->first('skpk_nilai') }}
                            </div>
                        </div>
                    </div>

                 
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('biaya') ? 'has-error' : '' }} ">
                            <label for="biaya" class="label-control required">Biaya Investasi</label>
                            <input type="text" class="form-control" name="biaya" id="biaya"
                                value="@if ($seminar->is_free == '0') Gratis @else Rp {{ format_uang($seminar->biaya)}} @endif" placeholder="" readonly>
                            <div id="biaya" class="invalid-feedback text-danger">
                                {{ $errors->first('biaya') }}
                            </div>
                        </div>
                    </div>
            
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group {{ $errors->first('narasumber') ? 'has-error' : '' }} ">
                      <label for="narasumber" class="label-control required">Narasumber</label>
                        <div class="row">
                            @foreach($narasumber as $key)
                                @if(isset($personal[$key->id_personal]))
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control"
                                            value="{{$personal[$key->id_personal]}}">
                                        </div>
                                    </div>
                                @else
                                @endif
                            @endforeach
                        </div>
                      <div id="narasumber" class="invalid-feedback text-danger">
                          {{ $errors->first('narasumber') }}
                      </div>
                    </div>
                  </div>
 
                  <div class="col-md-6">
                    <div class="form-group {{ $errors->first('moderator') ? 'has-error' : '' }} ">
                      <label for="moderator" class="label-control required">Moderator</label>
                      <input type="text" class="form-control" name="moderator" id="moderator" value="{{isset($moderator->nama) ? $moderator->nama : ''}}"
                                placeholder="" readonly>
                      <div id="moderator" class="invalid-feedback text-danger">
                          {{ $errors->first('moderator') }}
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                        <label for="instansi_penyelenggara" class="label-control required">Instansi Penyelengara</label>
                            <div class="row">
                                @foreach($instansi as $key)
                                    @if(isset($bu[$key->id_instansi]))
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                value="{{$bu[$key->id_instansi]}}">
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                        <label>Instansi Pendukung</label>
                            <div class="row">
                                @foreach($pendukung as $key)
                                    @if(isset($bu[$key->id_instansi]))
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                value="{{$bu[$key->id_instansi]}}">
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>  

                {{-- instansi original --}}
                {{--
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                      <label for="instansi_penyelenggara" class="label-control required">Instansi Penyelengara</label>
                      <input type="text" class="form-control" name="instansi_penyelenggara" id="instansi_penyelenggara" value=""
                                placeholder="" readonly>
                      <div id="instansi_penyelenggara" class="invalid-feedback text-danger">
                          {{ $errors->first('instansi_penyelenggara') }}
                      </div>
                    </div>
                  </div>
 
                  <div class="col-md-6">
                    <div class="form-group {{ $errors->first('instansi_pendukung') ? 'has-error' : '' }} ">
                      <label for="instansi_pendukung" class="label-control required">Instansi Pendukung</label>
                      <input type="text" class="form-control" name="instansi_pendukung" id="instansi_pendukung" value=""
                                placeholder="" readonly>
                      <div id="instansi_pendukung" class="invalid-feedback text-danger">
                          {{ $errors->first('instansi_pendukung') }}
                      </div>
                    </div>
                  </div>
                </div>  
                
                --}}
                {{-- instansi original --}}

                {{-- <div class="box-body">     --}}
                  <b>Daftar Peserta</b>
                  <a href="{{ url('seminar/kirim_email') }}" class="btn btn-primary btn-sm"> Send Bulk Email</a>
                  <table id="data-peserta" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                      <thead>
                          <tr role="row">
                              {{-- <th style="width:4%;"><i class="fa fa-check-square-o"></i></th> --}}
                              <th style="width:5%;">No</th>
                              <th style="width:25%;">Nama</th>
                              <th style="width:15%;">No HP</th>
                              <th style="width:15%;">Email</th>
                              <th style="width:10%;">Sts_Bayar</th>
                              <th style="width:1%;">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($detailseminar as $key)  
                         <tr>
                          {{-- <td style='text-align:center;'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                            id="selection[]" name="selection[]"></td> --}}
                          <td style='text-align:center;'>{{ $loop->iteration}}</td>
                            <td>{{ $key->peserta_r->nama }}                           
                            </td>
                            <td>{{$key->peserta_r->no_hp}}</td>
                            <td>{{$key->peserta_r->email}}</td>
                            <td style='text-align:center;'>@if ($key->is_paid == 1) Sudah Bayar @else Belum Bayar @endif </td>
                            <td>
                                <a target="_blank" href="{{ url('seminar/cetak_sertifikat', $key->no_srtf) }}" class="btn btn-success btn-sm"> Cetak Sertifikat</a>
                                <a href="{{ url('seminar/send_email', $key->id_peserta) }}" class="btn btn-primary btn-sm"> Kirim Email</a>
                            </td>
                         </tr>
                         @endforeach
                      </tbody>
                  </table>
              {{-- </div>   --}}
              <a href="{{ url('seminar') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
        </div> {{-- Jumbotron --}}
      </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}
</section>

@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
var msg = '{{Session::get('alert')}}';
var exist = '{{Session::has('alert')}}';
    if(exist){
        Swal.fire({
            title: msg,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA'
            });
        }
</script>
@endpush
