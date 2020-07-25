@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="box box-content">
        <form action="{{ url('infoseminar/store', $data->id) }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
            <h2 text-align="center">Pendaftaran Seminar P3SM</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Nama</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->nama }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Email</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="{{$user->peserta->email }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> No HP</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->no_hp }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Pekerjaan</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->pekerjaan }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Instansi</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->instansi }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Biaya Investasi</label>
                    <input type="text" class="form-control" id="inputSuccess" readonly value="Rp. {{ $data->is_free }}">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Metode Pembayaran</label>
                        {{-- <input type="text" class="form-control" id="inputSuccess" readonly value=""> --}}
                        <select class="form-control select2" name="id_nama_bank" id="id_nama_bank" style="width: 100%;" placeholder="Nama Bank">
                            <option value="" disabled selected>Nama Bank</option>
                            @foreach($bank as $key)
                            <option value="{{ $key->id_bank }}" {{ $key->id_bank == old('id_nama_bank') ? 'selected' : '' }}>{{ $key->Nama_Bank }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ url('infoseminar') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check-circle"></i> Daftar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>

</script>
@endpush
