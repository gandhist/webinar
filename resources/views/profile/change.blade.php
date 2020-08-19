@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <div class="container" id="content">

        <!-- Default box -->
        <div class="box box-content">
            <div class="box-body">
                <h2 text-align="center">Ubah Password</h2>
                <hr>
                @if(session()->get('success'))
                    <div class="alert alert-success"> {{ session()->get('success') }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('changepassword') }}">  
                        @csrf

                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">Password Lama</label>
                            <div class="col-md-6">
                                <input id="oldpassword" type="password" class="form-control @error('password') is-invalid @enderror" name="oldpassword" required autocomplete="old-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">Password Baru</label>
                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control @error('password') is-invalid @enderror" name="newpassword" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">Konfirm Password</label>
                            <div class="col-md-6">
                                <input id="confirmpassword" type="password" class="form-control" name="confirmpassword" required autocomplete="newpassword">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ url('profile') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
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
