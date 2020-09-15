@extends('frontend.main')

@section('content')
<style>
.button-flash {
  background-color: #004A7F;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: Arial;
  font-size: 20px;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing 3000ms infinite;
  -moz-animation: glowing 3000ms infinite;
  -o-animation: glowing 3000ms infinite;
  animation: glowing 3000ms infinite;
}
@-webkit-keyframes glowing {
  0% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
  50% { background-color: #15ff00; -webkit-box-shadow: 0 0 40px #15ff00; }
  100% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
}

@-moz-keyframes glowing {
  0% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
  50% { background-color: #15ff00; -moz-box-shadow: 0 0 40px #15ff00; }
  100% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
}

@-o-keyframes glowing {
  0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
  50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
  100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
}

@keyframes glowing {
  0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
  50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
  100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container-fluid" id="content">
    <div class="box box-content">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ url('infoseminar/store', $data->id) }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf

                    @if(session()->get('magic_link'))
                    <input type="hidden" name="magic_link" value="{{ session()->get('magic_link') }}">
                    @endif
                    @if(session()->get('blast_target_id'))
                    <input type="hidden" name="blast_target_id" value="{{ session()->get('blast_target_id') }}">
                    @endif

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 text-align="center">Detail Seminar P<sub>3</sub>SM</h2>
                            </div>
                            <div class="col-md-4">
                                <h2 onclick="location.href='{{ url($data->link) }}'">Brosur Seminar</h2>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Jenis Kegiatan</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->nama_seminar }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Judul</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ strip_tags(html_entity_decode($data->tema)) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Narasumber</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly
                                            value="@foreach($data->seminar_r as $index => $key)@if(count($data->seminar_r) > $index + 1){{ $key->peserta_r->nama }},@else{{ $key->peserta_r->nama }}@endif @endforeach">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Kuota</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->kuota }} Peserta">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Biaya</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="@if ($data->is_free == '0') Gratis @else Rp {{ format_uang($data->biaya)}} @endif">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Tempat</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->lokasi_penyelenggara }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> Jadwal Kegiatan</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ isset($data->tgl_awal) ? \Carbon\Carbon::parse($data->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }} / {{ $data->jam_awal }} - {{ $data->jam_akhir }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess"> SKPK</label>
                                            <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->skpk_nilai }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        {{-- <a href="{{ url('infoseminar') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-times-circle"></i> Batal</a> --}}
                                        <button type="submit" class="btn button-flash pull-right"> <i class="fa fa-check-circle"></i> Daftar</button>
                                        {{-- <a target="_blank" href="{{ url($data->link) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                                            data-placement="top" title="Lihat Brosur">Brosur</a> --}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="box-body">
                                    <img src="{{ url($data->link) }}" onclick="location.href='{{ url($data->link) }}'" class="rounded img-fluid" alt="Brosur">
                                </div>
                            </div>
                        </div>

                    </div>

                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ url('infoseminar') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                                <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check-circle"></i> Daftar</button>
                                <a target="_blank" href="{{ url($data->link) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                                    data-placement="top" title="Lihat Brosur">Brosur</a>
                            </div>
                        </div>
                    </div> --}}
                    </form>
            </div>
        </div>
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
{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{$clientKey}}"></script> --}}
<script>
    $(document).ready(function() {
        $('#btnDaftar').on('click', function(e) {
            e.preventDefault();

            // is_free = {{$data->is_free}};
            // console.log(is_free);
            // snap.pay('', {
            //     // Optional
            //     onSuccess: function(result){
            //         console.log('sukses :');
            //         console.log(result);
            //         //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            //     },
            //     // Optional
            //     onPending: function(result){
            //         console.log('pending :');
            //         console.log(result);
            //         //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            //     },
            //     // Optional
            //     onError: function(result){
            //         console.log('werror :');
            //         console.log(result);
            //         //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            //     }
            // });
        });
    });

</script>
@endpush
