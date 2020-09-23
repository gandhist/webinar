@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Daftar Kantor PJS_LPJK - Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Kantor</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-check-square-o"></i></th>
                                    <th>No.</th>
                                    <th>Nama_Ktr</th>
                                    <th>Level_K</th>
                                    <th>Prov</th>
                                    <th>Kota</th>
                                    <th>Nama_Pimp</th>
                                    <th>Kontak_P</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kantor as $key)
                                <tr>
                                    <td style='text-align:center'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{$key->nama_kantor}}</td>
                                    <td>{{$key->level}}</td>
                                    <td>{{$key->prop}}</td>
                                    <td>{{$key->kota}}</td>
                                    <td>{{$key->nama_pimp}}</td>
                                    <td>{{$key->kontak_p}}</td>
                                    <td>{{$key->keterangan}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
