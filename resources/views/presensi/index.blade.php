@extends('frontend.main')

@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container" id="content">
    <h2 text-align="center">Halaman Peserta Seminar</h2>
    {{ $peserta_seminar }}
        <hr>
        @if($cek_in == false)
            Nama Peserta : {{ $peserta_seminar->peserta_r->nama }}<br><br>
            Tema Seminar : {{ strip_tags($peserta_seminar->seminar_p->tema) }}<br><br>
            Tanggal & Waktu : {{ \Carbon\Carbon::parse($peserta_seminar->seminar_p->tgl_awal)->isoFormat('DD MMMM YYYY') }} / {{ $peserta_seminar->seminar_p->jam_awal }}<br>
        
            <a target="_blank" href="{{ $peserta_seminar->seminar_p->url }}">LINK ZOOM!!!</a><br>
            <a target="_blank" href="{{ $peserta_seminar->seminar_p->url2 }}">LINK YOUTUBE!!!</a>
            <hr>
        @else
            Nama Peserta : {{ $peserta_seminar->peserta_r->nama }}<br><br>
            Tema Seminar : {{ strip_tags($peserta_seminar->seminar_p->tema) }}<br><br>
            Tanggal & Waktu : {{ \Carbon\Carbon::parse($peserta_seminar->seminar_p->tgl_awal)->isoFormat('DD MMMM YYYY') }} / {{ $peserta_seminar->seminar_p->jam_awal }}<br>
            <hr>
            Klik link zoom untuk mengikuti seminar 
        @endif
        
       
        @if(session()->get('status'))
        <div class="row">
            <div class="col-lg-6">
                <div class="alert alert-warning" role="alert">
                {{ session()->get('status') }}
                </div>
            </div>
        </div>
        @endif
        <form method="POST" name="formAdd" id="formAdd">
            <div class="row">
                <div class="col-md-6">
                    {{-- @if($cek_in)
                    <input type="button" class="btn btn-sm btn-success" onClick="absen_masuk()" value="Absen Masuk">
                    @else
                        @if($cek_out)
                        <input type="button" class="btn btn-sm btn-danger" onClick="absen_keluar()" value="Absen Keluar">
                        @else
                        @endif
                    @endif --}}
                    @if(isset($data[0]->jam_cek_in) && !isset($data[0]->jam_cek_out))
                    Jika seminar sudah selesai mohon isi kuisioner dibawah<br>
                    <input type="button" class="btn btn-sm btn-danger" onClick="absen_keluar()" value="KUISIONER">
                    @elseif(isset($data[0]->jam_cek_in) && isset($data[0]->jam_cek_out))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Terimakasih, Anda telah selesai mengikuti seminar.
                        </div>
                    @elseif((!isset($data[0]->jam_cek_in) && !isset($data[0]->jam_cek_out)))
                    
                    <input type="button" class="btn btn-sm btn-success" onClick="absen_masuk()" value="ZOOM">
                    @endif
                </div>
            </div>
        </form>
    <br>

    {{-- <div class="row">
        <div class="col-lg-12">
            <h3>Daftar Presensi Anda</h3>
            <table class="table">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($key->tanggal)->isoFormat('DD MMMM YYYY') }}</td>
                        <td>{{ $key->jam_cek_in }}</td>
                        <td>{{ $key->jam_cek_out }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div> --}}
</div>


@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>

<script>
var home = "{{ url('presensi', $id_encrypt) }}";
var home_url = "{{ $peserta_seminar->seminar_p->url }}";
var home_rating = "{{ url('presensi/penilaian', $id_encrypt) }}";
var home_srtf = "{{ url('sertifikat', \Crypt::encrypt($peserta_seminar->no_srtf)) }}";

var msg = '{{Session::get('alert')}}';
var exist = '{{Session::has('alert')}}';
    if(exist){
        Swal.fire({
            title: msg,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                    window.open(home_srtf);
                }
            });
        }

function absen_masuk() {
    var formData = new FormData($('#formAdd')[0]);
    var url = "{{ url('presensi/datang', $peserta_seminar->id) }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
    url: url,
    type: 'GET',
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
        if (response.status) {
            // Swal.fire({
            //     title: response.message,
            //     type: 'success',
            //     confirmButtonText: 'Close',
            //     confirmButtonColor: '#AAA',
            //     onClose: function() {
                    window.open(home_url);
                    window.location.replace(home);
                // }
            // })
        }
        else if (response.status) {
            Swal.fire({
                title: response.message,
                type: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor: '#AAA',
                onClose: function() {
                    window.location.open(home);
                }
            })
        }
        else {
            Swal.fire({
            title: response.message,
            type: 'error',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
                onClose: function() {
                }
            })
            $('#alert').text(response.message).show();
        }
    },
        error: function(xhr, status) {
            alert('error saat absen');
        }
    });
}

function absen_keluar() {
    var formData = new FormData($('#formAdd')[0]);
    var url = "{{ url('presensi/pulang', $peserta_seminar->id) }}";
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
        if (response.status) {
            // Swal.fire({
            //     title: response.message,
            //     type: 'error',
            //     confirmButtonText: 'Close',
            //     confirmButtonColor: '#AAA',
            //     onClose: function() {
                    // if(response.code == 10) {
                        window.location.replace(home_rating);
                    // }        
            //     }
            // })
        }  else {
            Swal.fire({
            title: response.message,
            type: 'error',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
                // onClose: function() {
                    // window.location.replace(home_rating);
                // }
            })
            $('#alert').text(response.message).show();
        }
    },
        error: function(xhr, status) {
            alert('error saat absen');
        }
    });
}

</script>
@endpush
