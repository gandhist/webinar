@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    span.indent{
        text-indent: 25px;
    }
</style>
<section class="content-header">
    <h1>
        Daftar Peserta
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Peserta</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body" style="margin:25px;">
            <div class="row" style="margin-top:40px; margin-bottom: 25;">
                <div class="col-12">
                    @if(session()->get('pesan'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session()->get('pesan') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th><span class="indent"><i class="fa fa-check-square-o"></i></span></th>
                                <th><span class="indent">No.</span></th>
                                <th><span class="indent">Nama</span></th>
                                <th><span class="indent">No. Hp</span></th>
                                <th><span class="indent">Email</span></th>
                                <th><span class="indent">Instansi</span></th>
                                <th><span class="indent">Pekerjaan</span></th>
                                <th><span class="indent">Alamat</span></th>
                                <th><span class="indent">Tanggal Lahir</span></th>
                                <th><span class="indent">Foto</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesertas as $peserta)
                            @php
                                $username =  preg_replace('/[^a-zA-Z0-9()]/', '_', $peserta->nama);
                            @endphp
                            <tr>
                                <td style='text-align:center'><input type="checkbox" data-id="{{ $peserta->id }}" class="selection"
                                    id="selection[]" name="selection[]"></td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->nama }}">
                                    <a href="{{ url('pesertas/'.$peserta->id) }}">
                                        {{ str_limit($peserta->nama,20) }}
                                    </a>
                                </td>
                                <td> {{ $peserta->no_hp }} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->email }}">
                                    {{ str_limit($peserta->email,20) }} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->instansi }}">
                                    {{ str_limit($peserta->instansi,20 )}}
                                </td>
                                <td> {{ str_limit($peserta->pekerjaan, 20)}} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->alamat.', '.$peserta->kota.', '.$peserta->provinsi}}">
                                    {{ str_limit($peserta->alamat, 20) }} </td>
                                <td class="text-center"> {{ $peserta->tgl_lahir }} </td>
                                <td class="text-center"> <a href="{{ url('uploads/peserta/'.$peserta->foto)}}">Lihat</a></td>
                            </tr>
                            @empty
                            <td colspan="10" class="text-center">Tidak ada data...</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
