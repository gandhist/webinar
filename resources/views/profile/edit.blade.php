@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <div class="container">
        <!-- Default box -->
        <div class="box box-content">
            <div class="box-body">
            <h2 text-align="center">Edit Profile</h2>
            <hr>
                @if(session()->get('success'))
                    <div class="alert alert-success"> {{ session()->get('success') }} 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
                    </div>   
                @endif
                    
                <form action="{{ route('profile.update') }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <img style="width:100%;" src="{{ asset('uploads/peserta/'.$user->peserta->foto) }}" >
                            </div>
                            <div class="col-sm-6">
                                <table>
                                    <tr>
                                        <th style="width:20%;text-align:left">Nama</th>
                                        <td>:</td>
                                        <td><input name="nama" id="nama" type="text" class="form-control" value="{{ old('nama', $user->peserta->nama) }}"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Email</th>
                                        <td>:</td>
                                        <td><input name="email" id="email" type="text" class="form-control" value="{{old('email', $user->peserta->email)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">No_HP</th>
                                        <td>:</td>
                                        <td><input name="no_hp" id="no_hp" type="text" class="form-control" value="{{old('no_hp', $user->peserta->no_hp)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Pekerjaan</th>
                                        <td>:</td>
                                        <td><input name="pekerjaan" id="pekerjaan" type="text" class="form-control" value="{{old('pekerjaan', $user->peserta->pekerjaan)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%;text-align:left">Instansi</th>
                                        <td>:</td>
                                        <td><input name="instansi" id="instansi" type="text" class="form-control" value="{{old('instansi', $user->peserta->instansi)}}"></td>
                                    </tr>
                                    <tr>
                                        <th style="width:24%;text-align:left">Total Nilai SKPI Pertahun</th>
                                        <td>:</td>
                                        <td><input name="nilai_skpi" id="nilai_skpi" type="text" class="form-control" value="{{old('nilai_skpi')}}" readonly></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="foto" name="foto"  {{ $errors->first('foto') ? 'is-invalid' : '' }}" >
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="box-body">    
                        <b>Daftar Seminar yang telah di ikuti</b>
                        
                        <table id="data-seminar" class="table table-bordered table-hover dataTable customTable customTableDetail" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width:2%;"><i class="fa fa-check-square"></i></th>
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
                                @foreach($detailseminar as $key)
                                <tr>
                                    <td></td>
                                    <td style="text-align:center;">{{$loop->iteration}}</td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="title_{{$loop->iteration}}" id="title_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="tema_{{$loop->iteration}}" id="tema_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="tanggal_{{$loop->iteration}}" id="tanggal_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="waktu_{{$loop->iteration}}" id="waktu_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="nilai_{{$loop->iteration}}" id="nilai_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="tambah_{{$loop->iteration}}" id="tambah_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" 
                                        name="no_srtf_{{$loop->iteration}}" id="no_srtf_{{$loop->iteration}}"
                                        value="{{$key->id_seminar}}" readonly>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        {{-- <a href="{{ url('#') }}" class="btn btn-primary pull-left"> Detail</a>  --}}
                        <a href="{{ url('changepassword') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-edit"></i> Ubah_Password</a>
                        <a href="{{ url('infoseminar') }}" class="btn btn-md btn-danger pull-right"><i class="fa fa-times-circle"></i> Batal</a>
                        <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>

            <div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
    </div>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>

</script>
@endpush
