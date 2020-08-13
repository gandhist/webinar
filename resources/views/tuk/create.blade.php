@extends('templates.header')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tambahkan Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Tambah</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="container-fluid">
            <div class="jumbotron" style='padding-top:1px'>
                <h1 style="margin-bottom:50px;">Seminar</h1>
                <form method="POST" action="{{ url('seminar/store') }}" enctype="multipart/form-data">
                @csrf

                </form>
            </div>
        </div>
    </div>
    <!-- END Default BOX -->
</section>
<!-- End MAIN -->
@endsection
