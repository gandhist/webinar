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
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron"  style='padding-top:1px'>

                <h1 style="margin-bottom:50px;">Seminar</h1>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->first('nama_seminar') ? 'has-error' : '' }}">
                            <label for="nama_seminar" class="label-control required">Judul</label>
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
                                value="{{ isset($seminar->klasifikasi) ? $seminar->seminar_klas->Deskripsi : ''}}" readonly>
                            <div id="klasifikasi" class="invalid-feedback text-danger">
                                {{ $errors->first('klasifikasi') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group {{ $errors->first('sub_klasifikasi') ? 'has-error' : '' }}">
                            <label for="sub_klasifikasi" class="label-control required">Sub-klasifikasi</label>
                            <input type="text" id="sub_klasifikasi" class="form-control" name="sub_klasifikasi"
                                placeholder="" value="{{ isset($seminar->sub_klasifikasi) ? $seminar->seminar_sub->Deskripsi : ''}}" readonly>
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
                                value="{{ strip_tags(html_entity_decode($seminar->tema)) }}" readonly>
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
                        <div class="form-group {{ $errors->first('lokasi_penyelenggara') ? 'has-error' : '' }} ">
                            <label for="lokasi_penyelenggara" class="label-control required">Lokasi Penyelenggara</label>
                                <input type="text" readonly class="form-control"
                                value="{{isset($seminar->lokasi_penyelenggara) ? $seminar->lokasi_penyelenggara : ''}}">
                            <div id="lokasi_penyelenggara" class="invalid-feedback text-danger">
                                {{ $errors->first('lokasi_penyelenggara') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group {{ $errors->first('is_online') ? 'has-error' : '' }} ">
                        <label for="is_online" class="label-control required">Jenis Acara</label>
                            <input type="text" readonly class="form-control"
                            value="@if(isset($seminar->is_online)){{$seminar->is_online == '0' ? 'Offline' : 'Online (Webinar)'}}
                                @else{{''}}
                                @endif
                            ">
                        <div id="is_online" class="invalid-feedback text-danger">
                            {{ $errors->first('is_online') }}
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" readonly class="form-control"
                                        value="{{$key->nama}}">
                                    </div>
                                </div>
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

                        <div class="row">
                            @foreach($moderator as $key)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" readonly class="form-control"
                                        value="{{$key->nama}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

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

                <div class="row" style="margin-bottom:50px;">
                    @if($seminar->is_online == 0)
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                                <label>Browsur Seminar</label>
                                <div>
                                    <a data-toggle="modal" data-target="#myModal">
                                        Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                                <label>Browsur Seminar</label>
                                <div>
                                    <a data-toggle="modal" data-target="#myModal">
                                        Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('instansi_penyelenggara') ? 'has-error' : '' }} ">
                            <label>Link</label>
                                <div class="col-6">
                                    <form action="{{ url('seminar/kirimlink',$seminar->id) }}" class="form-horizontal" id="formAdd" name="formAdd"
                                    method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input name="link" id="link" type="text">
                                        <button type="submit">Kirim</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- <div class="box-body">     --}}
                  <b>Daftar Peserta</b>
                  <a href="{{ url('seminar/kirim_email', $seminar->id) }}" class="btn btn-primary btn-sm"> Send Bulk Email</a>
                  <br>
                  <br>
                  <table id="example" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                      <thead>
                          <tr role="row">
                              {{-- <th style="width:4%;"><i class="fa fa-check-square-o"></i></th> --}}
                              <th style="width:5%;">No</th>
                              <th style="width:10%;">Status</th>
                              <th style="width:10%;">No_srtf</th>
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
                            <td style="text-align: center">
                                @if($key->status == '1') Peserta
                                @elseif($key->status == '2') Narasumber
                                @elseif($key->status == '4') Moderator
                                @else Panitia
                                @endif
                            </td>
                            <td>{{ $key->no_srtf }}</td>
                            <td>{{ $key->peserta_r->nama }}</td>
                            <td>{{$key->peserta_r->no_hp}}</td>
                            <td>{{$key->peserta_r->email}}</td>
                            <td style='text-align:center;'>@if ($key->is_paid == null) - @elseif ($key->is_paid == '1') Sudah Bayar @else Belum Bayar @endif </td>
                            <td>@if($key->seminar_p->is_actived == 0)
                                @else
                                    @if($key->is_paid == null)
                                        <a target="_blank" href="{{ url('seminar/cetak_sertifikat', $key->no_srtf) }}" class="btn btn-success btn-sm"> Cetak Sertifikat</a>
                                        <a href="{{ url('seminar/send_email', $key->no_srtf) }}" class="btn btn-primary btn-sm"> Kirim Email</a>
                                    @elseif ($key->is_paid == 1)
                                        <a target="_blank" href="{{ url('seminar/cetak_sertifikat', $key->no_srtf) }}" class="btn btn-success btn-sm"> Cetak Sertifikat</a>
                                        <a href="{{ url('seminar/send_email', $key->no_srtf) }}" class="btn btn-primary btn-sm"> Kirim Email</a>
                                    @else
                                        <a href="{{ url('seminar/approve', $key->id) }}" class="btn btn-success btn-sm"> Approve</a>
                                        <button type="button" id="btnBukti"
                                            onclick='tampilLampiran("{{ asset("$key->bukti_bayar") }}","Bukti Bayar")'
                                            class="btn btn-primary btn-sm">
                                        <i class="fa fa-file-pdf-o"></i> Bukti Bayar</button>
                                    @endif
                                @endif
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

    {{-- Modal Foto --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Brosur Seminar</h4>
	      </div>
	      <div class="modal-body">
	      	<center>
              <img src="{{isset($seminar->link) ? url($seminar->link) : ''}}" alt="Brosur Seminar"
                            class="img-thumbnail center" style="width:50%">
	        </center>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

{{-- Akhir Modal Foto --}}
</section>

<!-- Modal Lampiran -->
<div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
      <div class="modal-content">
        <div class="modal-header">
              <h3 class="modal-title" id="lampiranTitle"></h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                  <iframe src="" id="iframeLampiran" width="100%" height="200px" frameborder="0" allowtransparency="true"></iframe>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>

      </div>
    </div>
  </div>
  <!-- End of Modal Lampiran -->

@endsection

@push('script')
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(document).ready(function() {
		$('#example').DataTable({
            lengthMenu: [100, 200, 500],});
	} );
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

// pop up pdf
function tampilLampiran(url, title) {

    $('#modalLampiran').modal('show');
    $('#iframeLampiran').attr('src', url);
    $('#lampiranTitle').html(` <a href="` + url + `" target="_blank" > ` + title + ` </a> `);
}
</script>
@endpush
