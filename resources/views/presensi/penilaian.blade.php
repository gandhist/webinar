@extends('frontend.main')

@section('content')
<style>
    form label.required:after {
        color: red;
        content: " *";
    }
    p {
        color: red;
    }
    .rating {
        display: block;
        direction: rtl;
        unicode-bidi: bidi-override;
        text-align: center;
    }
    .rating .star {
        display: none;
    }
    .rating label {
        color: white;
        display: inline-block;
        font-size: 2rem;
        margin: 0 -2px;
        transition: transform .15s ease;
    }
    .rating label:hover {
        transform: scale(1.35, 1.35);
    }
    .rating label:hover,
    .rating label:hover ~ label {
        color: orange;
    }
    .rating .star:checked ~ label {
        color: orange;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container" id="content">
    @if(session()->get('success'))
        <div class="alert alert-success">{{ session()->get('success') }}
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    @endif

    @if(session()->get('pesan'))
        <div class="alert alert-warning">{!! session()->get('pesan') !!}
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-2">

        </div>
        <div class="col-lg-8">
        <h2>Presensi Webinar "{{ strip_tags(html_entity_decode($peserta_seminar->seminar_p->tema)) }}" </h2>
            <p>* Wajib</p>
            <hr>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <main role="main" class="container">
        <form action="{{ url('presensi/pulang', $peserta_seminar->id) }}" class="form-horizontal" id="formReview" name="formReview"
                method="post" enctype="multipart/form-data">
        @csrf

            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <br>
                            <label for="seminar" class="label-control required"><b>Penilaian untuk penyelenggara secara keseluruhan?</b></label>
                            <div class="rating d-flex justify-content-end">
                                <span class="align-self-center ml-4" id="for-seminar[{{$peserta_seminar->seminar_p->id}}]"></span>
                                @for ($i = 5; $i > 0; $i--)
                                <input id="radio-seminar-{{$i}}" type="radio"
                                name="seminar[{{$peserta_seminar->seminar_p->id}}]" value="{{$i}}"
                                class="star" required/>
                                <label for="radio-seminar-{{$i}}"

                                @switch($i)
                                    @case(1)
                                        title = 'Sangat Buruk'
                                        @break
                                    @case(2)
                                        title = 'Buruk'
                                        @break
                                    @case(3)
                                        title = 'Cukup Baik'
                                        @break
                                    @case(4)
                                        title = 'Baik'
                                        @break
                                    @case(5)
                                        title = 'Luar Biasa'
                                        @break
                                    @default
                                        title = 'Tidak tersedia'
                                @endswitch
                                data-toggle="tooltip" data-placement="bottom"
                                >&#9733;</label>
                                @endfor
                            </div>
                            <span id="seminar" class="invalid-feedback">{{ $errors->first('seminar') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>

            @foreach($narasumber as $n)
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <br>
                            <label for="narasumber" class="label-control required"><b>Penilaian untuk {{$n->peserta_r->nama}} sebagai Narasumber?</b></label>
                            <div class="rating d-flex justify-content-end">
                                <span class="align-self-center ml-4" id="for-narasumber[{{$n->peserta_r->id}}]"></span>
                                @for ($i = 5; $i > 0; $i--)
                                <input id="radio-narasumber-{{"$loop->iteration-$i"}}" type="radio"
                                name="narasumber[{{$n->peserta_r->id}}]" value="{{$i}}" class="star"
                                {{old("narasumber[$loop->iteration]") == $i ? "selected" : ''}} required/>
                                <label for="radio-narasumber-{{"$loop->iteration-$i"}}"
                                    @switch($i)
                                        @case(1)
                                            title = 'Sangat Buruk'
                                            @break
                                        @case(2)
                                            title = 'Buruk'
                                            @break
                                        @case(3)
                                            title = 'Cukup Baik'
                                            @break
                                        @case(4)
                                            title = 'Baik'
                                            @break
                                        @case(5)
                                            title = 'Luar Biasa'
                                            @break
                                        @default
                                            title = 'Tidak tersedia'
                                    @endswitch
                                    data-toggle="tooltip" data-placement="bottom"
                                    >&#9733;</label>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>
            @endforeach

            @foreach($moderator as $m)
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <br>
                            <label for="moderator" class="label-control required"><b>Penilaian untuk {{$m->peserta_r->nama}} sebagai Moderator?</b></label>
                            <div class="rating d-flex justify-content-end">
                                <span class="align-self-center ml-4" id="for-moderator[{{$m->peserta_r->id}}]"></span>
                                @for ($i = 5; $i > 0; $i--)
                                <input id="radio-moderator-{{"$loop->iteration-$i"}}"
                                type="radio" name="moderator[{{$m->peserta_r->id}}]" value="{{$i}}" class="star"
                                {{old("moderator[$loop->iteration]") == $i ? "selected" : ''}} required/>
                                <label for="radio-moderator-{{"$loop->iteration-$i"}}"

                                    @switch($i)
                                        @case(1)
                                            title = 'Sangat Buruk'
                                            @break
                                        @case(2)
                                            title = 'Buruk'
                                            @break
                                        @case(3)
                                            title = 'Cukup Baik'
                                            @break
                                        @case(4)
                                            title = 'Baik'
                                            @break
                                        @case(5)
                                            title = 'Luar Biasa'
                                            @break
                                        @default
                                            title = 'Tidak tersedia'
                                    @endswitch
                                    data-toggle="tooltip" data-placement="bottom"
                                    >&#9733;</label>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>
            @endforeach

            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <br>
                            <label for="kesan_pesan" class="label-control required"><b>Kesan & Pesan untuk Penyelenggara, Pengantar Diskusi, Narasumber, dan Moderator?</b></label>
                            <textarea name="kesan_pesan" id="kesan_pesan" class="form-control" required></textarea>
                            <span id="kesan_pesan" class="invalid-feedback">{{ $errors->first('kesan_pesan') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8 card" style="width: 100%;background-color:#b7d0ed">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <br>
                            <label for="keterangan" class="label-control required"><b>Apakah ada topik yang dipandang penting dan perlu untuk diangkat dalam webinar selanjutnya? </b></label>
                            <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                            <span id="keterangan" class="invalid-feedback">{{ $errors->first('keterangan') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8" style="width: 100%;">
                    <button type="submit" class="btn btn-outline-dark btn-block">Submit</button>
                    {{-- <a href="{{ url('') }}" class="btn btn-outline-info">Batal</a> --}}
                <div class="col-lg-2">
                </div>
            </div>

      </form>
    </main>

</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $("#foto").change(function(){
        readURL(this);
    });
    $("input.star[type=radio]").on("click mouseover hover",function(e) {
        var nama = e.target.name;
        var nilai = e.target.value;
        // console.log((nilai));
        switch(nilai) {
            case '1':
                // code block
                el = document.getElementById("for-"+nama);
                el.textContent = 'Sangat Buruk';
                // console.log($("#for-"+nama));
                break;
            case '2':
                // code block
                el = document.getElementById("for-"+nama);
                el.textContent = 'Buruk';
                // console.log($("#for-"+nama));
                break;
            case '3':
                // code block
                el = document.getElementById("for-"+nama);
                el.textContent = 'Cukup Baik';
                // $("#for-"+nama).val('Cukup Baik');
                // console.log($("#for-"+nama));
                break;
            case '4':
                // code block
                el = document.getElementById("for-"+nama);
                el.textContent = 'Baik';
                // $("#for-"+nama).val('Baik');
                // console.log($("#for-"+nama));
                break;
            case '5':
                // code block
                el = document.getElementById("for-"+nama);
                el.textContent = 'Luar Biasa';
                // $("#for-"+nama).val('Luar Biasa');
                // console.log($("#for-"+nama));
                break;
            default:
                // code block
        }
    });
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            delay: { "show": 0, "hide": 100 },
        })
    })
  }

</script>
@endpush
