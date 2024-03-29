@extends('frontend.main')

@section('content')
<style>
  .customTable thead {
    background-color: #b7d0ed;
  }
  @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
    table.dataTable>tbody>tr.child {
        padding: 0px 0px;
    }
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<script>
  FontAwesomeConfig = { autoReplaceSvg: false }
</script>
<div class="container-fluid" id="content">
  @if(session()->get('success'))
    <div class="alert alert-success"> {{ session()->get('success') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
  @endif
  @if(session()->get('warning'))
    <div class="alert alert-warning"> {{ session()->get('warning') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
  @endif
  <h2>Info Seminar P<sub>3</sub>SM</h2>
  <hr>
  <table id="example" class="table table-striped table-bordered dataTable customTable" style="width:100%">
    <thead>
      <tr>
        <th style="width:2%;text-align:center">No</th>
        <th style="text-align:center">Jenis Kegiatan</th>
        <th style="text-align:center">Judul</th>
        <th style="text-align:center">Jadwal Kegiatan</th>
        <th style="text-align:center">Tempat</th>
        <th style="text-align:center">Narasumber</th>
        <th style="width:7%;text-align:center;">Biaya</th>
        <th style="text-align:center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key)
      <tr>
          <td>{{ $loop->iteration}}</td>
          {{-- <td>{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($key->tema)),40) }}</td> --}}
          <td>{{ $key->nama_seminar }} <br> {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td>
          <td>{{ strip_tags(html_entity_decode($key->tema)) }}</td>
          <td>
            {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }} -
            {{ isset($key->tgl_akhir) ? \Carbon\Carbon::parse($key->tgl_akhir)->isoFormat("DD MMMM YYYY") : ''  }}
          </td>
          <td>{{ $key->lokasi_penyelenggara }}</td>
          <td>
            <ul>
            @foreach($key->seminar_r as $index => $select)
              @if(count($key->seminar_r) > $index + 1)
              <li>{{ $select->peserta_r->nama }} </li>
              @else
              <li>{{ $select->peserta_r->nama }} </li>
              @endif
            @endforeach
            </ul>
          </td>
          <td>@if ($key->is_free == '0') Gratis @else Rp. {{ format_uang($key->biaya)}} @endif</td>
          <td>
            @php
              if ($user == 'Error') {
                $cek = 0;
              } else {
                $cek = DB::table('srtf_peserta_seminar')->where('id_peserta',$user['id'])->where('id_seminar', $key->id)->where('deleted_at',null)->count();
                $detail_ps = DB::table('srtf_peserta_seminar')->where('id_peserta',$user['id'])->where('id_seminar', $key->id)->where('deleted_at',null)->first();
              }
            @endphp
            @if($key->kuota_temp == 0)
            <button class="btn btn-primary disabled"> Kuota Peserta Sudah Penuh</button>
            @else
              @if($cek > 0)
                @if ($peserta->where('id_seminar',$key->id)->first() !== null )
                    @if($peserta->where('id_seminar',$key->id)->first()->is_paid == '1')
                        <button class="btn btn-success disabled">Terdaftar ({{\Carbon\Carbon::parse($peserta->where('id_seminar',$key->id)->first()->created_at)->format('d M Y H:i')}} )</button><br>
                        (untuk mengikuti seminar, silahkan ke menu Kegiatan <span class="d-inline d-lg-none">pada tombol <button class="btn btn-dark" type="button"
                        data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-align-justify"></i></button></span> )
                    @elseif($peserta->where('id_seminar',$key->id)->first()->is_paid == '0')
                        <button class="btn btn-warning">
                            <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                Menunggu Pembayaran
                            </a>
                        </button>
                    @elseif($peserta->where('id_seminar',$key->id)->first()->is_paid == '2')
                        <button class="btn btn-warning">
                            <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                Sedang Diproses
                            </a>
                        </button>
                    @elseif($peserta->where('id_seminar',$key->id)->first()->is_paid == '3')
                        <button class="btn btn-warning">
                            <a href="{{url('pembayaran')}}" style="text-decoration: none; color: gray">
                                Pembayaran Gagal
                            </a>
                        </button>
                    @elseif($peserta->where('id_seminar',$key->id)->first()->is_paid == '4')
                        <button class="btn btn-danger">
                            <a href="{{url('pembayaran')}}" style="text-decoration: none; color: white">
                                Pembayaran Kadaluwarsa
                            </a>
                        </button>
                    @elseif($peserta->where('id_seminar',$key->id)->first()->is_paid == '5')
                        <button class="btn btn-danger">
                            <a href="{{url('pembayaran')}}" style="text-decoration: none; color: white">
                                Pembayaran Dibatalkan
                            </a>
                        </button>
                    @endif
                        {{-- @else
                    <button class="btn btn-success disabled">Terdaftar</button> --}}
                @endif
              @else
              {{-- <button class="btn btn-success button-flash"> --}}
                <a href="{{ url('infoseminar/daftar',$key->id) }}" class="btn button-flash my-2 my-sm-0"><i class="fa fa-check-circle"> Daftar</i></a>
              {{-- </button> --}}

                {{-- <a href="{{ url('infoseminar/detail',$key->id) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                data-placement="top" title="Lihat Detail">Detail</a> --}}
                {{-- <a target="_blank" href="{{ $key->link }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                  data-placement="top" title="Lihat Brosur">Brosur</a> --}}
              @endif
            @endif
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endpush
