@extends('templates/header')

@section('content')
<style>
    html, body, .wrapper, .content-wrapper {
        min-height: 100vh !important;
    }
    .content-wrapper{
        background-image: url('{{url("favicon.png")}}');
        background-repeat: no-repeat;
        background-position-x: 50%;
        background-position-y: 50%;
    }
    .col-md-4{
        min-height: 100vh;
    }
    .row {
        min-width: 100%;
    }
    .flex-container {
        margin-top: 10.5rem;
        min-height: 85vh;
        /* min-width: 90vh; */
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-content: center;
        align-items: center;
    }
    .box {
        height: 250px;
        width: 250px;
        border-radius: 20%;
        overflow: hidden;
        box-shadow:
            0 2.8px 2.2px rgba(0, 0, 0, 0.034),
            0 6.7px 5.3px rgba(0, 0, 0, 0.048),
            0 12.5px 10px rgba(0, 0, 0, 0.06),
            0 22.3px 17.9px rgba(0, 0, 0, 0.072),
            0 41.8px 33.4px rgba(0, 0, 0, 0.086),
            0 100px 80px rgba(0, 0, 0, 0.12)
            ;
    }
    .box-child{
        width: 100%;
        height: 50%;
    }
    .box-child>.head {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.086);
        font-size: 35px;
        text-align: center;
        vertical-align: middle;
        padding: 1rem 2rem;
    }
    .box-child>.body {
        width: 100%;
        height: 100%;
        background-color: rgba(32, 18, 18, 0.71);
        color: white;
        font-size: 75px;
        text-align: center;
        vertical-align: middle;

    }
</style>
	<section class="content-header">
	  <h1>
	    Dashboard App P3S Mandiri Online
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	  </ol>
	</section>
	<section class="content">
		<div class="row">
            <div class="col-md-4">
                <div class="flex-container">
                    <div class="box">
                        <div class="box-child"><div class="head">Total Pengguna</div></div>
                        <div class="box-child"><div class="body">{{$total_user}}</div></div>
                    </div>
                    <div class="box">
                        <div class="box-child"><div class="head">Total <br> Peserta</div></div>
                        <div class="box-child"><div class="body">{{$total_peserta}}</div></div>
                    </div>
                    <div class="box">
                        <div class="box-child"><div class="head">Pengguna Login</div></div>
                        <div class="box-child"><div class="body">{{$user_login}}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="flex-container">
                    <div class="box">
                        <div class="box-child"><div class="head">Pengguna Daftar Hari Ini</div></div>
                        <div class="box-child"><div class="body">{{$user_hari_ini}}</div></div>
                    </div>
                    <div class="box">
                        <div class="box-child"><div class="head">Peserta Daftar Hari Ini</div></div>
                        <div class="box-child"><div class="body">{{$peserta_hari_ini}}</div></div>
                    </div>
                    <div class="box">
                        <div class="box-child"><div class="head">Seminar Tersedia</div></div>
                        <div class="box-child"><div class="body">{{$seminar}}</div></div>
                    </div>
                </div>
            </div>
		</div>
	</section>
@endsection
