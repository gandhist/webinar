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
        <div class="box-tools pull-right" style="margin-top:25px; margin-right:35px;">
            <div class="row">
                <div class="col-12">
                    <div style="margin-bottom:10px">
                        <a href="{{ url('import') }}" class="btn btn-info">
                            <i class="fa fa-save"></i> Import Peserta</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body" style="margin:25px;">
            <div class="row" style="margin-top:40px; margin-bottom: 25px;">
                <div class="col-12" style="margin: 30px 0px">
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
                            @foreach($pesertas as $peserta)
                            @php
                                $username =  preg_replace('/[^a-zA-Z0-9()]/', '_', $peserta->nama);
                            @endphp
                            <tr>
                                <td style='text-align:center'><input type="checkbox" data-id="{{ $peserta->id }}" class="selection"
                                    id="selection[]" name="selection[]"></td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->nama }}">
                                    <a href="{{ url('pesertas/'.$peserta->id) }}">
                                        {{ str_limit($peserta->nama,40) }}
                                    </a>
                                </td>
                                <td> {{ $peserta->no_hp }} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->email }}">
                                    {{ str_limit($peserta->email,30) }} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->instansi }}">
                                    @if($peserta->user_id != null)
                                    {{ str_limit($peserta->instansi,20 )}}
                                    @else
                                    {{ isset($peserta->badan_usaha) ? $peserta->badan_usaha->nama_bu : ''}}
                                    @endif
                                </td>
                                <td> {{ str_limit($peserta->pekerjaan, 20)}} </td>
                                <td data-toggle="tooltip" data-placement="bottom" title="{{ $peserta->alamat.', '.$peserta->kota.', '.$peserta->provinsi}}">
                                    {{ str_limit($peserta->alamat, 20) }} </td>
                                <td class="text-center">  {{ isset($peserta->tgl_lahir) ? \Carbon\Carbon::parse($peserta->tgl_lahir)->isoFormat("DD MMMM YYYY") : ''  }} </td>
                                <td class="text-center">
                                    {{-- <a href="{{ url('uploads/peserta/'.$peserta->foto)}}">Lihat</a> --}}
                                    <a data-toggle="modal" data-target="#myModal" data-link="{{isset($peserta->foto) ? url('uploads/peserta/'.$peserta->foto) : '' }}">
                                        Lihat <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Brosur Seminar</h4>
        </div>
        <div class="modal-body">
            <center>
            <img alt="Foto Diri" class="img-thumbnail center" style="width:50%">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $('#myModal').on('show.bs.modal', function(e) {
        let link = $(e.relatedTarget).data('link');
        $(e.currentTarget).find('img').attr('src',link);
    });
</script>
@endpush
