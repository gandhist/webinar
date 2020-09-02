@extends('frontend.main')

@section('content')
<style>
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
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
  -o-animation: glowing 1500ms infinite;
  animation: glowing 1500ms infinite;
}
@-webkit-keyframes glowing {
  0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
}

@-moz-keyframes glowing {
  0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
}

@-o-keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
}

@keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
}



    .jumbotron {
		background-image: url("p3sm.jpeg");
  		background-size: 15%;
		background-repeat:no-repeat;
		height: 250px;
		background-color: #f7f7f7 !important;
		background-position-x: 98%;
		background-position-y: 55%;
	    margin-top:10px;
	}

	@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		.jumbotron {
            background-image: url("p3sm.jpeg");
            background-size: 10%;
            background-repeat:no-repeat;
			height: 250px;
			background-position-x: 50%;
			background-position-y: 1%;
			margin: 10px;
        }
		.welcome{
			margin-top: 23px;
		}
		.login{
			margin-top: 23px;
		}
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">


<script>
    FontAwesomeConfig = { autoReplaceSvg: false }
</script>
<div class="container">


	<div class="jumbotron">
		<div class="welcome">
			<h2>Program Pengembangan Keprofesian Berkelanjutan</h2>
			<p>Pusat Pembinaan Pelatihan & Sertifikasi Mandiri</p>
			{{-- <a href="{{ url('login') }}" id="login" class="btn btn-success">Login</a> --}}
            @if(Auth::guest())
            <button href="#" class="btn btn-success btn-border-filled m-2" id="login" >Login</button>
            <a href="{{url('login/google')}}" style="color: white" class="btn btn-danger m-2">
                <i class="fa fa-google fa-fw"></i> Login with Google Account
            </a>
            @else
            <div style="height: 60px;"></div>
            @endif
			{{-- <a href="{{ url('infoseminar') }}" class="btn btn-success">Daftar Seminar</a> --}}
			{{-- <button href="#" class="btn btn-success btn-border-filled" id="seminar" >Daftar Seminar</button> --}}
		</div>
		<div class="login">
			<h2 class="head-title">Login</h2>
			<p>Silahkan Login dengan email yang sudah terverifikasi.</p>
			<div class="col-sm-6">
				<form action="{{ url('login') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" class="form-control select2" placeholder="Email" name="username" id="username">
						{{-- <span class="glyphicon glyphicon-user form-control-feedback"></span> --}}
						<div id="name">

						</div>
					</div>
					{{-- <div class="form-group">
						<input type="password" class="form-control" placeholder="Password" name="password">
						<span class="glyphicon glyphicon-lock"></span>
					</div> --}}
					<button type="submit" class="btn btn-success btn-border-filled m-2">Login</button>
					<a href="{{url('login/google')}}" style="color: white" class="btn btn-danger m-2">
						<i class="fa fa-google fa-fw"></i> Login with Google Account
					</a>
				{{-- <a href="{{ '' }}" class="btn btn-primary">Cancel</a> --}}
				</form>
			</div>
		</div>
	</div>
	@if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
	@endif
	@if(session()->get('warning'))
		<div class="alert alert-warning"> {{ session()->get('warning') }}
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
	@endif
	@if(session()->get('errors'))
		<div class="alert alert-warning"> {{ session()->get('errors') }}
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
  	@endif
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
					<th style="width:5%;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key)
                <tr>
					<td style="text-align:center;">{{ $loop->iteration }}</td>
					<td>{{ strip_tags(html_entity_decode($key->tema)) }}</td>
					<td>{{ $key->nama_seminar }} {{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td>
					{{-- <td style="text-align:center;">{{ isset($key->tgl_awal) ? \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") : ''  }}</td> --}}
					<td style="text-align:center;">{{ $key->lokasi_penyelenggara }}</td>
					<td>@if ($key->is_free == '0') Gratis @else Rp. {{ format_uang($key->biaya)}} @endif</td></td>
					<td style="text-align:center;">
						@if($key->kuota_temp <= 0)
						<button class="btn btn-primary disabled"> Kuota Sudah Penuh</button>
						@else
                        <a href="{{ isset($key->slug) ? url('registrasi/daftar',$key->slug) : url('registrasi/daftar',$key->id)}}"
                            class="btn button-flash my-2 my-sm-0" data-toggle="tooltip"
						data-placement="top" title="Daftar Seminar">Daftar</a>
						@endif
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
	// $('.seminar').hide();
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
	$('#username').keyup(function(){
        var query = $(this).val();
        if(query != '') {
			var _token = $('input[name="_token"]').val();
			$.ajax({
			url:"{{ route('autocomplete.fetch') }}",
			method:"POST",
			data:{query:query, _token:_token},
			success:function(data){
				$('#name').fadeIn();
							$('#name').html(data);
				}
			});
        }
    });
	$(document).on('click', 'li', function(){
        $('#username').val($(this).text());
        $('#name').fadeOut();
    });
</script>
@endpush
