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
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <div class="btn-group">
                            <span class="form-group">
                                <input type="text" style="padding-bottom:5px;" name="filter_level" id="filter_level" value="{{ request()->get('filter_level') }}" placeholder="Level Kantor">
                                <input type="text" style="padding-bottom:5px;" name="filter_prov" id="filter_prov" value="{{ request()->get('filter_prov') }}" placeholder="Provinsi">

                                <button class="btn btn-info btn-bermargin" id="btnFilter" name="btnFilter">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <button class="btn btn-success btn-bermargin" id="btnReset" name="btnReset">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </button>
                                {{-- <a href="{{ url('seminar') }}" class="btn btn-sm btn-default"> <i
                                    class="fa fa-refresh"></i>
                                Reset</a> --}}

                                {{-- https://datatables.net/examples/plug-ins/range_filtering.html --}}

                            </span>
                        </div>
                        <button type="button" class="btn btn-danger pull-right" id="btnHapus" name="btnHapus">
                            <i class="fa fa-trash"></i> Hapus</button>
                        <button class="btn btn-success pull-right" id="btnEdit" name="btnEdit">
                            <i class="fa fa-edit"></i> Ubah</button>
                        <a href="{{ url('kantor/create') }}" class="btn btn-info pull-right">
                            <i class="fa fa-plus"></i> Tambah</a>
                    </div>
                    <div class="col-12" style="margin-top:10px">
                        <input type="text" style="padding-bottom:5px;" name="filter_atasnya" id="filter_atasnya" value="{{ request()->get('filter_atasnya') }}" placeholder="Kantor Level Diatasnya">
                        <input type="text" style="padding-bottom:5px;" name="filter_kota" id="filter_kota" value="{{ request()->get('filter_kota') }}" placeholder="Kota">

                        {{-- <div class="pull-right">
                        <button type="button" class="btn btn-primary pull-right" id="btnDetail" name="btnDetail">
                            <i class="fa fa-eye"></i> Detail</button>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                            <thead>
                                <tr>
                                    <th style='padding-left: 3rem;'><i class="fa fa-check-square-o"></i></th>
                                    <th style='padding-left: 3rem;'>No.</th>
                                    <th>Nama_Ktr</th>
                                    <th>Level_K</th>
                                    <th>Prov</th>
                                    <th>Kota</th>
                                    <th>Nama_Pimp</th>
                                    <th>Kontak_P</th>
                                    <th>Keterangan</th>
                                    <th>User_Tgl_Tambah</th>
                                    <th>User_Tgl_Ubah</th>
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
                                    <td>{{\Carbon\Carbon::parse($key->created_at)->format('d F Y')}}</td>
                                    <td>{{\Carbon\Carbon::parse($key->updated_at)->format('d F Y')}}</td>
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
