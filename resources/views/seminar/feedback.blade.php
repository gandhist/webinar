@extends('templates.header')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Feedback Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
     
      <div class="box-body">
        <h3>{{ $respons }} Responses</h3>
      </div>

    </div> {{-- Box-Content --}}


</section>

@endsection

@push('script')

<script>

</script>
@endpush
