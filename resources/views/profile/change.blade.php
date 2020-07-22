@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
><section class="content-header">
    <h1>
      Ubah Password
      {{--  <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="#">Ubah Password</a></li>
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
                            <label for="password" class="col-md-2 col-form-label text-md-right">Konfirm Password Baru</label>
                            <div class="col-md-6">
                                <input id="confirmpassword" type="password" class="form-control" name="confirmpassword" required autocomplete="newpassword">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ url('profile') }}" class="btn btn-md btn-default pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

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
