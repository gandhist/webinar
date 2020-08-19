@extends('frontend.main')

@section('content')
<style>
    .jumbotron {
		background-image: url("p3sm.jpeg");
  		background-size: 100%;
		background-repeat:no-repeat;
		height: 350px
	}
	
	@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		.jumbotron {
            background-image: url("p3sm.jpeg");
            background-size: 100%;
            background-repeat:no-repeat;
        }
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
	<div class="jumbotron">
		<div class="welcome">
			<h1 style="margin-bottom:50px;">Selamat Datang di Website Sertifikat P3SM</h1>
			{{-- <a href="{{ url('login') }}" id="login" class="btn btn-success">Login</a> --}}
			<button href="#" class="btn btn-success btn-border-filled" id="login" >Login</button>
			{{-- <a href="{{ url('infoseminar') }}" class="btn btn-success">Daftar Seminar</a> --}}
			<button href="#" class="btn btn-success btn-border-filled" id="seminar" >Daftar Seminar</button>
		</div>
		<div class="login">
			<h2 class="head-title">Login</h2>
			<p>Silahkan Login dengan email dan password yang sudah terverifikasi.</p>
			<div class="col-sm-4">
				<form action="{{ url('login') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" name="username">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" name="password">
						<span class="glyphicon glyphicon-lock"></span>
					</div>
					<button type="submit" class="btn btn-primary">Sign In</button>
				{{-- <a href="{{ '' }}" class="btn btn-primary">Cancel</a> --}}
				</form>
			</div>
		</div>
	</div>
	<div class="seminar">
        <b>Daftar Seminar</b>
		<br>
        <table id="example" class="table table-bordered table-striped dataTable customTable" role="grid">
            <thead>
                <tr role="row">
                    <th style="width:2%;text-align:center;">No</th>
                    <th style="width:14%;text-align:center;">Tema</th>
                    <th style="width:17%;text-align:center;">Judul Seminar</th>
                    {{-- <th style="width:10%;text-align:center;">Tanggal</th> --}}
					<th style="width:5%;text-align:center;">Tempat</th>
					<th style="width:5%;text-align:center;">Biaya</th>
					<th style="width:5%;text-align:center;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key)
                <tr>
					<td style="text-align:center;">{{ $loop->iteration }}</td>
					<td>{{ str_limit(strip_tags(html_entity_decode($key->tema)),40) }}</td>
					<td>{{ $key->nama_seminar }} {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td>				
					{{-- <td style="text-align:center;">{{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td> --}}
					<td style="text-align:center;">{{ $key->lokasi_penyelenggara }}</td>
					<td>@if ($key->is_free == '0') Gratis @else Rp. {{ format_uang($key->biaya)}} @endif</td></td>
					<td style="text-align:center;">
						<a href="{{ url('infoseminar/detail',$key->id) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
						data-placement="top" title="Lihat Detail">Detail</a>
					</td>
                </tr>
                @endforeach
            </tbody>
        </table>
	</div>
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
<script type="text/javascript" >
	$('.login').hide();
	$('.welcome').fadeIn('slow');
	$('.seminar').hide();
	$(function() {
		$('#login').on('click', function(){
			$('.welcome').fadeOut('slow', function(){
        		$('.login').fadeIn('slow');
      		});
		});

		$('#seminar').on('click', function(){
			$('.seminar').fadeIn('slow');
		});
	});

	$(document).ready(function() {
		$('#example').DataTable();
	} );
</script>
@endpush