@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
><section class="content-header">
    <h1>
      Edit User Profile
      {{--  <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="#">Edit Profile</a></li>
    </ol>
  </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-content">
            <div class="box-body">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}  
                    </div>
                    <br />
                @endif

                <form action="{{ route('profile.update') }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{ old('name', $user->peserta->foto) }}" placeholder="">
                            </div>
                            <div class="col-sm-1">
                                Nama :
                            </div>
                           
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{ old('name', $user->peserta->nama) }}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-1">
                                Email
                            </div>
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('email', $user->peserta->email)}}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-1">
                                No_HP
                            </div>
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('no_hp', $user->peserta->no_hp)}}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-1">
                                Pekerjaan
                            </div>
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('pekerjaan', $user->peserta->pekerjaan)}}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-1">
                                Instansi
                            </div>
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('instansi', $user->peserta->instansi)}}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <div class="col-sm-1">
                                Total Nilai SKPI
                            </div>
                            <div class="col-sm-3">
                                <input name="nama_seminar" id="nama_seminar" type="text" class="form-control" value="{{old('nama_seminar')}}" placeholder="">
                            </div>
                        </div>

                    </div>
                    
                    <div class="box-body">    
                        <b>Daftar Seminar yang telah di ikuti</b>
                        <table id="data-sekolah" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width:1%;">No</th>
                                    <th style="width:6%;">Title</th>
                                    <th style="width:19%;">Tema</th>
                                    <th style="width:7%;">Tanggal</th>
                                    <th style="width:10%;">Waktu</th>
                                    <th style="width:5%;">n_skpk</th>
                                    <th style="width:10%;">tambah_skpk</th>
                                    <th style="width:6%;">No_Srtf</th>
                                </tr>
                            </thead>
                            <tbody>  
                                {{-- {{ dd($seminar) }}; --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        <a href="{{ url('personil') }}" class="btn btn-md btn-default pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                        <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>

            <div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        

    </section>
    <!-- /.content -->
@endsection

@push('script')


<script>


$(function(){


});

$('.select2').select2()

$('.datepicker').datepicker({
    format: 'yyyy/mm/dd',
    autoclose: true
});

</script>
@endpush
