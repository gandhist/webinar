@extends('frontend.main')
<style>
    .customTable thead {
        background-color: #b7d0ed;
    }
</style>

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<div class="container" id="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            <h2 text-align="center">Edit Profile</h2>
            {{-- <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="color: black"><h2 text-align="center">Edit Profile</h2></a> --}}
            <hr>
            @if(session()->get('success'))
            <div class="alert alert-success"> {{ session()->get('success') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            @if(session()->get('first'))
            <div class="alert alert-success"> {{ session()->get('first') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            @if(session()->get('second'))
            <div class="alert alert-warning"> {{ session()->get('second') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            @if(session()->get('third'))
            <div class="alert alert-warning"> {{ session()->get('third') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- <div class="collapse" id="collapseExample"> --}}
                <form action="{{ route('profile.update') }}" class="form-horizontal" id="formAdd" name="formAdd"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <img style="width:70%;" src="{{ url('uploads/peserta/'.$user->peserta->foto) }}">
                                <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto"
                                    {{ $errors->first('foto') ? 'is-invalid' : '' }} style="
                                    padding-top: 5px;padding-bottom:5px;" class="img">
                            </div>
                            <div class="col-sm-6">
                                <table>
                                    <tr>
                                        <th style="width:10%;text-align:left">Nama</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="nama" id="nama" type="text" class="form-control"
                                                value="{{ old('nama', $user->peserta->nama) }}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:10%;text-align:left">Email</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="email" id="email" type="text" class="form-control"
                                                value="{{old('email', $user->peserta->email)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:10%;text-align:left">No_HP</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="no_hp" id="no_hp" type="text" class="form-control"
                                                value="{{old('no_hp', $user->peserta->no_hp)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:10%;text-align:left">Pekerjaan</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="pekerjaan" id="pekerjaan" type="text" class="form-control"
                                                value="{{old('pekerjaan', $user->peserta->pekerjaan)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:10%;text-align:left">Instansi</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="instansi" id="instansi" type="text" class="form-control"
                                                value="{{old('instansi', $user->peserta->instansi)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:40%;text-align:left">No Regist SKA</th>
                                        {{-- <td>:</td> --}}
                                        <td><input name="nrska" id="nrska" type="text" class="form-control"
                                                value="{{old('nrska', $user->peserta->nrska)}}"></td>
                                    </tr>

                                    <tr>
                                        <th style="width:40%;text-align:left">Total Nilai SKPI Pertahun</th>
                                        {{-- <td>:</td> --}}
                                        <td>
                                            <input name="nilai_skpi" id="nilai_skpi" type="text" class="form-control"
                                        value="{{ $user->peserta->skpk_total }}" readonly>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th style="width:30%;text-align:left">File KTP</th>
                                        <td>:</td>
                                        <td>
                                            @if (isset($user->peserta->ktp))
                                            <a target="_blank" href="{{ $user->peserta->ktp }}" data-toggle="tooltip"
                                            data-placement="top" title="Lihat KTP">Lihat</a>
                                            @else
                                            <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="ktp" name="ktp"
                                            {{ $errors->first('ktp') ? 'is-invalid' : '' }}>
                                            @endif
                                        </td>
                                        <td><input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="ktp" name="ktp"
                                            {{ $errors->first('ktp') ? 'is-invalid' : '' }}></td>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                        {{-- <div class="row">
                                <div class="col-sm-2">
                                    <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto"  {{ $errors->first('foto') ? 'is-invalid' : '' }}
                        >
                            </div>
                        </div> --}}
                    </div>
                    <br>
                    <div class="box-footer">
                        <a href="{{ url('changepassword') }}" class="btn btn-sm btn-warning pull-left"><i class="fa fa-edit"></i>
                            Ubah_Password</a>
                        <a href="{{ url('infoseminar') }}" class="btn btn-sm btn-danger pull-right"><i class="fa fa-times-circle"></i>
                            Batal</a>
                        <button type="submit" class="btn btn-sm btn-primary pull-right"> <i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            {{-- </div> --}}
        </div>
    </div>

    {{-- <br> --}}
    {{-- <div class="box-body">
        <b>Daftar Seminar yang telah di ikuti</b>
        <br>
        <table id="example" class="table table-striped table-bordered dataTable customTable" role="grid">
            <thead>
                <tr role="row">
                    <th style="width:1%;text-align:center;">No</th>
                    <th style="width:14%;text-align:center;">Jenis Kegiatan</th>
                    <th style="width:17%;text-align:center;">Judul</th>
                    <th style="width:10%;text-align:center;">Jadwal</th>
                    <th style="width:8%;text-align:center;">SKPK</th>
                    <th style="width:10%;text-align:center;">Awal - Akhir Kegiatan</th>
                    <th style="width:5%;text-align:center;">Materi</th>
                    <th style="width:5%;text-align:center;">Sertifikat</th>

                </tr>
            </thead>
            <tbody>
                @foreach($detailseminar as $key)
                <tr>
                    <td style="text-align:center;">{{$loop->iteration}}</td>
                    <td style="text-align:center;">
                        <a class="" href="{{ url('detail_seminar', $key->seminar_p->id) }}" data-toggle="tooltip"
                            data-placement="bottom" title="Lihat Detail">
                            {{$key->seminar_p->nama_seminar}}</a>
                    </td>
                    <td style="text-align:center;">
                        {{strip_tags(html_entity_decode($key->seminar_p->tema))}}
                    </td>
                    <td style="text-align:center;">
                        {{ isset($key->seminar_p) ? \Carbon\Carbon::parse($key->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}
                    </td>
                    <td style="text-align:center;">
                        {{$key->seminar_p->skpk_nilai}}
                    </td>
                    <td style="text-align:center;">
                        @php $dec =  Vinkla\Hashids\Facades\Hashids::encode($key->id) @endphp
                        @if(isset($key->presensi->jam_cek_out) == null)
                            @if(isset($key->presensi->jam_cek_in) == null)
                                <a class="btn btn-sm btn-primary pull-right" target="_blank" href="{{ url('presensi', $dec) }}"> Ikut Kegiatan </a>
                            @else
                            <a class="btn btn-sm btn-primary pull-right" target="_blank" href="{{ url('presensi', $dec) }}"> {{ isset($key->presensi) ? \Carbon\Carbon::parse($key->presensi->jam_cek_in)->isoFormat("DD MMMM YYYY H:m") : '' }} </a>
                            @endif
                        @else
                        <a class="btn btn-sm btn-primary pull-right" target="_blank" href="{{ url('presensi', $dec) }}"> {{ isset($key->presensi) ? \Carbon\Carbon::parse($key->presensi->jam_cek_in)->isoFormat("DD MMMM YYYY H:m") : '' }} </a><br><br>
                        <button class="btn btn-sm btn-secondary pull-right">{{ isset($key->presensi->jam_cek_out) ? \Carbon\Carbon::parse($key->presensi->jam_cek_out)->isoFormat("DD MMMM YYYY H:m") : '' }}</button>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if(isset($key->presensi->jam_cek_out) == null)
                        @else
                            @if(isset($key->seminar_p->materi))
                            <a href="{{url($key->seminar_p->materi)}}" class="download-link btn btn-sm btn-primary" download=""> <i class="fa fa-download" ></i> Download</a>

                            @endif
                        @endif
                    </td>
                    <td>
                        @if(isset($key->presensi->jam_cek_out) != null)
                            <a href="{{ url('sertifikat', Illuminate\Support\Facades\Crypt::encrypt($key->no_srtf)) }}" target="_blank" type="submit" class="btn btn-sm btn-success pull-right"> <i class="fa fa-eye"></i> Sertifikat</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    <!-- /.box-body -->
    <div class="box-footer">

    </div>
</div>

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
              <img class="img-responsive" src="{{ isset($user->peserta->ktp) ? url($user->peserta->ktp) : ''}}" alt="Foto">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" >
$(document).ready(function() {
		$('#example').DataTable();
} );
</script>
@endpush
