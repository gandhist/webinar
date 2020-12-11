@extends('frontend.main')
<style>
    td {
        min-height: 2rem;
    }
    .customTable thead {
        background-color: #b7d0ed;
    }
    td>a.btn {
        margin: 0.3ewm
    }
    .button-flash {
        background-color: #004A7F;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        border: none;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-family: Arial;
        font-size: 20px;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        -webkit-animation: glowing 3000ms infinite;
        -moz-animation: glowing 3000ms infinite;
        -o-animation: glowing 3000ms infinite;
        animation: glowing 3000ms infinite;
    }
    @-webkit-keyframes glowing {
        0% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
        50% { background-color: #15ff00; -webkit-box-shadow: 0 0 40px #15ff00; }
        100% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
    }

    @-moz-keyframes glowing {
        0% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
        50% { background-color: #15ff00; -moz-box-shadow: 0 0 40px #15ff00; }
        100% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
    }

    @-o-keyframes glowing {
        0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
        50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
        100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
    }

    @keyframes glowing {
        0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
        50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
        100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
    }
    .button-flash-biru {
  background-color: #004A7F;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: Arial;
  font-size: 20px;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing 3000ms infinite;
  -moz-animation: glowing 3000ms infinite;
  -o-animation: glowing 3000ms infinite;
  animation: glowing 3000ms infinite;
}
@-webkit-keyframes glowing {
  0% { background-color: #1332bd; -webkit-box-shadow: 0 0 3px #1332bd; }
  50% { background-color: #2854ce; -webkit-box-shadow: 0 0 40px #2854ce; }
  100% { background-color: #1332bd; -webkit-box-shadow: 0 0 3px #1332bd; }
}

@-moz-keyframes glowing {
  0% { background-color: #1332bd; -moz-box-shadow: 0 0 3px #1332bd; }
  50% { background-color: #2854ce; -moz-box-shadow: 0 0 40px #2854ce; }
  100% { background-color: #1332bd; -moz-box-shadow: 0 0 3px #1332bd; }
}

@-o-keyframes glowing {
  0% { background-color: #1332bd; box-shadow: 0 0 3px #1332bd; }
  50% { background-color: #2854ce; box-shadow: 0 0 40px #2854ce; }
  100% { background-color: #1332bd; box-shadow: 0 0 3px #1332bd; }
}

@keyframes glowing {
  0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
  50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
  100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
}
</style>

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<script>
    FontAwesomeConfig = { autoReplaceSvg: false }
</script>

<div class="container" id="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            <h2 text-align="center">Jadwal Kegiatan Peserta</h2>
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

        </div>
    </div>


    <div class="box-body">
        <table id="example" class="table table-striped table-bordered dataTable customTable" role="grid">
            <thead>
                <tr role="row">
                    <th style="width:1%;text-align:center;">No</th>
                    <th style="width:17%;text-align:center;">Jenis Kegiatan</th>
                    <th style="width:17%;text-align:center;">Judul</th>
                    <th style="width:10%;text-align:center;">Jadwal</th>
                    {{-- <th style="width:5%;text-align:center;">Waktu</th> --}}
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
                        <a class="" href="{{ url('kegiatan/detail', $key->seminar_p->id) }}" data-toggle="tooltip"
                            data-placement="bottom" title="Lihat Detail">
                            {{$key->seminar_p->nama_seminar}}</a>
                    </td>
                    <td style="text-align:center;">
                        {{strip_tags(html_entity_decode($key->seminar_p->tema))}}
                    </td>
                    <td style="text-align:center;">
                        {{ isset($key->seminar_p) ? \Carbon\Carbon::parse($key->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}
                    </td>
                    {{-- <td style="text-align:center;">
                        {{$key->seminar_p->jam_awal}}
                    </td> --}}
                    <td style="text-align:center;">
                        {{$key->seminar_p->skpk_nilai}}
                    </td>
                    <td style="text-align:center;">
                        @php $dec =  Vinkla\Hashids\Facades\Hashids::encode($key->id) @endphp

                        @if ($key->is_paid == '1')
                            @if(isset($key->presensi->jam_cek_out) == null)
                                @if(isset($key->presensi->jam_cek_in) == null)
                                    <a class="btn btn-sm btn-success {{ strtotime($key->seminar_p->tgl_awal) == strtotime($hari) ? "button-flash" : ''}}" target="_blank" href="{{ url('presensi', $dec) }}" data-toggle="tooltip"
                                    data-placement="bottom" title="Klik untuk mengikuti kegiatan"> Ikut Kegiatan ({{$key->seminar_p->jam_awal}} WIB)</a>
                                @else
                                <a class="btn btn-sm btn-primary  {{ strtotime($key->seminar_p->tgl_awal) == strtotime($hari) ? 'button-flash-biru' : ''}}" target="_blank" href="{{ url('presensi', $dec) }}"> {{ isset($key->presensi) ? \Carbon\Carbon::parse($key->presensi->jam_cek_in)->isoFormat("DD MMMM YYYY H:m") : '' }} </a>
                                @endif
                            @else
                            <a class="btn btn-sm btn-primary" target="_blank" href="{{ url('presensi', $dec) }}"> {{ isset($key->presensi) ? \Carbon\Carbon::parse($key->presensi->jam_cek_in)->isoFormat("DD MMMM YYYY H:m") : '' }} </a><br><br>
                            <button class="btn btn-sm btn-secondary">{{ isset($key->presensi->jam_cek_out) ? \Carbon\Carbon::parse($key->presensi->jam_cek_out)->isoFormat("DD MMMM YYYY H:m") : '' }}</button>
                            @endif

                        @elseif ($key->is_paid == '0')
                            <button class="btn btn-warning">
                                <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                    Menunggu Pembayaran
                                </a>
                            </button>
                        @elseif ($key->is_paid == '2')
                            <button class="btn btn-warning">
                                <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                    Sedang Diproses
                                </a>
                            </button>
                        @elseif ($key->is_paid == '3')
                            <button class="btn btn-warning">
                                <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                    Pembayaran Gagal
                                </a>
                            </button>
                        @elseif ($key->is_paid == '4')
                            <button class="btn btn-danger">
                                <a href="{{url('pembayaran')}}" style="text-decoration: none; color: black">
                                    Pembayaran Kadaluwarsa
                                </a>
                            </button>
                        @elseif ($key->is_paid == '5')
                            <button class="btn btn-danger">
                                <a href="{{url('pembayaran')}}" style="text-decoration: none; color: black">
                                    Pembayaran Dibatalkan
                                </a>
                            </button>
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
                            <a href="{{ url('sertifikat', Illuminate\Support\Facades\Crypt::encrypt($key->no_srtf)) }}" target="_blank" type="submit" class="btn btn-sm btn-success"> <i class="fa fa-eye"></i> Sertifikat</a>
                        @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    <!-- /.box-body -->
    <div class="box-footer">

    </div>
</div>

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
