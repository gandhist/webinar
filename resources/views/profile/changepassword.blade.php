@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Ubah Password
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Update Password
                        </div>
    
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @method('patch')
                                @csrf
    
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
    
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    </div>
                                </div>
    
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
    
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
    
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
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
