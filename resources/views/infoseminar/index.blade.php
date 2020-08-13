@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
  @if(session()->get('success'))
    <div class="alert alert-success"> {{ session()->get('success') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
  @endif
  <h2>Info Seminar P3SM</h2>
  <hr>
  <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead>
      <tr>
        <th style="width:2%;">No </th>
        <th>Tema </th>
        <th>Judul Seminar </th>
        <th>Tanggal :</th>
        <th>Tempat :</th>
        <th>Narasumber :</th>
        <th>Biaya :</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key)
      <tr>
          <td>{{ $loop->iteration}}</td>
          <td>{{ str_limit(strip_tags(html_entity_decode($key->tema)),40) }}</td>
          <td>{{ $key->nama_seminar }} {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td>
          <td>
            {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }} -
            {{ isset($key->tgl_akhir) ? \Carbon\Carbon::parse($key->tgl_akhir)->isoFormat("DD MMMM YYYY") : ''  }}
          </td>
          <td>{{ $key->lokasi_penyelenggara }}</td>
          <td>
            @foreach($key->seminar_r as $index => $select)
              @if(count($key->seminar_r) > $index + 1)
              {{ $select->peserta_r->nama }} -
              @else
              {{ $select->peserta_r->nama }}
              @endif
            @endforeach
          </td>
          <td>@if ($key->is_free == '0') Gratis @else Rp {{ format_uang($key->biaya)}} @endif</td>
          <td>
            @php
              if ($user == 'Error') {
                $cek = 0;
              } else {
                $cek = DB::table('srtf_peserta_seminar')->where('id_peserta',$user['id'])->where('id_seminar', $key->id)->where('deleted_at',null)->count();
              }
            @endphp
            @if($key->kuota_temp == 0)
            <button class="btn btn-primary disabled"> Kuota Peserta Sudah Penuh</button>
            @else
              @if($cek > 0)
              <button class="btn btn-success disabled"> Anda Sudah Mendaftar</button>
              @else
                <a href="{{ url('infoseminar/daftar',$key->id) }}" class="btn btn-outline-primary my-2 my-sm-0">Daftar</a>
                <a href="{{ url('infoseminar/detail',$key->id) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                data-placement="top" title="Lihat Detail">Detail</a>
                <a target="_blank" href="{{ $key->link }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                  data-placement="top" title="Lihat Brosur">Brosur</a>
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
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
@endpush
