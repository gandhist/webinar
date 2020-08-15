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
        Detail Peserta
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Peserta</a></li>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body" style="margin-top:45px;">
            <h1 style="margin-top:45px; margin-bottom: 25;">Data Diri</h1>
            <form>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input value="{{ $peserta[0]['nama'] }}" id="nama" name="nama" type="text" required class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ $peserta[0]['email'] }}" id="email" name="email" type="email" class="form-control" disabled>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="no_hp">No Handphone</label>
                        <input value="{{ $peserta[0]['no_hp'] }}" id="no_hp" name="no_hp" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <input value="{{ $provinsi[0]['nama'] }}" id="provinsi" name="provinsi" type="text" class="form-control" disabled>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input value="{{ $peserta[0]['alamat'] }}" id="alamat" name="alamat" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="kota">Kota / Kabupaten</label>
                        <input value="{{ $kota[0]['nama']}}" id="kota" name="kota" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input value="{{ $peserta[0]['pekerjaan'] }}" id="pekerjaan" name="pekerjaan" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="instansi">Instansi</label>
                        <input value="{{ $peserta[0]['instansi'] }}" id="instansi" name="instansi" type="text" class="form-control" disabled>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input value="{{$peserta[0]['tgl_lahir'] ? \Carbon\Carbon::parse($peserta[0]['tgl_lahir'])->isoFormat("DD MMMM YYYY") : '' }}" id="tgl_lahir" name="tgl_lahir" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="instansi">Foto</label>
                        <div class="w-100">
                        <a data-toggle="modal" data-target="#myModal">
                            Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                        </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box-body" style="margin-top:35px;">
                        <b>Daftar Seminar yang telah di ikuti</b>
                        <table id="data-sekolah" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width:1%;"><i class="fa fa-check-square-o"></i></th>
                                    <th style="width:6%;">No</th>
                                    <th style="width:19%;">Judul</th>
                                    <th style="width:7%;">Tema</th>
                                    <th style="width:10%;">Tanggal</th>
                                    <th style="width:5%;">Waktu</th>
                                    <th style="width:10%;">Nilai SKPK</th>
                                    <th style="width:6%;">No. Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($detailseminar as $key)
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>
                                    <td style="text-align:center;">{{$loop->iteration}}</td>
                                    <td>
                                        {{ isset($key->seminar_p->nama_seminar) ? $key->seminar_p->nama_seminar : ''}}
                                    </td>
                                    <td>
                                        {{ isset($key->seminar_p->tema) ? strip_tags(html_entity_decode($key->seminar_p->tema)) :'' }}
                                    </td>
                                    <td style="text-align:center;">
                                        {{ isset($key->seminar_p) ? \Carbon\Carbon::parse($key->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}
                                    </td>
                                    <td style="text-align:center;">
                                        {{ isset($key->seminar_p->jam_awal) ? $key->seminar_p->jam_awal : '' }}
                                    </td>
                                    <td style="text-align:center;">
                                        {{ isset($key->seminar_p->skpk_nilai) ? $key->seminar_p->skpk_nilai : '' }}
                                    </td>
                                    <td>
                                        {{$key->no_srtf}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
{{-- Modal Foto --}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Foto Diri</h4>
	      </div>
	      <div class="modal-body">
	      	<center>
	        	<img class="img-responsive" src="{{ isset($peserta[0]['foto']) ? url('uploads/peserta/'.$peserta[0]['foto']) : '/'}}" alt="Foto">
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
@endsection
@push('script')
<script type="text/javascript">
    // Button edit click
    let person = {{$peserta[0]['id_personal']}}
    $('#btnEdit').on('click', function (e) {
        e.preventDefault();
        if(isNaN(person)){
            var id = "{{$id}}";
            window.location.href = "{{ url('pesertas') }}/" + id + "/edit";
        } else {
            var id = "{{$id}}";
            window.location.href = "{{ url('personals') }}/" + person + "/edit";
        }
    });
</script>
@endpush
