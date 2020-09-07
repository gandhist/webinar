@extends('frontend.main')

@section('content')
<style>

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<section class="newsWrap pb-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mr-auto ml-auto text-center">
          <h1>BERITA</h1>
          <hr>
          {{-- <p class="fz16">P3SM dibentuk atas inisiasi dari para "Stakeholder" beberapa Asosiasi dan beberapa Lembaga atau Perusahaan Sertifikasi yang berkeinginan membantu Pemerintah dalam penyampaian Regulasi terkait Sertifikasi ke seluruh pelosok Negeri.</p> --}}
        </div>
      </div>
      <div class="row News">
        {{-- @foreach($blogs as $results) --}}
        <div class="col-md-4 mb-4">
          <div class="card cardNews">
            {{-- <img class="card-img-top" src="{{asset('front/image/bannerAllPage/blogs/'.$results->image)}}" alt="Card image cap"> --}}
            <img class="card-img-top" src="{{ url('p3sm.jpeg') }}" alt="Card image cap">
            <div class="card-body">
              <div class="date">
                {{-- <h3 class="mb-0 text-white">{{ substr($results->created_at,0,2) }}</h3> --}}
                <h5 class="mb-0 text-black">07 September 2020</h5> <br>
                {{-- <p class="mb-0 text-white">{{bulanSaja($results->created_at)}}</p> --}}
              </div>
              {{-- <h5 class="card-title text-center">{{ucwords($results->title)}}</h5> --}}
              <h5 class="card-title text-center">PERTEMUAN PROFESI</h5>
              {{-- <p>{!! substr($results->description,0,200) !!}</p> --}}
              <p>PROBLEM, PELUANG DAN TANTANGAN PROFESI SANITASI DAN TATA LINGKUNGAN DALAM ERA COVID-19 DAN MILENIAL</p>
              {{-- <a href="{{url('blogs/'.$results->slug)}}" class="ReadMore m-auto">Read More</a> --}}
            </div>
          </div>
        </div>
          <div class="col-md-4 mb-4">
            <div class="card cardNews">
              {{-- <img class="card-img-top" src="{{asset('front/image/bannerAllPage/blogs/'.$results->image)}}" alt="Card image cap"> --}}
              <img class="card-img-top" src="{{ url('p3sm.jpeg') }}" alt="Card image cap">
              <div class="card-body">
                <div class="date">
                  {{-- <h3 class="mb-0 text-white">{{ substr($results->created_at,0,2) }}</h3> --}}
                  <h5 class="mb-0 text-black">07 September 2020</h5> <br>
                  {{-- <p class="mb-0 text-white">{{bulanSaja($results->created_at)}}</p> --}}
                </div>
                {{-- <h5 class="card-title text-center">{{ucwords($results->title)}}</h5> --}}
                <h5 class="card-title text-center">SAFETY CONSTRUCTION</h5>
                {{-- <p>{!! substr($results->description,0,200) !!}</p> --}}
                <p>THE POWER OF SMKK "Mengulas Tuntas Kebaruan Sistem Manajemen Keselamatan Konstruksi"</p>
                {{-- <a href="{{url('blogs/'.$results->slug)}}" class="ReadMore m-auto">Read More</a> --}}
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card cardNews">
              {{-- <img class="card-img-top" src="{{asset('front/image/bannerAllPage/blogs/'.$results->image)}}" alt="Card image cap"> --}}
              <img class="card-img-top" src="{{ url('p3sm.jpeg') }}" alt="Card image cap">
              <div class="card-body">
                <div class="date">
                  {{-- <h3 class="mb-0 text-white">{{ substr($results->created_at,0,2) }}</h3> --}}
                  <h5 class="mb-0 text-black">22 Agustus 2020</h5> <br>
                  {{-- <p class="mb-0 text-white">{{bulanSaja($results->created_at)}}</p> --}}
                </div>
                {{-- <h5 class="card-title text-center">{{ucwords($results->title)}}</h5> --}}
                <h5 class="card-title text-center">PERTEMUAN PROFESI</h5>
                {{-- <p>{!! substr($results->description,0,200) !!}</p> --}}
                <p>MEMPERSIAPKAN BUSINESS CONTINUITY MANAGEMENT MENUJU ERA SOCIETY 5.0 (POST COVID-19) DI INDONESIA</p>
                {{-- <a href="{{url('blogs/'.$results->slug)}}" class="ReadMore m-auto">Read More</a> --}}
              </div>
            </div>
          </div>
        {{-- @endforeach --}}
      </div>
    </div>
</section>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript" >

</script>
@endpush
