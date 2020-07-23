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
                    <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                @endif
                    
                <form action="{{ route('profile.update') }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <img style="width:100%;" src="{{ asset('uploads/peserta/'.$user->peserta->foto) }}" >
                            </div>
                            <div class="col-sm-6">
                                <table>
                                    <tr>
                                        <th style="width:20%;text-align:left">Nama</th>
                                        <td>:</td>
                                        <td><input name="nama" id="nama" type="text" class="form-control" value="{{ old('nama', $user->peserta->nama) }}" placeholder=""></td>
                                        
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Email</th>
                                        <td>:</td>
                                        <td><input name="email" id="email" type="text" class="form-control" value="{{old('email', $user->peserta->email)}}" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">No_HP</th>
                                        <td>:</td>
                                        <td><input name="no_hp" id="no_hp" type="text" class="form-control" value="{{old('no_hp', $user->peserta->no_hp)}}" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Pekerjaan</th>
                                        <td>:</td>
                                        <td><input name="pekerjaan" id="pekerjaan" type="text" class="form-control" value="{{old('pekerjaan', $user->peserta->pekerjaan)}}" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Instansi</th>
                                        <td>:</td>
                                        <td><input name="instansi" id="instansi" type="text" class="form-control" value="{{old('instansi', $user->peserta->instansi)}}" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Total Nilai SKPI</th>
                                        <td>:</td>
                                        <td><input name="nilai_skpi" id="nilai_skpi" type="text" class="form-control" value="{{old('nilai_skpi')}}" placeholder=""></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto" class="custom-file-input {{ $errors->first('foto') ? 'is-invalid' : '' }}" id="validatedCustomFile">
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-body">    
                        <b>Daftar Seminar yang telah di ikuti</b>
                        <a href="{{ url('changepassword') }}" class="btn btn-md btn-danger pull-right"><i class="fa fa-edit"></i> Ubah_Password</a>
                        <table id="data-sekolah" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width:2%;"><i class="fa fa-check-square-o"></i></th>
                                    <th style="width:2%;">No</th>
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
                                {{-- {{ dd($user->id) }}; --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        <a href="{{ url('#') }}" class="btn btn-primary pull-right"> Detail</a> 
                        <a href="{{ url('') }}" class="btn btn-md btn-default pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                        <button type="submit" class="btn btn-info pull-left"> <i class="fa fa-save"></i> Simpan</button>
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
